<?php

class Conexao {
    private static $instancia = null;

    private string $host   = "localhost";
    private string $dbname = "imobiliaria";
    private string $user   = "root";
    private string $pass   = "";
    private string $charset = "utf8mb4";

    private function __construct() {}

    public static function getInstance(): PDO {
        if (self::$instancia === null) {
            $obj = new self();
            $dsn = "mysql:host={$obj->host};dbname={$obj->dbname};charset={$obj->charset}";

            $opcoes = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instancia = new PDO($dsn, $obj->user, $obj->pass, $opcoes);
            } catch (PDOException $e) {
                die("<div style='font-family:sans-serif;padding:20px;color:#c0392b;background:#fde;border:1px solid #c0392b;border-radius:6px;'>
                    <strong>Erro de conexão:</strong> " . htmlspecialchars($e->getMessage()) .
                    "<br><small>Verifique se o MySQL está ativo no XAMPP.</small></div>");
            }
        }
        return self::$instancia;
    }
}
