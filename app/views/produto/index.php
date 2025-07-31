<div class="container mt-5">
  <h2>Produtos</h2>
  <a href="?page=produto&action=create" class="btn btn-success mb-3">Novo Produto</a>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Data Garantia</th><th>Ativo</th><th>Ações</th></tr></thead>
    <tbody>
      <?php foreach($produtos as $produto): ?>
      <tr>
        <td><?= $produto['id'] ?></td>
        <td><?= $produto['descricao'] ?></td>
        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
        <td><?= $produto['dtgarantia'] ?></td>
        <td><?= $produto['ativo'] ?></td>        
        <td>
          <a href="?page=produto&action=edit&id=<?= $produto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
          <a href="?page=produto&action=delete&id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirma?')">Excluir</a>
        </td>
      </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
