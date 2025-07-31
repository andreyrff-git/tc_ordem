<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Produto;

class ProdutoController extends Controller {
  public function index(){
    $produtos = (new Produto())->all();
    $this->view('produto/index', ['produtos'=>$produtos]);
  }

  public function create(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      (new Produto())->create($_POST);
      header('Location:?page=produto&action=index'); exit;
    }
    $this->view('produto/form', ['produto'=>null]);
  }

  public function edit(){
    $p = new Produto();
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $p->update($_GET['id'], $_POST);
      header('Location:?page=produto&action=index'); exit;
    }
    $produto = $p->find($_GET['id']);
    $this->view('produto/form', ['produto'=>$produto]);
  }

  public function delete(){
    (new Produto())->delete($_GET['id']);
    header('Location:?page=produto&action=index'); exit;
  }
}
