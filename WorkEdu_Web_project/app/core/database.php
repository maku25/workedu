<?php

class Database 
{
    public function db_connect()
    {
        try 
        {
            $string = DB_TYPE . ":hostname=" . DB_HOST . ";dbname=" . DB_NAME . ";";
            return $db = new PDO($string, DB_USER, DB_PASS);

        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public function read($query, $data = [])
    {
        $DB = $this->db_connect();
        $stm = $DB->prepare($query);

        if (count($data) === 0)
        {
            $stm = $DB->query($query);
            $check = 0;
            if ($stm) $check = 1;
        } else {
            $check = $stm->execute($data);
        }
        
        if ($check)
        {
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function write($query, $data = [])
    {
        $DB = $this->db_connect();
        $stm = $DB->prepare($query);

        if (count($data) === 0)
        {
            $stm = $DB->query($query);
            $check = 0;
            if ($stm) $check = 1;
        } else {
            $check = $stm->execute($data);    
        }
        
        if ($check)
        {
            return true;
        } else {
            return false;
        }
    }
}