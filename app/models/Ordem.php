<?php
namespace App\Models;
use App\Core\Model;

class Ordem extends Model {
  public function all(){
    return $this->db->query("SELECT ordens.*, clientes.nome AS cliente_nome, produtos.descricao AS produto_nome
      FROM ordens 
      JOIN clientes ON ordens.cliente_id = clientes.id 
      JOIN produtos ON ordens.produto_id = produtos.id")->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function find($id){
    $stmt = $this->db->prepare("SELECT * FROM ordens WHERE id_ordem = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function create($data){

    $stmt = $this->db->prepare("INSERT INTO ordens (cliente_id, produto_id, descricao, dtabertura) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$data['cliente_id'], $data['produto_id'], $data['descricao'], $data['dtabertura']]);
  }

  public function update($id, $data){
    $stmt = $this->db->prepare("UPDATE ordens SET cliente_id=?, produto_id=?, descricao=?, dtabertura=? WHERE id_ordem=?");
    return $stmt->execute([$data['cliente_id'], $data['produto_id'], $data['descricao'], $data['dtabertura'], $id]);
  }

  public function delete($id){
    $stmt = $this->db->prepare("DELETE FROM ordens WHERE id_ordem=?");
    return $stmt->execute([$id]);
  }
}
