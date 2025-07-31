<?php
namespace App\Models;

use App\Core\Model;

class Usuario extends Model
{
    public function buscarPorEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //criar um novo usuário
    public function criar($email, $senha)
    {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
        return $stmt->execute([$email, $hash]);
    }
}
