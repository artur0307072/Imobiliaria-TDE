<?php
require_once __DIR__ . '/../auth/sessao.php';
exigirLogin();

require_once __DIR__ . '/../dao/ImovelDAO.php';

$dao          = new ImovelDAO();
$imoveis      = $dao->listarTodos(); 
$usuario_atual = (int) $_SESSION['usuario_id'];

$sucesso = $_SESSION['msg_sucesso'] ?? '';
$erro    = $_SESSION['msg_erro']    ?? '';
unset($_SESSION['msg_sucesso'], $_SESSION['msg_erro']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóveis — ImobiSystem</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/../assets/navbar.php'; ?>

<main class="container">
    <div class="page-header">
        <div>
            <h2>Imóveis Cadastrados</h2>
            <p class="subtitulo"><?= count($imoveis) ?> imóvel(is) encontrado(s)</p>
        </div>
        <a href="<?= BASE_URL ?>/imoveis/cadastrar.php" class="btn btn-primario">+ Novo Imóvel</a>
    </div>

    <?php if ($sucesso): ?>
        <div class="alerta alerta-sucesso"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>
    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (empty($imoveis)): ?>
        <div class="vazio">
            <span class="vazio-icon">🏚️</span>
            <p>Nenhum imóvel cadastrado ainda.</p>
            <a href="<?= BASE_URL ?>/imoveis/cadastrar.php" class="btn btn-primario">Cadastrar primeiro imóvel</a>
        </div>
    <?php else: ?>
        <div class="grid-imoveis">
            <?php foreach ($imoveis as $im): ?>
            <div class="card-imovel">
                <div class="card-imovel-body">
                    <h3><?= htmlspecialchars($im['titulo']) ?></h3>
                    <p class="endereco">📍 <?= htmlspecialchars($im['endereco']) ?></p>
                    <p class="descricao"><?= nl2br(htmlspecialchars($im['descricao'])) ?></p>
                    <p class="preco">R$ <?= number_format($im['preco'], 2, ',', '.') ?></p>
                    <p class="dono">👤 <?= htmlspecialchars($im['nome_usuario'] ?? 'Usuário') ?></p>
                </div>
                <div class="card-imovel-acoes">
                    <?php if ((int)$im['usuario_id'] === $usuario_atual): ?>
                        <!-- Só aparece para o dono do imóvel -->
                        <a href="<?= BASE_URL ?>/imoveis/editar.php?id=<?= $im['id'] ?>"
                           class="btn btn-secundario btn-sm">✏️ Editar</a>
                        <a href="<?= BASE_URL ?>/imoveis/excluir.php?id=<?= $im['id'] ?>"
                           class="btn btn-perigo btn-sm"
                           onclick="return confirm('Confirma a exclusão deste imóvel?')">🗑️ Excluir</a>
                    <?php else: ?>
                        <!-- Outros usuários só visualizam -->
                        <span class="badge-outro">🔒 Imóvel de outro usuário</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?= SCRIPT_ANTI_VOLTAR ?>
</body>
</html>
