<div class="container mt-5">
  <h2><?= $ordem ? 'Editar' : 'Nova' ?> Ordem de Serviço</h2>
  <form method="post">
    <div class="mb-3">
      <label>Cliente</label>
      <select name="cliente_id" class="form-select" required>
        <?php foreach($clientes as $c): ?>
        <option value="<?= $c['id'] ?>" <?= ($ordem['cliente_id'] ?? null) == $c['id'] ? 'selected' : '' ?>><?= $c['nome'] ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Produto</label>
      <select name="produto_id" class="form-select" required>
        <?php foreach($produtos as $p): ?>
        <option value="<?= $p['id'] ?>" <?= ($ordem['produto_id'] ?? null) == $p['id'] ? 'selected' : '' ?>><?= $p['descricao'] ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Data de Abertura</label>
      <input type="date" name="dtabertura" class="form-control" value="<?= $ordem['dtabertura'] ?? '' ?>" required> 
    </div>    
    <div class="mb-3">
      <label>Descrição</label>
      <textarea name="descricao" class="form-control" required><?= $ordem['descricao'] ?? '' ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</div>
