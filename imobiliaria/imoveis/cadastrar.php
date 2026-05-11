<?php
require_once __DIR__ . '/../auth/sessao.php';
exigirLogin();

require_once __DIR__ . '/../dao/ImovelDAO.php';
require_once __DIR__ . '/../model/Imovel.php';

$erro    = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco     = trim($_POST['preco']     ?? '');
    $endereco  = trim($_POST['endereco']  ?? '');

    if (!$titulo || !$preco || !$endereco) {
        $erro = 'Preencha os campos obrigatórios: Título, Preço e Endereço.';
    } elseif (!is_numeric(str_replace(',', '.', $preco))) {
        $erro = 'Preço inválido.';
    } else {
        $imovel = new Imovel();
        $imovel->setTitulo($titulo);
        $imovel->setDescricao($descricao);
        $imovel->setPreco((float) str_replace(',', '.', $preco));
        $imovel->setEndereco($endereco);

        $dao = new ImovelDAO();
        if ($dao->inserir($imovel, (int) $_SESSION['usuario_id'])) {
            $_SESSION['msg_sucesso'] = 'Imóvel cadastrado com sucesso!';
            header('Location: ' . BASE_URL . '/imoveis/listar.php');
            exit;
        } else {
            $erro = 'Erro ao cadastrar imóvel.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Imóvel — ImobiSystem</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<?php include __DIR__ . '/../assets/navbar.php'; ?>

<main class="container">
    <div class="page-header">
        <div>
            <h2>Cadastrar Imóvel</h2>
            <p class="subtitulo">Preencha os dados do novo imóvel</p>
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
                       placeholder="Ex: Apartamento 2 quartos Centro"
                       value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>"
                       required>
            </div>

            <div class="campo">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4"
                          placeholder="Descreva as características do imóvel..."><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
            </div>

            <div class="form-linha-dupla">
                <div class="campo">
                    <label for="preco">Preço (R$) <span class="obrigatorio">*</span></label>
                    <input type="text" id="preco" name="preco"
                           placeholder="Ex: 350000.00"
                           value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>"
                           required>
                </div>

                <div class="campo">
                    <label for="endereco">Endereço <span class="obrigatorio">*</span></label>
                    <input type="text" id="endereco" name="endereco"
                           placeholder="Rua, número - Bairro"
                           value="<?= htmlspecialchars($_POST['endereco'] ?? '') ?>"
                           required>
                </div>
            </div>

            <div class="form-acoes">
                <a href="<?= BASE_URL ?>/imoveis/listar.php" class="btn btn-secundario">Cancelar</a>
                <button type="submit" class="btn btn-primario">💾 Salvar Imóvel</button>
            </div>
        </form>
    </div>
</main>

<?= SCRIPT_ANTI_VOLTAR ?>
</body>
</html>
