<?php
$currentPage = $_GET['page'] ?? 'cliente'; // Pega 'page' da URL ou usa 'cliente' como padrão
$currentAction = $_GET['action'] ?? 'create'; // Pega 'action' ou usa 'save' como padrão
?>
<script>
  function mascararDocumento(input) {
    let valor = input.value.replace(/\D/g, "");

    if (valor.length <= 11) {
      // Máscara de CPF: 000.000.000-00
      valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
      valor = valor.replace(/(\d{3})(\d)/, "$1.$2");
      valor = valor.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    } else {
      // Máscara de CNPJ: 00.000.000/0000-00
      valor = valor.replace(/^(\d{2})(\d)/, "$1.$2");
      valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
      valor = valor.replace(/\.(\d{3})(\d)/, ".$1/$2");
      valor = valor.replace(/(\d{4})(\d{1,2})$/, "$1-$2");
    }

    input.value = valor;
  }

  function validar() {
    const doc = document.getElementById("documento").value.replace(/\D/g, "");
    const resultado = document.getElementById("resultado");

    if (doc.length === 11) {
      resultado.innerText = validarCPF(doc) ? "CPF válido ✅" : "CPF inválido ❌";
    } else if (doc.length === 14) {
      resultado.innerText = validarCNPJ(doc) ? "CNPJ válido ✅" : "CNPJ inválido ❌";
    } else {
      resultado.innerText = "Documento incompleto ou inválido ❗";
    }
  }

  function validarCPF(cpf) {
    if (/^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    for (let i = 0; i < 9; i++) soma += parseInt(cpf[i]) * (10 - i);
    let digito1 = 11 - (soma % 11);
    if (digito1 >= 10) digito1 = 0;
    if (digito1 !== parseInt(cpf[9])) return false;

    soma = 0;
    for (let i = 0; i < 10; i++) soma += parseInt(cpf[i]) * (11 - i);
    let digito2 = 11 - (soma % 11);
    if (digito2 >= 10) digito2 = 0;

    return digito2 === parseInt(cpf[10]);
  }

  function validarCNPJ(cnpj) {
    if (/^(\d)\1+$/.test(cnpj)) return false;

    let calc = (x) => {
      let soma = 0;
      let peso = x - 7;
      for (let i = 0; i < x; i++) {
        soma += cnpj[i] * peso--;
        if (peso < 2) peso = 9;
      }
      let resto = soma % 11;
      return resto < 2 ? 0 : 11 - resto;
    };

    const digito1 = calc(12);
    const digito2 = calc(13);

    return digito1 === parseInt(cnpj[12]) && digito2 === parseInt(cnpj[13]);
  }
  function mascararCEP(input) {
    let cep = input.value.replace(/\D/g, "");
    if (cep.length > 5) {
      cep = cep.replace(/^(\d{5})(\d{1,3})/, "$1-$2");
    }
    input.value = cep;
  }  
</script>
<div class="container mt-5">
  <h2><?= $cliente ? 'Editar' : 'Novo' ?> Cliente</h2>
  <form method="post">
    <div class="mb-3">
      <label>Nome</label>
      <input type="text" name="nome" class="form-control" value="<?= $cliente['nome'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>CPF/NPJ</label>
      <input type="text" name="documento" class="form-control" id="documento" oninput="mascararDocumento(this)" onblur="validar()" maxlength="18" value="<?= $cliente['documento'] ?? '' ?>" required>
      <p id="resultado"></p>
    </div>    
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= $cliente['email'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Cep</label>
      <input type="text" name="cep" class="form-control" id="cep" maxlength="9" oninput="mascararCEP(this)" value="<?= $cliente['cep'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Logradouro</label>
      <input type="text" name="logradouro" class="form-control" value="<?= $cliente['logradouro'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Numero</label>
      <input type="text" name="numero" class="form-control" value="<?= $cliente['numero'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Complemento</label>
      <input type="text" name="complemento" class="form-control" value="<?= $cliente['complemento'] ?? '' ?>">
    </div>
    <div class="mb-3">
      <label>Bairro</label>
      <input type="text" name="bairro" class="form-control" value="<?= $cliente['bairro'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Cidade</label>
      <input type="text" name="cidade" class="form-control" value="<?= $cliente['cidade'] ?? '' ?>" required>
    </div>  
<div class="mb-3">
  <label>Estado</label>
  <select name="uf" class="form-control" required>
    <option value="">Selecione</option>
    <option value="AC" <?= ($cliente['uf'] ?? '') == 'AC' ? 'selected' : '' ?>>AC</option>
    <option value="AL" <?= ($cliente['uf'] ?? '') == 'AL' ? 'selected' : '' ?>>AL</option>
    <option value="AP" <?= ($cliente['uf'] ?? '') == 'AP' ? 'selected' : '' ?>>AP</option>
    <option value="AM" <?= ($cliente['uf'] ?? '') == 'AM' ? 'selected' : '' ?>>AM</option>
    <option value="BA" <?= ($cliente['uf'] ?? '') == 'BA' ? 'selected' : '' ?>>BA</option>
    <option value="CE" <?= ($cliente['uf'] ?? '') == 'CE' ? 'selected' : '' ?>>CE</option>
    <option value="DF" <?= ($cliente['uf'] ?? '') == 'DF' ? 'selected' : '' ?>>DF</option>
    <option value="ES" <?= ($cliente['uf'] ?? '') == 'ES' ? 'selected' : '' ?>>ES</option>
    <option value="GO" <?= ($cliente['uf'] ?? '') == 'GO' ? 'selected' : '' ?>>GO</option>
    <option value="MA" <?= ($cliente['uf'] ?? '') == 'MA' ? 'selected' : '' ?>>MA</option>
    <option value="MT" <?= ($cliente['uf'] ?? '') == 'MT' ? 'selected' : '' ?>>MT</option>
    <option value="MS" <?= ($cliente['uf'] ?? '') == 'MS' ? 'selected' : '' ?>>MS</option>
    <option value="MG" <?= ($cliente['uf'] ?? '') == 'MG' ? 'selected' : '' ?>>MG</option>
    <option value="PA" <?= ($cliente['uf'] ?? '') == 'PA' ? 'selected' : '' ?>>PA</option>
    <option value="PB" <?= ($cliente['uf'] ?? '') == 'PB' ? 'selected' : '' ?>>PB</option>
    <option value="PR" <?= ($cliente['uf'] ?? '') == 'PR' ? 'selected' : '' ?>>PR</option>
    <option value="PE" <?= ($cliente['uf'] ?? '') == 'PE' ? 'selected' : '' ?>>PE</option>
    <option value="PI" <?= ($cliente['uf'] ?? '') == 'PI' ? 'selected' : '' ?>>PI</option>
    <option value="RJ" <?= ($cliente['uf'] ?? '') == 'RJ' ? 'selected' : '' ?>>RJ</option>
    <option value="RN" <?= ($cliente['uf'] ?? '') == 'RN' ? 'selected' : '' ?>>RN</option>
    <option value="RS" <?= ($cliente['uf'] ?? '') == 'RS' ? 'selected' : '' ?>>RS</option>
    <option value="RO" <?= ($cliente['uf'] ?? '') == 'RO' ? 'selected' : '' ?>>RO</option>
    <option value="RR" <?= ($cliente['uf'] ?? '') == 'RR' ? 'selected' : '' ?>>RR</option>
    <option value="SC" <?= ($cliente['uf'] ?? '') == 'SC' ? 'selected' : '' ?>>SC</option>
    <option value="SP" <?= ($cliente['uf'] ?? '') == 'SP' ? 'selected' : '' ?>>SP</option>
    <option value="SE" <?= ($cliente['uf'] ?? '') == 'SE' ? 'selected' : '' ?>>SE</option>
    <option value="TO" <?= ($cliente['uf'] ?? '') == 'TO' ? 'selected' : '' ?>>TO</option>
  </select>
</div>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</div>
