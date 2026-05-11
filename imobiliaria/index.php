<?php
require_once __DIR__ . '/auth/sessao.php';

if (!empty($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_URL . '/imoveis/listar.php');
} else {
    header('Location: ' . BASE_URL . '/auth/login.php');
}
exit;
