<?php

class Models{

    public static function getPDO(){
        $config = [
            'host' => 'localhost',
            'database' => 'landry',
            'username' => 'root',
            'password' => ''
        ];
        return $pdo  = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['database'],$config['username'],$config['password']);
    }

    public $table;
    
    public static function create($data,$table)
    {
        $pdo = Models::getPDO();
        $columns = array_keys($data);
        $values = array_fill(0, count($data), '?');

        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ")";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(array_values($data));

        if ($result) {
            $pdo = null;
            return true;
        } else {
            $pdo = null;
            return false;
        }
    }

    public static function update()
    {
        // 
    }

    public static function validate($data,$table)
    {
        $pdo = Models::getPDO();
        $columns = array_keys($data);
        $values = array_fill(0, count($data), '?');
        print_r($pdo);
        $sql = "SELECT * FROM ".$table." WHERE (" . implode(', ', $columns) . ") = (" . implode(', ', $values) . ")";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute(array_values($data));
        $count = $stmt->rowCount();

        if ($count == 1) {
            $pdo = null;
            return true;
        } else {
            $pdo = null;
            return false;
        }
    }

    public static function all($table)
    {
        $pdo = Models::getPDO();
        $sql = "SELECT * FROM {$table}";
        $sth = $pdo->prepare($sql);
        if ($sth === false) {
            // Gestion de l'erreur de préparation de la requête
            return false;
        }
        $result = $sth->execute();
        if ($result === false) {
            // Gestion de l'erreur d'exécution de la requête
            return false;
        }
        return $sth->fetchAll();
    }
    
}