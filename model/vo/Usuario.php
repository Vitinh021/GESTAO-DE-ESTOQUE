<?php

class Usuario {
    private $id;
    private $nome;
    private $senha;
    private $visibilidade;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getSenha() {
        return $this->senha;
    }

    function getVisibilidade() {
        return $this->visibilidade;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setVisibiliade($visibilidade   ) {
        $this->visibilidade = $visibilidade;
    }
}
