<?php
  namespace App\Core\Interfaces;
  interface IDatabase
  {
    public function open_connection(): void;
    public function test_connected(): bool;
    public function query(string $query): mixed;
    public function close_connection(): void;
  }
?>