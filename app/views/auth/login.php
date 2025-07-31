<!doctype html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- Bootstrap 5 via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<div class="container mt-5">
  <h2>Login</h2>
  <form method="post" action="../public/login.php">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="" required>
    </div>
    <div class="mb-3">
      <label>Senha</label>
      <input type="password" name="senha" class="form-control" value="" required>
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
  </form>
</div>
</body></html>


