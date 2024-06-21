<?php class helperValidaDados {
            private $dados, $erro, $retornaErro, $campo;

    private function test_input($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->filter($value);
            }
        } else {
            $data = $this->filter($data);
        }
        return $data;
    }

    private function filter($param) {
        $param1 = trim($param);
        $param2 = addslashes($param1);
        return $param3 = htmlspecialchars($param2, ENT_COMPAT, "iso-8859-1");
    }

    public function setErro($campo, $err) {
        $this->erro[$campo] = $err;
        $this->retornaErro[$campo] = $err;
    }

    public function campoObrigatorio($text = false) {
        if ($this->dados[$this->campo] == "") {
            if ($text != false) {
                $this->setErro($this->campo, $text);
            } else {
                $this->setErro($this->campo, "* campo com preenchimento obrigatório.");
            }
        }
    }
    
    public function mostra() {
        print_r($this->dados);
        print_r($this->retornaErro);
    }

    public function setDado($nome, $required = true, $text = false, $value = "") {
        $this->campo = $nome;
        $this->retornaErro[$this->campo] = "";
        if (!empty($_POST[$nome])) {
            $valor = $_POST[$nome];
            $this->dados[$nome] = $this->test_input($valor);
        } else {
            if (!empty($_GET[$nome])) {
                $valor = $_GET[$nome];
                $this->dados[$nome] = $this->test_input($valor);
            } else {
                $this->dados[$nome] = $value;
            }
        }
        if ($required) {
            $this->campoObrigatorio($text);
        }
        return $this;
    }
    
    public function setValorDado($nome, $value) {
        $this->dados[$nome] = $value;
        return $this;
    }
    
    public function validar() {
        if ((is_array($this->erro) ? count($this->erro) : 0) > 0) {//necessário testar se é vetor em php7 ou mais
            return false;
        } else {
            return true;
        }
    }

    public function getDado($nome) {
        return $this->dados[$nome];
    }
    
    public function getErro($nome) {
        if (!empty($this->erro[$nome])) {
            return $this->erro[$nome];
        }
    }
    
    public function getDados() {
        return $this->dados;
    }
    
    public function getErros() {
        return $this->retornaErro;
    }
    
    public function email() {
        if (!filter_var($this->dados[$this->campo], FILTER_VALIDATE_EMAIL)) {
            $this->erro[$this->campo] = "* deve ser um e-mail válido.";
        }
        return $this;
    }

    public function numerico() {
        if (!is_numeric($this->dados[$this->campo])) {
            $this->setErro($this->campo, "* apenas números.");
        }
        return $this;
    }

    public function dataBR() {
        if (!preg_match("/^\d{1,2}[\/\s\-]?\d{1,2}[\/\s\-]?\d{4}$/", $this->dados[$this->campo])) {
            $this->erro[$this->campo] = "* a data deve ser no formato dd/mm/aaaa.";
        }
        return $this;
    }

    public function cpfCnpj() {
        require_once('helperValidaCPFCNPJ.php');
        $cpf_cnpj  = new ValidaCPFCNPJ($this->dados[$this->campo]);
        if (!$cpf_cnpj->valida()) {
            $this->erro[$this->campo] = "* deve ser um cpf ou cnpj válido";
        }
        return $this;
    }

    public function fone() {
        if (!preg_match("/^\(?[\d]{2}\)?\s?([\d]{4})[\s\-]?([\d]{4})$/", $this->dados[$this->campo])) {
            $this->setErro($this->campo, "* deve estar no formato (99)9999-9999.");
        }
        return $this;
    }

    function makeRandomPassword() {
        $i = 0;
        $pass = "";
        while ($i < 6) {
            $num = rand(0, 55); //seleciona um número aleatorio de 0 a 55.
            $tmp = substr("ABCHEFGHJKMNPQRSTUVWXYZabchefghjkmnpqrstuvwxyz1234567890", $num, $num + 1); //subistitui uma letra de acordo com a posição desta no texto  baseado no número gerado na variável $num.
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }
    
    public function senha() {
        $this->dados[$this->campo] = sha1($this->dados[$this->campo]);
        return $this;
    }

    public function codigoRepresentante() {
        require_once('./Controller/DivulgadorController.php');
        $cad = new DivulgadorDAO();
        if (!$cad->verificaCampo("iddvr", $this->dados[$this->campo])) {
            $this->setErro($this->campo, "* código inválido ou inexistente.");
        }
        return $this;
    }

    public function loginUsuarios() {
        require_once('./Controller/UsuariosController.php');
        $cad = new UsuariosDAO();
        if ($cad->verificaCampo("loginuser", $this->dados[$this->campo])) {
            $this->setErro($this->campo, "* login sendo utilizado! Escolha outro login.");
        }
        return $this;
    }

}