<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDAO {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar(Usuario $usuario): bool {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome'  => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':senha' => password_hash($usuario->getSenha(), PASSWORD_BCRYPT),
        ]);
    }

    public function buscarPorEmail(string $email): ?array {
        $sql  = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function emailExiste(string $email): bool {
        $sql  = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return (bool) $stmt->fetch();
    }
}
