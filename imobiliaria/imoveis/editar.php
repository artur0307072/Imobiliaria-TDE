<?php
require_once __DIR__ . '/../auth/sessao.php';
exigirLogin();

require_once __DIR__ . '/../dao/ImovelDAO.php';
require_once __DIR__ . '/../model/Imovel.php';

$dao = new ImovelDAO();
$id  = (int) ($_GET['id'] ?? 0);

$dados = $dao->buscarPorIdEUsuario($id, (int) $_SESSION['usuario_id']);
if (!$dados) {
    $_SESSION['msg_erro'] = 'Imóvel não encontrado.';
    header('Location: ' . BASE_URL . '/imoveis/listar.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco     = trim($_POST['preco']     ?? '');
    $endereco  = trim($_POST['endereco']  ?? '');

    if (!$titulo || !$preco || !$endereco) {
        $erro = 'Preencha os campos obrigatórios.';
    } elseif (!is_numeric(str_replace(',', '.', $preco))) {
        $erro = 'Preço inválido.';
    } else {
        $imovel = new Imovel();
        $imovel->setId($id);
        $imovel->setTitulo($titulo);
        $imovel->setDescricao($descricao);
        $imovel->setPreco((float) str_replace(',', '.', $preco));
        $imovel->setEndereco($endereco);

        if ($dao->atualizar($imovel, (int) $_SESSION['usuario_id'])) {
            $_SESSION['msg_sucesso'] = 'Imóvel atualizado com sucesso!';
            header('Location: ' . BASE_URL . '/imoveis/listar.php');
            exit;
        } else {
            $erro = 'Erro ao atualizar imóvel.';
        }
    }

    $dados['titulo']    = $_POST['titulo'];
    $dados['descricao'] = $_POST['descricao'];
    $dados['preco']     = $_POST['preco'];
    $dados['endereco']  = $_POST['endereco'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imóvel — ImobiSystem</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/../assets/navbar.php'; ?>

<main class="container">
    <div class="page-header">
        <div>
            <h2>Editar Imóvel</h2>
            <p class="subtitulo">ID #<?= $id ?> — Altere os dados abaixo</p>
        </div>
        <a href="<?= BASE_URL ?>/imoveis/listar.php" class="btn btn-secundario">← Voltar</a>
    </div>

    <?php if ($erro): ?>
        <div class="alerta alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST">
            <div class="campo">
                <label for="titulo">Título <span class="obrigatorio">*</span></label>
                <input type="text" id="titulo" name="titulo"
                       value="<?= htmlspecialchars($dados['titulo']) ?>" required>
            </div>

            <div class="campo">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4"><?= htmlspecialchars($dados['descricao']) ?></textarea>
            </div>

            <div class="form-linha-dupla">
                <div class="campo">
                    <label for="preco">Preço (R$) <span class="obrigatorio">*</span></label>
                    <input type="text" id="preco" name="preco"
                           value="<?= htmlspecialchars($dados['preco']) ?>" required>
                </div>

                <div class="campo">
                    <label for="endereco">Endereço <span class="obrigatorio">*</span></label>
                    <input type="text" id="endereco" name="endereco"
                           value="<?= htmlspecialchars($dados['endereco']) ?>" required>
                </div>
            </div>

            <div class="form-acoes">
                <a href="<?= BASE_URL ?>/imoveis/listar.php" class="btn btn-secundario">Cancelar</a>
                <button type="submit" class="btn btn-primario">💾 Salvar Alterações</button>
            </div>
        </form>
    </div>
</main>

<?= SCRIPT_ANTI_VOLTAR ?>
</body>
</html>
