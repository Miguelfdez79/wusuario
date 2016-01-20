<?php

//select * from country co join city ci on co.Code = ci.CountryCode
    //No se hace.
    
//select co.*, ci.* from country co join city ci on co.Code = ci.CountryCode
    //no es lo mismo que:
//select ci.*, co.* from country co join city ci on co.Code = ci.CountryCode
    //hacen lo mismo pero presentan los datos de forma diferente

//select ci.*, co.* from country co left join city ci on co.Code = ci.CountryCode
    //muestra todas los paises y muestrame todas sus ciudades aunque no tenga ciudades (null)

//select ci.*, co.* from city ci left join country co on co.Code = ci.CountryCode;
    //muestra todas las ciudades y muestrame sus paises  aunque no tenga país (no tiene mucha lógica).

//select ci.*, co.*, cl.* from country co left join city ci on co.Code = ci.CountryCode left join countrylanguage on...

class ManageRelations {
    private $bd = null;
    
    function __construct(DataBase $bd) {
        $this->bd = $bd;
    }
    
    function getListCountryCityCountryLanguage($condicion=null, $parametros=array()) {
        if($condicion === null) {
            $condicion = "";
        }else{
            $condicion = "where $condicion";
        }
        $sql = "select co.*, ci.*, cl.* 
                from country co 
                left join city ci
                on co.Code = ci.CountryCode 
                left join countrylanguage cl 
                on co.Code = cl.CountryCode where $condicion";
        
        $this->bd->send($sql, $parametros);
        $r = array();
        $contador = 0;
        while ($fila = $this->bd->getRow()){
            $country = new Country();
            $country->set($fila);
            $city = new City();
            $city->set($fila,15);
//            $countrylanguage = new Countrylanguage();
//            $countrylanguage->set($fila, 20);
            $r[$contador]["country"] = $country;
            $r[$contador]["city"] = $city;
//            $r[$contador]["countrylanguage"] = $countrylanguage;
            $contador++;
        }
        return $r;
    }
}


//METER EN OTRO ARCHIVO
class CountryCityCountryLanguage{
    private $country, $city, $countrylanguage;
    
    function __construct(Country $country, City $city, CountryLanguage $countrylanguage) {
        $this->country = $country;
        $this->city = $city;
        $this->countrylanguage = $countrylanguage;
    }
    
    public function getCountry() {
        return $this->country;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountrylanguage() {
        return $this->countrylanguage;
    }

    public function setCountry(Country $country) {
        $this->co = $country;
    }

    public function setCi(City $city) {
        $this->ci = $city;
    }

    public function setCountrylanguage(CountryLanguage $countrylanguage) {
        $this->countrylanguage = $countrylanguage;
    }

    function getListCountryCityCountryLanguage($condicion=null, $parametros=array()) {
        if($condicion === null) {
            $condicion = "";
        }else{
            $condicion = "where $condicion";
        }
        $sql = "select co.*, ci.*, cl.* 
                from country co 
                left join city ci
                on co.Code = ci.CountryCode 
                left join countrylanguage cl 
                on co.Code = cl.CountryCode where $condicion";
        
        $this->bd->send($sql, $parametros);
        $r = array();
        //$contador = 0;
        while ($fila = $this->bd->getRow()){
            $country = new Country();
            $country->set($fila);
            $city = new City();
            $city->set($fila,15);
            $countrylanguage = new Countrylanguage();
            $countrylanguage->set($fila, 20);
//            $r[$contador]["country"] = $country;
//            $r[$contador]["city"] = $city;
//            $r[$contador]["countrylanguage"] = $countrylanguage;
//            $contador++;
            $r[] = new CountryCityCountryLanguage($country, $city, $countrylanguage);
        }
        return $r;
    }
    
    //para llamarlo $gestor = new ManageRelations()

}
