<?php
  namespace App\Core\Interfaces;
  interface IFileService
  {
    public function check_file_exist(string $filename): bool;
    public function download_file(string $filename): mixed;
    public function upload_file(mixed $stream, string $filename): void;
  }
?>