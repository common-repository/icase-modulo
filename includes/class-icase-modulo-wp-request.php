<?php

class ItargetRequest {

    private $_url_production  = null;
    private $_resposta = null;

    public function __construct() {
       // @session_start();
    }

    public function setParams($params) {
        $this->_resposta = wp_remote_post($this->_url_production,
            array(
                'method'    => 'POST',
                'body'      => array(
                    'login' => $params[login],
                    'senha' => $params[senha])
                    )
            );
    }
    
    public function setUrl($url){
        $this->_url_production = $url;
    }

    public function getResposta() {
        $resposta = json_decode($this->_resposta[body], true);
        if(!isset($resposta)){
            $resposta['logado'] = false;
            $resposta['mensagen'] = 'Erro de comunicar com o servidor';
        }
        return $resposta;
    }

    public function montaSessao() {
        $resposta = $this->getResposta();
        if($resposta['logado'] == true)
        foreach($this->getResposta() as $key => $valor){
            $_SESSION[$key] = $valor;
        }
    }
    
}

?>
