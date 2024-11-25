<?php
  namespace App\Presence\Schemas;
  class RequestPresenceList
  {
    public $matricula;
    public $fotografia;
    public $erros_validacao;
    function __construct($matricula, $fotografia)
    {
      $this->matricula = $matricula;
      $this->fotografia = $fotografia;
      $this->erros_validacao = [];
    }
    function is_valid()
    {
      if (!(preg_match("/^[0-9]{7}$/", $this->matricula)))
      {
        $this->erros_validacao[] = "A matrícula informada não é válida!";
        return;
      }
      $image_properties = exif_read_data($this->fotografia);
      if (!($image_properties))
      {
        $this->erros_validacao[] = "A imagem enviada não é válida!";
        return;
      }
      if ($image_properties["FileType"] !== 2)
      {
        $this->erros_validacao[] = "O tipo de imagem deve ser JPG ou JPEG!";
        return;
      }
      if(!(isset($image_properties["DateTimeOriginal"])))
      {
        $this->erros_validacao[] = "A imagem enviada é inválida!";
        return;
      }
      $fotograph_timestamp = strtotime($image_properties["DateTimeOriginal"]);
      $fotograph_timestamp += 3 * 3600; # Ajusta valor para 'America/Sao_Paulo'
      $difference_in_seconds = time() - $fotograph_timestamp;
      if($difference_in_seconds < 0 or $difference_in_seconds > 60)
      {
        $this->erros_validacao[] = "A imagem enviada expirou!";
        return;
      }
      $modelos_homologados = ["moto e13", "etc.."];
      if (!(in_array($image_properties["Model"], $modelos_homologados)))
      {
        $this->erros_validacao[] = "Câmera \"" . $image_properties["Model"] . "\" não homologada!";
        return;
      }
    }
  }
?>