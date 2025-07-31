<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Ordem;
use App\Models\Cliente;
use App\Models\Produto;

class OrdemController extends Controller {
  public function index(){
    $ordens = (new Ordem())->all();
    $this->view('ordem/index', ['ordens' => $ordens]);
  }

  public function create(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      (new Ordem())->create($_POST);
      header('Location:?page=ordem&action=index'); exit;
    }
    // $ordem = $o->find($_GET['id']);
    $clientes = (new Cliente())->all();
    $produtos = (new Produto())->all();
    $this->view('ordem/form', ['ordem'=>null, 'clientes'=>$clientes, 'produtos'=>$produtos]);
  }

  public function edit(){
    $o = new Ordem();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $o->update($_GET['id'], $_POST);
      header('Location:?page=ordem&action=index'); exit;
    }
    $ordem = $o->find($_GET['id']);
    $clientes = (new Cliente())->all();
    $produtos = (new Produto())->all();
    $this->view('ordem/form', ['ordem'=>$ordem, 'clientes'=>$clientes, 'produtos'=>$produtos]);
  }

  public function delete(){
    (new Ordem())->delete($_GET['id']);
    header('Location:?page=ordem&action=index'); exit;
  }
}
