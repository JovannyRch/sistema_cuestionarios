<?php

session_start();

function validarTipoUsuario($tipo){
  validarSesion();
  $isValid = $_SESSION["user"]["tipo"] == $tipo;
  if(!$isValid){
    header("Location: login.php");
  }
}

function validarAdminProfe($tipo){
  validarSesion();
  $isValid = false;
  if($_SESSION["user"]["tipo"] == "admin" || $_SESSION["user"]["tipo"] == "profesor"){
      if($tipo == "admin" || $tipo == "profesor"){
        $isValid = true;
      }
  }
  if(!$isValid){
    header("Location: login.php");
  }
}

function validarSesion(){
  $isSessionActive = isset($_SESSION["user"]);
  if(!$isSessionActive){
    header("Location: login.php");
  }
}

function cerrarSesion(){
  unset($_SESSION['user']); 
  session_destroy();
  header("Location: login.php");
}