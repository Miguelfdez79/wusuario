<?php

class Usuario {
    
    private $email, $clave, $alias, $fechaalta, $activo, $administrador, $personal;
            
    function __construct($email = null , $clave = null, $alias = null, $fechaalta = null, $activo = 0, $administrador = 0, $personal = 0) {
        $this->email = $email;
        $this->clave = $clave;
        $this->alias = $alias;
        $this->fechaalta = $fechaalta;
        $this->activo = $activo;
        $this->administrador = $administrador;
        $this->personal = $personal;
    }
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function getAlias() {
        return $this->alias;
    }

    function getFechaalta() {
        return $this->fechaalta;
    }

    function getActivo() {
        return $this->activo;
    }

    function getAdministrador() {
        return $this->administrador;
    }

    function getPersonal() {
        return $this->personal;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    function setFechaalta($fechaalta) {
        $this->fechaalta = $fechaalta;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    function setAdministrador($administrador) {
        $this->administrador = $administrador;
    }

    function setPersonal($personal) {
        $this->personal = $personal;
    }

        public function getJson() {
        $r = '{';
        foreach ($this as $indice => $valor) {
            $r .= '"' . $indice . '"' . ':' . '"' . $valor . '"' . ',' ;
        }
        $r = substr($r, 0, -1);
        $r .= '}';
        return $r;
    }
    
    function set($valores, $inicio=0) {
        $i = 0;
        foreach ($this as $indice => $valor) {
            $this->$indice = $valores[$i+$inicio];
            $i++;
        }
    }
    
     public function __toString() {
        $r = '';
        foreach ($this as $key => $valor){
            $r .= "$valor ";
        }
        return $r;
    }
    
      public function getArray($valores=true) {
        $array = array();
        foreach ($this as $key => $valor) {
            if($valores===true){
                $array[$key] = $valor;
            }else{
                $array[$key] = null;
            }
        }
        return $array;
    }
    
    function read() {
        foreach ($this as $key => $valor){
            $this->$key = Request::req($key);
        }
    }
    
    function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
} 

    
}
