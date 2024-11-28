<?php
  if($_SERVER['REQUEST_METHOD'] !== "POST")
  {
    header("Location: ./index.php");
    exit();
  }
  require_once(__DIR__ . "/../vendor/autoload.php");
  use App\Core\Templates\Template;
  use App\Presence\Schemas\RequestPresenceList;
  use App\Presence\Schemas\ResultPresenceList;
  use App\Presence\Services\Database;
  use App\Core\Services\FileService;
  try {
    // Verifica se o arquivo foi postado
    if(!(is_uploaded_file($_FILES['camera_button']['tmp_name'])))
    {
      throw new \Exception("Houve um erro ao receber o arquivo.");
    }
    $presence_item = new RequestPresenceList($_POST["matricula"], $_FILES['camera_button']['tmp_name']);
    $presence_item->is_valid();
    if(!empty($presence_item->erro_validacao))
    {
      throw new \Exception($presence_item->erro_validacao);
    }
    $filehandler = new FileService();
    $target_file = $presence_item->matricula . ".jpg";
    if(!$filehandler->check_file_exist($target_file))
    {
      throw new \Exception("Funcionário não cadastrado!");
    }
    $download_file = $filehandler->download_file($target_file);
    $result = shell_exec("presence_list.exe" . " " . "$target_file" . " " . "$dowload_file");
    $object = json_decode($result);
    $database = new Database();
    $database->set_one_presence(
      new ResultPresenceList(
        rowid: 0,
        matricula: $presence_item->matricula,
        timestamp: new \DateTime(),
        singularity: 1,
        state: 201
      )
    );
  }
  catch (\Exception $erro)
  {
    new Template(
      titulo: "Presença não registrada!",
      estilo: "",
      conteudo: <<<HTML
        <p class="text-danger">{$erro->getMessage()}</p>
        <p>Sua presença <strong>não</strong> foi registrada!</p>
        <p><a href="./">Voltar</a></p>
      HTML
      );
    http_response_code(400);
  }
?>
