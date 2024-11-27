<?php
  namespace App\Core\Interfaces;
  interface IDatabase
  {
    public function test_connected(): bool;
    public function query(string $query): mixed;
  }
?>