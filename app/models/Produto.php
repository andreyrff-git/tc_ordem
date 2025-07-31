<?php
namespace App\Models;
use App\Core\Model;

class Produto extends Model {
  public function all(){
    return $this->db->query("SELECT * FROM produtos")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public function find($id){
    $stmt = $this->db->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
  public function create($data){
    $stmt = $this->db->prepare("INSERT INTO produtos (descricao, preco,dtgarantia,ativo) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$data['descricao'], $data['preco'],$data['dtgarantia'],$data['ativo']]);
  }
  public function update($id, $data){
    $stmt = $this->db->prepare("UPDATE produtos SET descricao = ?, preco = ?, dtgarantia=?, ativo=? WHERE id = ?");
    return $stmt->execute([$data['descricao'], $data['preco'], $data['dtgarantia'],$data['ativo'], $id]);
  }
  public function delete($id){
    $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = ?");
    return $stmt->execute([$id]);
  }
}
