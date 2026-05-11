<?php
// model/Imovel.php

class Imovel {
    private int    $id;
    private string $titulo;
    private string $descricao;
    private float  $preco;
    private string $endereco;

    public function getId(): int          { return $this->id; }
    public function getTitulo(): string   { return $this->titulo; }
    public function getDescricao(): string{ return $this->descricao; }
    public function getPreco(): float     { return $this->preco; }
    public function getEndereco(): string { return $this->endereco; }

    public function setId(int $id): void              { $this->id        = $id; }
    public function setTitulo(string $t): void        { $this->titulo    = $t; }
    public function setDescricao(string $d): void     { $this->descricao = $d; }
    public function setPreco(float $p): void          { $this->preco     = $p; }
    public function setEndereco(string $e): void      { $this->endereco  = $e; }
}
