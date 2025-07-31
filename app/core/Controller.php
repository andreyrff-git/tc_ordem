<?php
namespace App\Core;
class Controller {
  protected function view($path,$data=[]){
    extract($data);
    require __DIR__.'/../views/layout/header.php';
    require __DIR__.'/../views/'.$path.'.php';
    require __DIR__.'/../views/layout/footer.php';
  }
  protected function json($data,$code=200){
    header('Content-Type:application/json');
    http_response_code($code);
    echo json_encode($data);
    exit;
  }
}
?>
