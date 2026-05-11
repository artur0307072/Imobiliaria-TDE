<?php
require_once __DIR__ . '/../auth/sessao.php';
exigirLogin();

require_once __DIR__ . '/../dao/ImovelDAO.php';

$dao = new ImovelDAO();
$id  = (int) ($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['msg_erro'] = 'Imóvel inválido.';
    header('Location: ' . BASE_URL . '/imoveis/listar.php');
    exit;
}

$dados = $dao->buscarPorIdEUsuario($id, (int) $_SESSION['usuario_id']);
if (!$dados) {
    $_SESSION['msg_erro'] = 'Imóvel não encontrado ou sem permissão.';
    header('Location: ' . BASE_URL . '/imoveis/listar.php');
    exit;
}

if ($dao->excluir($id, (int) $_SESSION['usuario_id'])) {
    $_SESSION['msg_sucesso'] = "Imóvel \"{$dados['titulo']}\" excluído com sucesso.";
} else {
    $_SESSION['msg_erro'] = 'Erro ao excluir imóvel.';
}

header('Location: ' . BASE_URL . '/imoveis/listar.php');
exit;
