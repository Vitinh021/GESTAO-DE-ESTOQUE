<?php

class Venda {

    private $id;
    private $total;
    private $data;
    private $desconto;
    private $usuario;

    function getId() {
        return $this->id;
    }

    function getTotal() {
        return $this->total;
    }

    function getData() {
        return $this->data;
    }

    function getDesconto() {
        return $this->desconto;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
}
