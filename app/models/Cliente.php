<?php
namespace App\Models;
use App\Core\Model;

class Cliente extends Model {
  public function all(){
    return $this->db->query("SELECT * FROM clientes")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public function find($id){
    $stmt=$this->db->prepare("SELECT * FROM clientes WHERE id=?");
    $stmt->execute([$id]); return $stmt->fetch(\PDO::FETCH_ASSOC);
  }
  public function create($d){
    $stmt=$this->db->prepare("INSERT INTO clientes (nome,email,documento,logradouro, numero, complemento, bairro, cidade, uf, cep) VALUES (?,?,?,?,?,?,?,?,?,?)");
    return $stmt->execute([$d['nome'],$d['email'],$d['documento'],$d['logradouro'], $d['numero'], $d['complemento'], $d['bairro'], $d['cidade'], $d['uf'], $d['cep']]);
  }
  public function update($id,$d){
    $stmt=$this->db->prepare("UPDATE clientes SET nome=?,email=?, logradouro=?, numero=?, complemento=?, bairro=?, cidade=?, uf=?, cep=? WHERE id=?");
    return $stmt->execute([$d['nome'],$d['email'],$d['logradouro'], $d['numero'], $d['complemento'], $d['bairro'], $d['cidade'], $d['uf'], $d['cep'],$id]);
  }
  public function delete($id){
    $stmt=$this->db->prepare("DELETE FROM clientes WHERE id=?");
    return $stmt->execute([$id]);
  }
}
