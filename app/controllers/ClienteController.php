<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Cliente;

class ClienteController extends Controller {
  public function index(){
    $clientes = (new Cliente())->all();
    $this->view('cliente/index',['clientes'=>$clientes]);
  }
  public function create(){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      (new Cliente())->create($_POST);
      header('Location:?page=cliente&action=index');
      exit;
    }
    $this->view('cliente/form',['cliente'=>null]);
  }
  public function edit(){
    $c = new Cliente();
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $c->update($_GET['id'],$_POST);
      header('Location:?page=cliente&action=index'); exit;
    }
    $cliente = $c->find($_GET['id']);
    $this->view('cliente/form',['cliente'=>$cliente]);
  }
  public function delete(){
    (new Cliente())->delete($_GET['id']);
    header('Location:?page=cliente&action=index'); exit;
  }
}
