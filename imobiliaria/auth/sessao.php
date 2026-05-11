<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

define('SCRIPT_ANTI_VOLTAR', '
<script>
window.addEventListener("pageshow", function(e) {
    if (e.persisted || (window.performance && window.performance.navigation.type === 2)) {
        window.location.reload();
    }
});
history.pushState(null, null, location.href);
window.addEventListener("popstate", function() {
    history.pushState(null, null, location.href);
});
</script>
');

function exigirLogin(): void {
    if (empty($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/auth/login.php');
        exit;
    }
}

function redirecionarSeLogado(): void {
    if (!empty($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/imoveis/listar.php');
        exit;
    }
}

if (!defined('BASE_URL')) {
    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host      = $_SERVER['HTTP_HOST'];
    $script    = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $partes    = explode('/', trim($script, '/'));
    $base      = '/' . ($partes[0] ?? 'imobiliaria');
    define('BASE_URL', $protocolo . '://' . $host . $base);
}
