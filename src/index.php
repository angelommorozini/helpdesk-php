<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'criar') {
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        if ($titulo !== '') {
            $stmt = $pdo->prepare("INSERT INTO chamados (titulo, descricao) VALUES (?, ?)");
            $stmt->execute([$titulo, $descricao]);
        }
    } elseif ($acao === 'status') {
        $validos = ['aberto', 'em_andamento', 'fechado'];
        $status = $_POST['status'] ?? '';
        if (in_array($status, $validos, true)) {
            $stmt = $pdo->prepare("UPDATE chamados SET status = ? WHERE id = ?");
            $stmt->execute([$status, (int)$_POST['id']]);
        }
    } elseif ($acao === 'excluir') {
        $stmt = $pdo->prepare("DELETE FROM chamados WHERE id = ?");
        $stmt->execute([(int)$_POST['id']]);
    }

    header('Location: index.php');
    exit;
}

$chamados = $pdo->query("SELECT * FROM chamados ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Help Desk</title>
</head>
<body>
  <h1>Help Desk</h1>

  <h2>Novo chamado</h2>
  <form method="post">
    <input type="hidden" name="acao" value="criar">
    <p><input type="text" name="titulo" placeholder="Título" required></p>
    <p><textarea name="descricao" placeholder="Descrição"></textarea></p>
    <button type="submit">Abrir chamado</button>
  </form>

  <h2>Chamados</h2>
  <table border="1" cellpadding="6">
    <tr><th>ID</th><th>Título</th><th>Status</th><th>Criado em</th><th>Ações</th></tr>
    <?php foreach ($chamados as $c): ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= htmlspecialchars($c['titulo']) ?></td>
        <td>
          <form method="post">
            <input type="hidden" name="acao" value="status">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <select name="status" onchange="this.form.submit()">
              <?php foreach (['aberto', 'em_andamento', 'fechado'] as $s): ?>
                <option value="<?= $s ?>" <?= $c['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
              <?php endforeach; ?>
            </select>
          </form>
        </td>
        <td><?= $c['criado_em'] ?></td>
        <td>
          <form method="post" onsubmit="return confirm('Excluir este chamado?')">
            <input type="hidden" name="acao" value="excluir">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button type="submit">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
