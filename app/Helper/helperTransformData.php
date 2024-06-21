<?php class helperTransformData {
            private $value;
            private function dateEng() {
                return "/^(\d{4})[s\-]?(\d{1,2})[\/\s\-]?(\d{1,2})$/";
            }
            private function datePort() {
                return "/^(\d{1,2})[\/\s\-]?(\d{1,2})[\/\s\-]?(\d{4})$/";
            }
            private function separadorDateTime($valor) {
                return "/^(\d{1,2})[\/\s\-]?(\d{1,2})[\/\s\-]?(\d{4})$/";
            }
            public function dateToEng($valor) {
                $pattern = $this->datePort(); //o que está entre parenteses sem escapar é representado pelas variáveis $1, $2 e $3
                $replacement = "$3-$2-$1";
                $this->value = preg_replace($pattern, $replacement, $valor);
                return $this->value;
            }
            public function dateToPort($valor) {
                $pattern = $this->dateEng();
                $replacement = "$3/$2/$1";
                $this->value = preg_replace($pattern, $replacement, $valor);
                return $this->value;
            }
            public function dateTimeEngToPort($valor) {
                $valor = explode(" ", $valor);
                $pattern = $this->dateEng();
                $replacement = "$3/$2/$1";
                $this->value = preg_replace($pattern, $replacement, $valor[0]);
                return $this->value;
            }
        }