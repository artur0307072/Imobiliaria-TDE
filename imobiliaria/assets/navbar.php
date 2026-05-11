<?php
?>
<header class="navbar">
    <div class="navbar-inner">
        <a class="navbar-brand" href="<?= BASE_URL ?>/imoveis/listar.php">
            🏠 <strong>ImobiSystem</strong>
        </a>

        <nav class="navbar-nav">
            <a href="<?= BASE_URL ?>/imoveis/listar.php"
               class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'listar') !== false ? 'ativo' : '' ?>">
                Imóveis
            </a>
            <a href="<?= BASE_URL ?>/imoveis/cadastrar.php"
               class="nav-link <?= strpos($_SERVER['PHP_SELF'], 'cadastrar') !== false ? 'ativo' : '' ?>">
                + Novo
            </a>
        </nav>

        <div class="navbar-usuario">
            <span>👤 <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário') ?></span>
            <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-outline btn-sm">Sair</a>
        </div>
    </div>
</header>
