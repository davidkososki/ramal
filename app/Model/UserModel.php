<?php

namespace Sed\Ramal\Model;

use WilliamCosta\DatabaseManager\Database;

class UserModel {
    /*
     * ID da organização
     * @var integer
     */

    public $id_usuario;

    /*
     * Nome do usuário
     * @var string
     */
    public $nome_usuario;

    /*
     * E-mail do usuário
     * @var string
     */
    public $email_usuario;

    /*
     * Senha
     * @var string
     */
    public $senha_usuario;
    
    public static function getUserByEmail($email) {
        return (new Database('usuario'))->select('email_usuario = "'.$email.'"')->fetchObject(self::class);
    }
    
    /*
     * Nétodo responsável por cadastrar a instância atual no banco de dados
     * @return boolean
     */
    public function cadastrar() {

        //INSERE OS DADOS NA TABELA usuarios
        $this->id = (new Database('usuario'))->insert([
            'nome_usuario' => $this->nome_usuario,
            'email_usuario' => $this->email_usuario,
            'senha_usuario' => $this->senha_usuario
        ]);
        return true;
    }
    
    /*
     * Nétodo responsável por atualizar os dados com a instância atual no banco de dados
     * @return boolean
     */
    public function atualizar() {
        
        //ATUALIZA OS DADOS NA TABELA usuarios
        return (new Database('usuario'))->update('id_usuario ='.$this->id_usuario, [
            'nome_usuario' => $this->nome_usuario,
            'email_usuario' => $this->email_usuario,
            'senha_usuario' => $this->senha_usuario
                
        ]);

    }
    
    /*
     * Método responsável por retornar um depoimento com bse no id
     * @param integer $id
     * @return User
     */
    public static function getUserById($id){
        return self::getUser('id_usuario = '.$id)->fetchObject(self::class);
    }
    
    /*
     * Método responsável por retornar Depoimentos
     * @param string $were
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatemant
     */
    public static function getUser($where = null, $order = null, $limit = null, $fields = '*') {
        return (new Database('usuario'))->select($where, $order, $limit, $fields);
    }
    
    /*
     * Nétodo responsável por excluir depoimento do banco de dados
     * @return boolean
     */
    public function excluir() {
        
        //EXCLUI O DEPOIMENTO DO BANCO DE DADOS
        return (new Database('usuario'))->delete('id_usuario ='.$this->id_usuario);
        
    }

}
