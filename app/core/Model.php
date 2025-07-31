<?php
namespace App\Core;
use PDO;

class Model {
  protected $db;
  public function __construct(){
    $c=require __DIR__.'/../../config/config.php';
    $this->db = new PDO(
      "mysql:host={$c['db_host']};dbname={$c['db_name']};charset=utf8",
      $c['db_user'], $c['db_pass'],
      [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
    );
  }
}
?>