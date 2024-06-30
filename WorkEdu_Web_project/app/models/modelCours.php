<?php

class ModelCours {
    protected $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function getCoursByFiliere($filiere_id) {
        $query = "SELECT * FROM cours WHERE filiere_id = :filiere_id";
        $params = [':filiere_id' => $filiere_id];
        $result = $this->database->read($query, $params);
        return $result;
    }

    public function getAllFiles() {
        // Query to select all files and their destinations
        $query = "SELECT destination FROM fichier";
    
        // Execute the query
        $files = $this->database->read($query);
    
        // Check if files were retrieved successfully
        if ($files) {
            // Array to store file destinations
            $filePaths = array();
    
            // Loop through the files and store their destinations
            foreach ($files as $file) {
                // Access destination property of the object
                $filePaths[] = $file->destination;
            }
    
            return $filePaths; // Return array of file destinations
        } else {
            return false; // Return false if no files were retrieved or an error occurred
        }
    }
}
