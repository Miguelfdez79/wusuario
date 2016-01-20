<?php

class ManageUsuario {

    private $bd = null;
    private $tabla = "usuario";

    function __construct(DataBase $bd) {
        $this->bd = $bd;
    }

    function get($email) {
        //devuelve el objeto de la fila cuyo id coincide con el id que le estoy pasando
        //devuelve el objeto entero
        $parametros = array();
        $parametros["email"] = $email;
        $this->bd->select($this->tabla, "*", "email =:email", $parametros);
        $fila = $this->bd->getRow();
        $usuraio = new Usuario();
        $usuraio->set($fila);
        return $usuraio;
    }

    function count($condicion = "1=1", $parametros = array()) {
        return $this->bd->count($this->tabla, $condicion, $parametros);
    }

    function delete($ID) {
        //borrar por id
        $parametros = array();
        $parametros["email"] = $ID;
        return $this->bd->delete($this->tabla, $parametros);
    }

//    function deleteCities($parametros) {
//        return $this->bd->delete($this->tabla, $parametros);
//    }

    function erase(Usuario $usuario) {
        //borrar por nombre
        //dice ele numero de filas borratas
        return $this->delete($usuario->getID());
    }

    function set(Usuario $usuario, $emailanterior) {
        //update de todos los campos de la city menos del ID
        //dice el numero de filas modificades
        $parametros = $usuario->getArray();
        $parametrosWhere = array();
        $parametrosWhere["email"] = $emailanterior;
        $this->bd->update($this->tabla, $parametros, $parametrosWhere);
    }

    function insert(Usuario $usuario) {
        //se le pasa un objeto City y lo inserta en la tabla
        //dice el numero de filas insertadas;
        $parametrosSet = array();
        $parametrosSet["email"] = $usuario->getEmail();
        $parametrosSet["clave"] = $usuario->getClave();
        $parametrosSet["alias"] = $usuario->getAlias();
        $parametrosSet["fechaalta"] = $usuario->getFechaalta();
        $parametrosSet["activo"] = $usuario->getActivo();
        $parametrosSet["administrador"] = $usuario->getAdministrador();
        $parametrosSet["personal"] = $usuario->getPersonal();
        return $this->bd->insert($this->tabla, $parametrosSet);
    }

    function getList($pagina = 1, $orden = "", $nrpp = Constants::NRPP, $condicion = "1=1", $parametros = array()) {
        $ordenPredeterminado = "$orden, alias, fechaalta, email";
        if (trim($orden) === "" || trim($orden) === null) {
            $ordenPredeterminado = "alias, fechaalta, email";
        }
        $registroInicial = ($pagina - 1) * $nrpp;
        $this->bd->select($this->tabla, "*", $condicion, $parametros, $ordenPredeterminado, "$registroInicial, $nrpp");
        $r = array();
        while ($fila = $this->bd->getRow()) {
            $usuario = new Usuario();
            $usuario->set($fila);
            $r[] = $usuario;
        }
        return $r;
    }
    
         function getListAll() {
        $this->bd->select($this->tabla, "*", "1=1", array(), "alias, fechaalta, email");
        $r = array();
        while ($fila = $this->bd->getRow()){
            $usuario = new Usuario();
            $usuario->set($fila);
            $r[] = $usuario;
        }
        return $r;
    }

    function getValuesSelect() {
        $this->bd->query($this->tabla, "ID, Name", array(), "Name");
        $array = array();
        while ($fila = $this->bd->getRow()) {
            $array[$fila[0]] = $fila[1];
        }
        return $array;
    }

}
