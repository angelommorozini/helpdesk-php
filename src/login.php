<?php
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
require __DIR__ . '/db.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT id, senha_hash FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);

    $hash = $u['senha_hash'] ?? password_hash('invalido', PASSWORD_DEFAULT);
    if (password_verify($senha, $hash) && $u) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $u['id'];
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit;
    }
    $erro = 'Usuário ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Help Desk</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-wrap">
    <div class="card login-card">
      <h1>Help Desk</h1>
      <p class="sub">Entre para gerenciar os chamados</p>
      <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="campo"><input type="text" name="usuario" placeholder="Usuário" required autofocus></div>
        <div class="campo"><input type="password" name="senha" placeholder="Senha" required></div>
        <button type="submit">Entrar</button>
      </form>
    </div>
  </div>
</body>
</html>
