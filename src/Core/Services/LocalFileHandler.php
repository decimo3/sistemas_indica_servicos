<?php
  namespace App\Core\Services;
  use App\Core\Interfaces\IFileService;
  use App\Core\Exceptions\FileHandlerException;
  abstract class LocalFileService implements IFileService
  {
    private string $filepath;
    public function __construct()
    {
      $this->filepath = getenv("FILE_SERVER");
      if(!is_writable($this->filepath))
      {
        throw new FileHandlerException("O diretório não permite escrita!");
      }
    }
    public function check_file_exist(string $filename): bool
    {
      return file_exists($this->filepath . $filename);
    }
    public function download_file(string $filename): mixed
    {
      if(!$this->check_file_exist($filename))
      {
        throw new FileHandlerException("O arquivo não foi encontrado!");
      }
      $handle = fopen($this->filepath . $filename, "rb");
      if(!$handle)
      {
        throw new FileHandlerException("Erro ao abrir o arquivo para leitura!");
      }
      $contents = stream_get_contents($handle);
      fclose($handle);
      if ($contents === false)
      {
        throw new FileHandlerException("Erro ao ler o conteúdo do arquivo!");
      }
      return $contents;
    }
    public function upload_file(mixed $stream, string $filename): void
    {
      if(!$this->check_file_exist($filename))
      {
        throw new FileHandlerException("O arquivo já existe na pasta!");
      }
      if(!is_resource($stream))
      {
        throw new FileHandlerException("O conteúdo fornecido não é um stream válido.");
      }
      rewind($stream); // Reset the pointer for streams
      $handle = fopen($this->filepath . $filename, "wb");
      if(!$handle)
      {
        throw new FileHandlerException("Erro ao abrir o arquivo para escrita!");
      }
      $bytes = stream_copy_to_stream($stream, $handle); // Copy content from stream to file
      if($bytes === false)
      {
        fclose($handle); // Clean up in case of error
        throw new FileHandlerException("Erro ao escrever o conteúdo no arquivo!");
      }
      fclose($handle);
      fclose($stream);
    }
    function __destruct() {}
  }
?>