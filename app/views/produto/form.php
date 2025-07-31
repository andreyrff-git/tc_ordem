<div class="container mt-5">
  <h2><?= $produto ? 'Editar' : 'Novo' ?> Produto</h2>
  <form method="post">
    <div class="mb-3">
      <label>Nome</label>
      <input type="text" name="descricao" class="form-control" value="<?= $produto['descricao'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Preço</label>
      <input type="number" step="0.01" name="preco" class="form-control" value="<?= $produto['preco'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Data de Garantia</label>
      <input type="date" name="dtgarantia" class="form-control" value="<?= $produto['dtgarantia'] ?? '' ?>" required>  
    </div>
    <div class="mb-3">
      <label>Ativo</label>
      <select name="ativo" class="form-control">
        <option value="SIM" <?= (!isset($produto['ativo']) || $produto['ativo'] == 'SIM') ? 'selected' : '' ?>>SIM</option>
        <option value="NÃO" <?= (isset($produto['ativo']) && $produto['ativo'] == 'NÃO') ? 'selected' : '' ?>>NÃO</option>
      </select>
    </div>    
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</div>
