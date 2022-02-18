<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Testimony{

    /**
     * ID do Depoimento
     *
     * @var interger
     */
    public $id;

    /**
     * nome do usuario do Depoimento
     *
     * @var string
     */
    public $nome;

    /**
     * mensagem do Depoimento
     *
     * @var string
     */
    public $mensagem;

    /**
     * data de publicação do Depimento
     *
     * @var string
     */
    public $data;

    /**
     * Método Responsavél por cadastrar a instancia atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar(){
        //Define a data 
        $this->data = date('Y-m-d H:i:s');

        //Insere o Depoimento no banco de dados
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data
        ]);
        
        return true;
    }
    /**
     * Método Responsavel por retornar Depoimentos
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('depoimentos')) ->select($where, $order, $limit, $fields);
    }


}


?>