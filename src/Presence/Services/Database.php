<?php
  namespace App\Presence\Services;
  class Database extends PostgreSQL
  {
    public function __construct()
    {
      parent::__construct();
    }
    public function __destruct()
    {
      parent::__destruct();
    }
  }
?>