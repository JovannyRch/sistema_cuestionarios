<?php

require "database.php";

class Consultas
{
    public function __construct()
    {
        $this->db = new DB();
    }

    public function iniciarSesion($correo, $pass){
       

        $usuario_admin = $this->db->registro("SELECT * from admin where correo = '$correo' and passw = '$pass'");
        if(isset($usuario_admin)){
            return array("tipo" => "admin", "usuario" => $usuario_admin);
        }

        $usuario_normal = $this->db->registro("SELECT * from persona where correo = '$correo' and passw = '$pass'");
        if(isset($usuario_normal)){
            return array("tipo" => "normal", "usuario" => $usuario_normal);
        }

        return null;
    }

}
