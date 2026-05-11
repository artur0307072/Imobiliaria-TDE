<?php
require_once __DIR__ . '/../auth/sessao.php';
redirecionarSeLogado();

require_once __DIR__ . '/../dao/UsuarioDAO.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($email && $senha) {
        $dao     = new UsuarioDAO();
        $usuario = $dao->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: ' . BASE_URL . '/imoveis/listar.php');
            exit;
        } else {
            $erro = 'E-mail ou senha inválidos.';
        }
    } else {
        $erro = 'Preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Imobiliária</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="pagina-auth">

<div class="auth-card">
    <div class="auth-logo">
        <span class="logo-icon">🏠</span>
        <h1>ImobiSystem</h1>
        <p>Faça login para continuar</p>
    </div>

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email"
                   placeholder="seu@email.com"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   required autofocus>
        </div>

        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha"
                   placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-primario btn-bloco">Entrar</button>
    </form>

    <p class="auth-link">Não tem conta?
        <a href="<?= BASE_URL ?>/auth/cadastro.php">Cadastre-se aqui</a>
    </p>
</div>

</body>
</html>
