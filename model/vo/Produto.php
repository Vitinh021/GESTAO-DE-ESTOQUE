<?php

class Produto {

    private $id;
    private $descricao;
    private $preco;
    private $qtd;
    private $visibilidade;

    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getPreco() {
        return $this->preco;
    }

    function getQtd() {
        return $this->qtd;
    }

    function getVisibilidade() {
        return $this->visibilidade;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($desc) {
        $this->descricao = $desc;
    }

    function setPreco($preco) {
        $this->preco = $preco;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    function setVisibilidade($visibilidade) {
        $this->visibilidade = $visibilidade;
    }
}
