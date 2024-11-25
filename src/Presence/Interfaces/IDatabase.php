<?php
  namespace App\Presence\Interfaces;
  use App\Presence\Schemas\ResultPresenceList;
  interface IDatabase
  {
    public function get_all_presence(int $page): array;
    public function get_mat_presence(int $matricula, int $page): array;
    public function set_one_presence(ResultPresenceList $presence): void;
  }
?>