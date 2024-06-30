<?php

class Upload extends Controller {
    public function index() {
        $modelFile = $this->loadModel("modelFile");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $code = $_POST['code'];
            $filiere_id = $_POST['filiere_id'];
            $file = $_FILES['file'];

            // Préparer les données à envoyer à la méthode upload()
            $data = [
                'name' => $name,
                'code' => $code,
                'filiere_id' => $filiere_id
            ];

            // Appeler la méthode upload() du modèle ModelFile
            $modelFile->upload($data, $file);
        }

        // Récupérer tous les fichiers triés par filière
        $files = $modelFile->getAllFiles();

        // Récupérer toutes les filières
        $filieres = $modelFile->getAllFilieres();
        $data['files'] = $files;
        $data['filieres'] = $filieres; // Passer les filières à la vue

        $data['page_title'] = "Upload";

        // Charger la vue avec les données
        $this->view("upload", $data);
    }
}

