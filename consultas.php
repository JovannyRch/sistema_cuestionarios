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
        return $this->db->query("INSERT INTO cuestionario (nom_cuestionario, id_categoria) values('$nom_cuestionario', '$id_categoria')");
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

    public function getAlumnos(){
        return $this->db->array("SELECT * from persona");
    }

    public function getCuestionariosPorAlumno($id_alumno){
        return $this->db->array("SELECT cuestionario.*, categoria.nom_categoria from cuestionario natural join categoria
        where cuestionario.id_cuestionario in (SELECT id_cuestionario from insertar_persona_cuestionario where id_persona = $id_alumno)");
    }

    public function getCuestionariosPorAlumnoConEstatus($id_alumno){

        //TODO: @Fix: After
        $inscripciones = $this->db->array("SELECT * from insertar_persona_cuestionario where id_persona = $id_alumno");
        

        foreach ($inscripciones as &$inscripcion) {
            $id_cuestionario = $inscripcion["id_cuestionario"];
            $id_ins_per_cuest = $inscripcion["id_ins_per_cuest"];
            $cuestionario = $this->db->array("SELECT cuestionario.*, categoria.nom_categoria from cuestionario natural join categoria
                 where cuestionario.id_cuestionario = $id_cuestionario");
            $inscripcion['cuestionario'] = $cuestionario;
            $count = $this->db->row("SELECT count(*) as total from respuestas_per_cuest where id_ins_per_cuest = $id_ins_per_cuest")["total"];
            $inscripcion['total'] = intval($count);
            
        }

        return $inscripciones;
    }   

    public function resultadoCuestionarioAlumno($id_alumno, $id_cuestionario){
        $preguntas = $this->db->array("SELECT * from pregunta where id_pregunta 
        in (select id_pregunta from cuest_pregunta where id_cuestionario = $id_cuestionario)");

        $id_ins_per_cuest = $this->db->row("SELECT id_ins_per_cuest from insertar_persona_cuestionario 
        where id_persona = $id_alumno and id_cuestionario = $id_cuestionario")["id_ins_per_cuest"];

        foreach($preguntas as &$pregunta){
            $id_pregunta = $pregunta["id_pregunta"];
            $id_cuest_pregunta = $this->db->row("SELECT id_cuest_pregunta from cuest_pregunta 
            where id_pregunta = $id_pregunta and id_cuestionario = $id_cuestionario")["id_cuest_pregunta"];
            $resultado = $this->db->row("SELECT respuesta, valor from respuestas_per_cuest where id_cuest_pregunta = $id_cuest_pregunta and id_ins_per_cuest = $id_ins_per_cuest");
            $pregunta["resultado"] = $resultado;
        }        

        return $preguntas;
    }

    public function getPreguntasCuestionario($id_cuestionario){
        $preguntas = $this->db->array("SELECT * from pregunta where id_pregunta 
        in (select id_pregunta from cuest_pregunta where id_cuestionario = $id_cuestionario)");

        return $preguntas;
    }
    public function getPreguntasDisponibles($id_cuestionario){
        $preguntas = $this->db->array("SELECT * from pregunta where id_pregunta 
        NOT IN (select id_pregunta from cuest_pregunta where id_cuestionario = $id_cuestionario)");

        return $preguntas;
    }

    public function deletePreguntaCuestionario($id_pregunta, $id_cuestionario){
        return $this->db->query("DELETE FROM cuest_pregunta WHERE id_pregunta = $id_pregunta AND id_cuestionario = $id_cuestionario");
    }
    public function addPreguntaCuestionario($id_pregunta, $id_cuestionario){
        return $this->db->query("INSERT INTO cuest_pregunta(id_cuestionario, id_pregunta)
            values($id_cuestionario, $id_pregunta)
        ");

    }

    public function getAlumnosInscritos($id_cuestionario){
        $alumnos = $this->db->array("SELECT * from persona where id_persona
        in (select id_persona from insertar_persona_cuestionario where id_cuestionario = $id_cuestionario)");

        return $alumnos;
    }
    public function getAlumnosNoInscritos($id_cuestionario){
        $alumnos = $this->db->array("SELECT * from persona where id_persona
        NOT IN (select id_persona from insertar_persona_cuestionario where id_cuestionario = $id_cuestionario)");

        return $alumnos;
    }

    public function deleteAlumnoCuestionario($id_persona, $id_cuestionario){
        return $this->db->query("DELETE FROM insertar_persona_cuestionario WHERE id_persona = $id_persona AND id_cuestionario = $id_cuestionario");
    }
    public function addAlumnoCuestionario($id_persona, $id_cuestionario, $calificacion){
        return $this->db->query("INSERT INTO insertar_persona_cuestionario (id_persona, id_cuestionario, cal_cuestionario) values( '$id_persona', '$id_cuestionario', '$calificacion')
        ");
    }
}

/*
SELECT id_ins_per_cuest from insertar_persona_cuestionario 
        where id_persona = 2 and id_cuestionario = 4;

*/



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