<?php
  namespace App\Presence\Services;
  use App\Core\Services\Database;
  use App\Presence\Interfaces\IDatabase;
  use App\Presence\Schemas\ResultPresenceList;
  abstract class PostgreSQL extends Database implements IDatabase
  {
    public const DEFAULT_PAGE_SIZE = 100;
    function get_all_presence(int $page): array
    {
      $limit = $page * self::DEFAULT_PAGE_SIZE;
      $offset = $limit - self::DEFAULT_PAGE_SIZE;
      return parent::query("SELECT * FROM presences LIMIT $limit OFFSET $offset");
    }
    function get_mat_presence(int $matricula, int $page): array
    {
      $limit = $page * self::DEFAULT_PAGE_SIZE;
      $offset = $limit - self::DEFAULT_PAGE_SIZE;
      return parent::query("SELECT * FROM presences WHERE matricula = '$matricula' LIMIT $limit OFFSET $offset");
    }
    function set_one_presence(ResultPresenceList $presence): void
    {
      parent::query("INSERT INTO presences (matricula, timestamp, singularity, state) VALUES ($presence->matricula, '$presence->timestamp', $presence->singularity, $presence->state)");
    }
  }
?>