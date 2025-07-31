<div class="container mt-5">
  <h2>Clientes</h2>
  <a href="?page=cliente&action=create" class="btn btn-success mb-3">Novo Cliente</a>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr></thead>
    <tbody>
      <?php foreach($clientes as $cliente): ?>
      <tr>
        <td><?= $cliente['id'] ?></td>
        <td><?= $cliente['nome'] ?></td>
        <td><?= $cliente['email'] ?></td>
        <td>
          <a href="?page=cliente&action=edit&id=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="?page=cliente&action=delete&id=<?= $cliente['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma?')">Excluir</a>
        </td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
