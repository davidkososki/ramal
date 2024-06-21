<?php

namespace Sed\Ramal\Helper;

class helperPagina {

    private $num_reg;
    private $pageSelected;
    private $inicial, $quant_pg, $quant_reg;
    private $links_laterais = 3;

    public function setPg($valor) {
        empty($valor) ? $this->pageSelected = 0 : $this->pageSelected = $valor;
    }

    public function setRegInicial() {
        $this->inicial = $this->pageSelected;
    }

    public function getRegInicial() {
        return $this->inicial;
    }

    public function setNumRegistros($valor) {
        $this->num_reg = $valor;
    }

    public function getNumRegistros() {
        return $this->num_reg;
    }

    public function setTotalRegistros($valor) {
        $this->quant_reg = $valor;
    }

    public function setQuantPg() {
        $this->quant_pg = ceil($this->quant_reg / $this->num_reg) + 1; //calcula quantidade de paginas
    }

    private function avanca10pg($url) {
        $soma10pg = $this->pageSelected + $this->links_laterais + 11;
        $i_pg2 = $soma10pg - 1;
        if ($soma10pg <= $this->quant_reg) {
            return "<span class=pg><b> &raquo;</b></a>" . "&nbsp;<a href=" . $url . "/$i_pg2 class=pg><b>$soma10pg</b></a>&nbsp;";
        }
    }

    private function retorna10pg($url) {
        $range = $this->pageSelected - $this->links_laterais;
        $soma10pg = $this->pageSelected - $this->links_laterais - 9;
        $i_pg2 = $soma10pg - 1;
        if ($range >= 10) {
            return "&nbsp;<a href=" . $url . "/$i_pg2 class=pg><b>$soma10pg</b></a>&nbsp;" . "<span class=pgoff>&laquo;</span>";
        }
    }

    private function avanca100pg($url) {
        $soma100pg = $this->pageSelected + $this->links_laterais + 101;
        $i_pg2 = $soma100pg - 1;
        if ($soma100pg <= $this->quant_reg) {
            return "<span class=pg><b> &raquo;</b></a>" . "&nbsp;<a href=" . $url . "/$i_pg2 class=pg><b>$soma100pg</b></a>&nbsp;";
        }
    }

    private function retorna100pg($url) {
        $range = $this->pageSelected - $this->links_laterais;
        $soma100pg = $this->pageSelected - $this->links_laterais - 99;
        $i_pg2 = $soma100pg - 1;
        if ($range >= 100) {
            return "&nbsp;<a href=" . $url . "/$i_pg2 class=pg><b>$soma100pg</b></a>&nbsp;" . "<span class=pgoff>&laquo;</span>";
        }
    }

    private function numeraPagina($url) {
        $this->quant_reg;
        /** @var type $inicio */
        $inicio = $this->pageSelected - $this->links_laterais + 1;
        /** @var type $limite */
        $limite = $this->pageSelected + $this->links_laterais + 1;
        $inicio > 0 ? $inicio : $inicio = 1;
        $limite <= $this->quant_reg ? $limite : $limite = $this->quant_reg;
        $valor = "";
        for ($i_pg = $inicio; $i_pg <= $limite; $i_pg++) {
            if ($this->pageSelected == ($i_pg - 1)) {
                $valor .= "&nbsp;<span class=pgoff>[$i_pg]</span>&nbsp;";
            } else {
                $i_pg2 = $i_pg - 1;
                $valor .= "&nbsp;<a href=" . $url . "/$i_pg2 class=pg><b>$i_pg</b></a>&nbsp;";
            }
        }
        return $valor;
    }

    public function paginacao($url) {
        $valor = "<div class=center width=50px>";
        $valor .= $this->retorna100pg($url);
        $valor .= $this->retorna10pg($url);
        $valor .= $this->numeraPagina($url);
        $valor .= $this->avanca10pg($url);
        $valor .= $this->avanca100pg($url);
        $valor .= "</div>";
        return $valor;
    }

}

// class=pg><b>pr&oacute;ximo &raquo;</b></a> <span class=pgoff>&laquo; anterior</span>