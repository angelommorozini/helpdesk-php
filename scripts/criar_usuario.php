<?php
if (PHP_SAPI !== 'cli') {
    exit(1);
}
require '/var/www/html/db.php';

$usuario = $argv[1] ?? '';
if ($usuario === '') {
    fwrite(STDERR, "Uso: php criar_usuario.php <usuario>\n");
    exit(1);
}

echo "Senha: ";
system('stty -echo');
$senha = trim(fgets(STDIN));
system('stty echo');
echo "\n";

if (strlen($senha) < 8) {
    fwrite(STDERR, "A senha precisa ter pelo menos 8 caracteres.\n");
    exit(1);
}

$hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha_hash) VALUES (?, ?)");
$stmt->execute([$usuario, $hash]);
echo "Usuário '$usuario' criado.\n";
