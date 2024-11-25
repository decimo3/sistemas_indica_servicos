<?php
  /**
   * Fetch a two-column result into an array where the first column is a key and the second column
   * is the value.
   * @since 5.2.3
   * @link https://php.net/manual/en/pdo.constants.php#pdo.constants.fetch-key-pair
   */
  namespace App\Presence\Schemas;
  class ResultPresenceList
  {
    public $rowid;
    public $matricula;
    public $timestamp;
    public $singularity;
    public $state;
    function __construct(
      int $rowid,
      int $matricula,
      \DateTime $timestamp,
      float $singularity,
      bool $state
    )
    {
      $this->rowid = $rowid;
      $this->matricula = $matricula;
      $this->timestamp = $timestamp;
      $this->singularity = $singularity;
      $this->state = $state;
    }
  }
?>