<?php
namespace Sed\Ramal\Model;

use WilliamCosta\DatabaseManager\Database;

class RamalModel{
    

    public $id_pessoa;

    public $nome_pessoa;

    public $email_pessoa;

    public $telefone_pessoa;

    public $celular_pessoa;

    public $andar_pessoa;

    public $id_gerencia_pessoa;

    
    /*
     * Nétodo responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar() {
        //DEFINE A DATA
        $this->data = date('Y-m-d H:i:s');
        
        //INSERE OS DADOS NA TABELA depoimentos
        $this->id = (new Database('pessoa'))->insert([
            'nome_pessoa' => $this->nome_pessoa,
            'email_pessoa' => $this->email_pessoa,
            'telefone_pessoa' => $this->telefone_pessoa,
            'celular_pessoa' => $this->celular_pessoa,
            'andar_pessoa' => $this->andar_pessoa,
            'id_gerencia_pessoa' => $this->id_gerencia_pessoa
        ]);
        return true;
    }
    
    /*
     * Nétodo responsável por atualizar os dados com a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar() {
         
        //ATUALIZA OS DADOS NA TABELA depoimentos
        return (new Database('pessoa'))->update('id_pessoa ='.$this->id_pessoa, [
            'nome_pessoa' => $this->nome_pessoa,
            'email_pessoa' => $this->email_pessoa,
            'telefone_pessoa' => $this->telefone_pessoa,
            'celular_pessoa' => $this->celular_pessoa,
            'andar_pessoa' => $this->andar_pessoa,
            'id_gerencia_pessoa' => $this->id_gerencia_pessoa
        ]);

    }
    
    /*
     * Método responsável por retornar um depoimento com bse no id
     * @param integer $id
     * @return Testimony
     */
    public static function getRamalById($id){

        return self::getRamal('id_pessoa = '.$id)->fetchObject(self::class);
    }
    
    /*
     * Método responsável por retornar Depoimentos
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function getRamal($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('pessoa'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Método responsável pesguisar servidores
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function searchRamal($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('pessoa p join gerencia g on g.id_gerencia = p.id_pessoa join diretoria d on g.id_diretoria_gerencia = d.id_diretoria'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Nétodo responsável por excluir depoimento do banco de dados
     * @return boolean
     */
    public function excluir() {
        
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('pessoa'))->delete('id_pessoa ='.$this->id_pessoa);

    }
    
    
}