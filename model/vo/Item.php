<?php

class Item {

    private $id;
    private $venda;
    private $produto;
    private $qtd;

    function getId() {
        return $this->id;
    }

    function getVenda() {
        return $this->venda;
    }

    function getProduto() {
        return $this->produto;
    }

    function getQtd() {
        return $this->qtd;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setVenda($venda) {
        $this->venda = $venda;
    }

    function setProduto($produto) {
        $this->produto = $produto;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
    }
}
