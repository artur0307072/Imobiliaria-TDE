<?php
require_once __DIR__ . '/../auth/sessao.php';
redirecionarSeLogado();

require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';

$erro    = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $conf  = trim($_POST['confirmar_senha'] ?? '');

    if (!$nome || !$email || !$senha || !$conf) {
        $erro = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $conf) {
        $erro = 'As senhas não conferem.';
    } else {
        $dao = new UsuarioDAO();
        if ($dao->emailExiste($email)) {
            $erro = 'Este e-mail já está cadastrado.';  
        } else {
            $usuario = new Usuario();
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setSenha($senha);

            if ($dao->cadastrar($usuario)) {
                $sucesso = 'Cadastro realizado! Você já pode fazer login.';
            } else {
                $erro = 'Erro ao cadastrar. Tente novamente.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro — Imobiliária</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="pagina-auth">

<div class="auth-card">
    <div class="auth-logo">
        <span class="logo-icon">🏠</span>
        <h1>ImobiSystem</h1>
        <p>Crie sua conta</p>
    </div>

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <?php if ($sucesso): ?>
        <div class="alerta alerta-sucesso"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="campo">
            <label for="nome">Nome completo</label>
            <input type="text" id="nome" name="nome"
                   placeholder="Seu nome"
                   value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                   required autofocus>
        </div>

        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email"
                   placeholder="seu@email.com"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   required>
        </div>

        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha"
                   placeholder="Mínimo 6 caracteres" required>
        </div>

        <div class="campo">
            <label for="confirmar_senha">Confirmar senha</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha"
                   placeholder="Repita a senha" required>
        </div>

        <button type="submit" class="btn btn-primario btn-bloco">Criar conta</button>
    </form>

    <p class="auth-link">Já tem conta?
        <a href="<?= BASE_URL ?>/auth/login.php">Faça login</a>
    </p>
</div>

</body>
</html>
