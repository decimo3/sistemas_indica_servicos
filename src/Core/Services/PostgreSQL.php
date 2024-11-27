<?php
  namespace App\Core\Services;
  use PgSql\Connection;
  use App\Core\Interfaces\IDatabase;
  use App\Core\Exceptions\DatabaseException;
  abstract class PostgreSQL implements IDatabase
  {
    private string $scon;
    private ?Connection $connection = null;
    function __construct()
    {
      $host = getenv("POSTGRES_HOST");
      $port = getenv("POSTGRES_PORT");
      $base = getenv("POSTGRES_DB");
      $user = getenv("POSTGRES_USER");
      $pass = getenv("POSTGRES_PASSWORD");
      $this->scon = "host=$host port=$port dbname=$base user=$user password=$pass";
      $this->connection = pg_connect($this->scon);
      if(!$this->connection)
      {
        throw new DatabaseException("Não pode se conectar ao banco de dados!");
      }
    }
    public function test_connected(): bool
    {
      return $this->connection !== null;
    }
    public function query(string $query): mixed
    {
      if (!$this->connection)
      {
        throw new \Exception("No active connection.");
      }
      $result = pg_query($this->connection, $query);
      if ($result === false)
      {
        throw new DatabaseException("Query execution failed: " . pg_last_error($this->connection));
      }
      return pg_fetch_all($result);
    }
    function __destruct()
    {
      if ($this->connection)
      {
        pg_close($this->connection);
        $this->connection = null;
      }
    }
  }
?>