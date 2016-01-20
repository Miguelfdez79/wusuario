<?php

class Util {
    static function getSelect($name, $parametros, $valorSeleccionado=null, $blanco=true, $atributos="", $email=null) {
//        <select name='x' id='y' z >
//            [<option value='a'>&nbsp;</option>]
//            <option selected value='a'>b</option>
//            <option value='c'>d</option>
//        </select>
        
        if($email !== null){
            $email = "email='$email'";
        }else{
            $email = "";
        }
        $r = "<select name='$name' $email $atributos>\n";
        
        //linea en blanco
        if($blanco === true){
            $r .= "<option value=''>&nbsp;</option>\n";
        }
        
        foreach ($parametros as $indice => $valor) {
            $seleted = "";
            if($valorSeleccionado !== null && $indice === $valorSeleccionado){
                $seleted = "selected";
            }
            $r .= "<option $seleted value='$indice'>$valor</option>\n";
        }
        $r .= "</select>\n";
        return $r;
    }
}
