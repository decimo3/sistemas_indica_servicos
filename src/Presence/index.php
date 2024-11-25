<?php
  require_once(__DIR__ . "/../vendor/autoload.php");
  use App\Core\Templates\Template;
  new Template(
    titulo: "Presença no DDS",
    estilo: <<<CSS
      #camera_button {
        width: 150px;
        height: 150px;
        opacity: 0; /* Hide the default file input */
        position: absolute;
        z-index: 2; /* Place the input above */
      }
      #camera_button + label {
        width: 150px;
        height: 150px;
        background: url("/Presence/Public/img/camera_button.png") no-repeat center center;
        background-size: cover;
        display: inline-block;
        cursor: pointer;
        z-index: 1; /* Custom button below the input */
      }
    CSS,
    conteudo: <<<HTML
    <form id="formulario" action="./result.php" method="post" enctype="multipart/form-data" class="card border p-2">
      <label for="matricula" class="mt-2">Matrícula Light:</label>
      <br/>
      <input type="number" class="form-control my-2" name="matricula" id="matricula" require>
      <br/>
      <span>Enviar foto:</span>
      <div class="d-flex flex-row justify-content-around">
        <input type="file" class="form-control" id="camera_button" name="camera_button" accept="image/*" capture="camera" require>
        <label for="camera_button"></label>
      </div>
      <br/>
      <input type="submit" class="btn btn-primary" value="Enviar imagem">
      <br/>
      <p><small>Camera icon from <a href="https://shmector.com/free-vector/technics/flat_camera_icon/12-0-1239" target="_blank">shmector.com</a></small></p>
    </form>
    HTML
    );
?>
