<?php
  if($_SERVER['REQUEST_METHOD'] !== "POST")
  {
    header("Location: ./index.php");
    exit();
  }
  require_once(__DIR__ . "/../vendor/autoload.php");
  use App\Core\Templates\Template;
  use App\Presence\Schemas\RequestPresenceList;
  use App\Presence\Services\Database;
  // Verifica se o arquivo foi postado
  if (!(is_uploaded_file($_FILES['camera_button']['tmp_name'])))
  {
    new Template(
      titulo: "Houve um erro!",
      estilo: "",
      conteudo: <<<HTML
        <p class="text-danger">Houve um erro ao receber o arquivo.</p>
        <p>Sua presença <strong>não</strong> foi registrada!</p>
        <p><a href="./">Voltar</a></p>
      HTML
      );
    http_response_code(400);
    exit();
  }
  $presence_item = new RequestPresenceList($_POST["matricula"], $_FILES['camera_button']['tmp_name']);
  $presence_item->is_valid();
  $database = new Database();
  $conteudo = "";
  if (!empty($presence_item->erros_validacao))
  {
    foreach ($presence_item->erros_validacao as $erro)
    {
      $conteudo .= <<<HTML
        <p class="text-danger">$erro</p>
        HTML;
      }
      new Template(
        titulo: "Registro inválido!",
        estilo: "",
        conteudo: $conteudo .= <<<HTML
        <p>Sua presença <strong>não</strong> foi registrada!</p>
        <p><a href="./">Voltar</a></p>
      HTML
      );
    http_response_code(400);
    exit();
  }
  new Template(
    titulo: "Fuck! This have passed!",
    estilo: "",
    conteudo: <<<HTML
      <p><a href="./">Voltar</a></p>
    HTML
    );
  exit();
  $target_file = "/var/www/uploads/" . $presence_item->matricula . ".jpg";
  // Se o arquivo não existir, cadastrar usuário.
  if (file_exists($target_file))
  {
    shell_exec("");
  }
?>
