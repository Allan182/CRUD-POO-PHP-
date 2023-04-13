<?php

require('mysql.php');

class Banco
{

    private $codigo;
    private $conta;
    private $agencia;
    private $senha;

    public function __construct($conta = null, $agencia = null, $senha = null, $codigo = null)
    {
        $this->conta = $conta;
        $this->senha = md5($senha);
        $this->codigo = $codigo;
        $this->agencia = $agencia;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getAgencia()
    {
        return $this->agencia;
    }

    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }

    public function getConta()
    {
        return $this->conta;
    }

    public function setConta($conta)
    {
        $this->conta = $conta;
    }


    public function criar()
    {

        global $mysql;

        $resultado = $mysql->prepare("INSERT INTO `banco` (`codColuna`, `conta`, `agencia`, `senha`) VALUES (NULL, ?, ?, ?);");
        $resultado->bind_param("sss", $this->conta,  $this->agencia, $this->senha);
        $resultado->execute();

        if ($resultado->affected_rows > 0) {
            $this->setCodigo($resultado->insert_id);
            return true;
        } else {
            return false;
        }
    }

    static function ler()
    {

        global $mysql;

        $resultado = $mysql->prepare("SELECT * FROM `banco`");
        $resultado->execute();
        $dados = $resultado->get_result();


        $dado = $dados->fetch_all(MYSQLI_ASSOC);

        return $dado;
    }

    public function imprimir()
    {
        print_r($this);
    }

    static function imprimirUsuarios()
    {
        print_r(self::ler());
    }

    public function editar($conta , $agencia, $senha , $codigo)
    {

        global $mysql;

        $senhaCrypt = md5($senha);

        $resultado = $mysql->prepare("UPDATE `banco` SET `conta` = ?, `agencia` = ?, `senha` = ? WHERE `banco`.`codColuna` = ?;");
        $resultado->bind_param("sssi", $conta,  $agencia, $senhaCrypt, $codigo); 
        $resultado->execute();

        if ($resultado->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function lerByID($codigo)
    {

        global $mysql;

        $resultado = $mysql->prepare("SELECT * FROM `banco` WHERE codColuna = ?");
        $resultado->bind_param("i", $codigo);
        $resultado->execute();
        $dados = $resultado->get_result();

        $dado = $dados->fetch_all(MYSQLI_ASSOC);


        $this->setCodigo($dado[0]["codColuna"]);
        $this->setConta($dado[0]["conta"]);
        $this->setAgencia($dado[0]["agencia"]);
        $this->setSenha($dado[0]["senha"]);
    }





    public function deletar()
    {

        global $mysql;


        $resultado = $mysql->prepare("DELETE FROM `banco` WHERE `banco`.`codColuna` = ?");
        $resultado->bind_param("i", $this->codigo);
        $resultado->execute();

        if ($resultado->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
