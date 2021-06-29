<?php

require "database.php";

class Consultas
{
    public function __construct()
    {
        $this->db = new DB();
    }

    public function iniciarSesion($correo, $pass){
       

        $usuario_admin = $this->db->row("SELECT * from admin where correo = '$correo' and passw = '$pass'");
        if(isset($usuario_admin)){
            return array("tipo" => "admin", "usuario" => $usuario_admin);
        }

        
        $usuario_profesor = $this->db->row("SELECT * from profesor where correo = '$correo' and pass = '$pass'");
        if(isset($usuario_profesor)){
            return array("tipo" => "profesor", "usuario" => $usuario_profesor);
        }


        $usuario_normal = $this->db->row("SELECT * from persona where correo = '$correo' and passw = '$pass'");
        if(isset($usuario_normal)){
            return array("tipo" => "normal", "usuario" => $usuario_normal);
        }

        return null;
    }

    public function getCuestionarios(){
        $cuestionarios = $this->db->array("SELECT cuestionario.*, categoria.nom_categoria from cuestionario natural join categoria");
        return $cuestionarios;
    }

    public function eliminarCuestionario($id_cuestionario){
        return $this->db->query("DELETE FROM cuestionario WHERE id_cuestionario = $id_cuestionario");
    }

    public function getCategorias(){
        return $this->db->array("SELECT * from categoria");
    }

    public function crearCuestionario($nom_cuestionario, $id_categoria){
        return $this->db->query("INSERT INTO cuestionario (nom_cuestionario, id_categoria) value('$nom_cuestionario', '$id_categoria')");
    }

    public function getCuestionario($id_cuestionario){
        return $this->db->row("SELECT cuestionario.*, categoria.nom_categoria from cuestionario natural join categoria where cuestionario.id_cuestionario = $id_cuestionario");
    }

    public function updateCuestionario($id_cuestionario, $nom_cuestionario, $id_categoria){
        return $this->db->query("UPDATE cuestionario set nom_cuestionario = '$nom_cuestionario', id_categoria = $id_categoria where id_cuestionario = $id_cuestionario");
    }

    public function getPreguntas(){
        return $this->db->array("SELECT * from pregunta");
    }

    public function getPregunta($id_pregunta){
        return $this->db->row("SELECT * from pregunta where id_pregunta = $id_pregunta");
    }

    public function crearPregunta($pregunta, $a, $b, $c, $d, $e, $correcta){
        return $this->db->query("INSERT INTO pregunta(pregunta, respA, respB, respC, respD, respE, respCorrecta)
            values('$pregunta', '$a', '$b', '$c', '$d', '$e', '$correcta')
        ");
    }

    public function updatePregunta($id_pregunta, $pregunta, $a, $b, $c, $d, $e, $correcta){
        return $this->db->query("UPDATE pregunta 
        set pregunta = '$pregunta', 
        respA = '$a', 
        respB = '$b', 
        respC = '$c', 
        respD = '$d', 
        respE = '$e', 
        respCorrecta = '$correcta' 
        where id_pregunta = $id_pregunta
        ");
    }

    public function deletePregunta($id_pregunta){
        return $this->db->query("DELETE FROM pregunta WHERE id_pregunta = $id_pregunta");
    }
}



function response($data)
{
    echo json_encode($data);
}


function responseError($message)
{
    response(array('success' => 0, 'error' => $message));
}

function responseSuccess($message)
{
    response(array('success' => 1, 'msg' => $message));
}

function getParam($name){
  if (isset($_POST[$name])) {
    return $_POST[$name];
  }else{
    return null;
  }
}