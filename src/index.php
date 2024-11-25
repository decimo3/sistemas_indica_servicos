<?php
  require_once(__DIR__ . "/vendor/autoload.php");
  use App\Core\Templates\Template;
  new Template(
  titulo: "Sistemas Indica",
  estilo: "",
  conteudo: <<<HTML
    <div class="card border text-center p-4">
      <div class="card border my-2 p-2">
        <a href="https://t.me/dika_chatbot" rel="noopener noreferrer">
          Sistema de atendimento de equipes de campo (chatbot)</a>
        </div>
      <div class="card border my-2 p-2">
        <a href="/Presence">Sistema de lista de presença do DDS</a>
      </div>
      <div class="card border my-2 p-2">
        <a href="/productivity">Sistema integrado de Produtividade (Power BI)</a>
      </div>
    </div>
  HTML
  );
?>
