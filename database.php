<?php


class DB
{
    public function __construct()
    {
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'sistema_cuestionarios';

        try {
            $this->db = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
        } catch (PDOException $e) {
            die('Connection Failed: ' . $e->getMessage());
        }
    }

    //Funciones especiales para las consultas
    public function row($sql)
    {
        $resultado = $this->db->prepare($sql);
        if ($resultado->execute()) {
            $arreglo =  $this->utf8_converter($resultado->fetchAll(PDO::FETCH_ASSOC));
            if (sizeof($arreglo) > 0) {
                return $arreglo[0];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function array($sql)
    {
        $resultados = $this->db->prepare($sql);
        if ($resultados->execute()) {
            return $this->utf8_converter($resultados->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return null;
        }
    }

    public function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }


    public function query($sql)
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute();
    }
}
