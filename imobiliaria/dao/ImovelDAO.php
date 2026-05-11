<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../model/Imovel.php';

class ImovelDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }
x
    public function inserir(Imovel $imovel, int $usuario_id): bool {
        $sql = "INSERT INTO imoveis (titulo, descricao, preco, endereco, usuario_id)
                VALUES (:titulo, :descricao, :preco, :endereco, :usuario_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titulo'     => $imovel->getTitulo(),
            ':descricao'  => $imovel->getDescricao(),
            ':preco'      => $imovel->getPreco(),
            ':endereco'   => $imovel->getEndereco(),
            ':usuario_id' => $usuario_id,
        ]);
    }

    public function listarTodos(): array {
        $sql  = "SELECT i.*, u.nome AS nome_usuario FROM imoveis i
                 LEFT JOIN usuarios u ON u.id = i.usuario_id
                 ORDER BY i.criado_em DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function listarPorUsuario(int $usuario_id): array {
        $sql  = "SELECT * FROM imoveis WHERE usuario_id = :uid ORDER BY criado_em DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid' => $usuario_id]);
        return $stmt->fetchAll();
    }

    public function buscarPorIdEUsuario(int $id, int $usuario_id): ?array {
        $sql  = "SELECT * FROM imoveis WHERE id = :id AND usuario_id = :uid LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':uid' => $usuario_id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function atualizar(Imovel $imovel, int $usuario_id): bool {
        $sql = "UPDATE imoveis
                SET titulo = :titulo, descricao = :descricao,
                    preco = :preco, endereco = :endereco
                WHERE id = :id AND usuario_id = :uid";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titulo'    => $imovel->getTitulo(),
            ':descricao' => $imovel->getDescricao(),
            ':preco'     => $imovel->getPreco(),
            ':endereco'  => $imovel->getEndereco(),
            ':id'        => $imovel->getId(),
            ':uid'       => $usuario_id,
        ]);
    }

    public function excluir(int $id, int $usuario_id): bool {
        $sql  = "DELETE FROM imoveis WHERE id = :id AND usuario_id = :uid";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id, ':uid' => $usuario_id]);
    }
}
