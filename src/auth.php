<?php
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
require __DIR__ . '/db.php';

if (empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
