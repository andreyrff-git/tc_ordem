<div class="container mt-5">
  <h2>Ordens de Serviço</h2>
  <a href="?page=ordem&action=create" class="btn btn-success mb-3">Nova Ordem</a>
  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Cliente</th><th>Produto</th><th>Descrição</th><th>Data de Abertura</th><th>Ações</th></tr>
    </thead>
    <tbody>
      <?php foreach($ordens as $ordem): ?>
      <tr>
        <td><?= $ordem['id_ordem'] ?></td>
        <td><?= $ordem['cliente_nome'] ?></td>
        <td><?= $ordem['produto_nome'] ?></td>
        <td><?= $ordem['dtabertura'] ?></td>
        <td><?= $ordem['descricao'] ?></td>
        <td>
          <a href="?page=ordem&action=edit&id=<?= $ordem['id_ordem'] ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="?page=ordem&action=delete&id=<?= $ordem['id_ordem'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma?')">Excluir</a>
        </td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
