<?php

class ModelFile {
    public function upload($data, $file) {
        $database = new Database();
    
        if (isset($file['name']) && isset($data['name'])) {
            $fileName = basename($file['name']);
            $fileTmpName = $file['tmp_name'];
    
            $folder = __DIR__ . '/../../public/uploads/';
            $destination = $folder . $fileName;
    
            if ($file['type'] == 'application/pdf') {
                if (move_uploaded_file($fileTmpName, $destination)) {
                    $nomCours = $data['name'];
                    $codeCours = $data['code'];
                    $filiere_id = $data['filiere_id'];
    
                    $tab = [
                        'nom' => $nomCours,
                        'code' => $codeCours,
                        'filiere_id' => $filiere_id,
                        'cheminFichier' => $destination
                    ];
    
                    $query = "INSERT INTO cours (nom, code, filiere_id, cheminFichier) ";
                    $query .= "VALUES (:nom, :code, :filiere_id, :cheminFichier)";
    
                    $resultat = $database->write($query, $tab);
    
                    if ($resultat) {
                        $_SESSION['success'] = 'Fichier PDF téléchargé et enregistré avec succès.';
                    } else {
                        $_SESSION['error'] = 'Échec de l\'enregistrement du fichier dans la base de données.';
                    }
                } else {
                    $_SESSION['error'] = 'Erreur lors du déplacement du fichier.';
                }
            } else {
                $_SESSION['error'] = 'Veuillez télécharger un fichier PDF.';
            }
        } else {
            $_SESSION['error'] = 'Des données de fichier ou du formulaire sont manquantes.';
        }
    }
    
    

    public function getAllFiles() {
        $database = new Database();
        $query = "SELECT * FROM cours ORDER BY filiere_id"; 
        $result = $database->read($query);
    
        $files = [];
        if ($result) {
            foreach ($result as $file) {

                $files[] = [
                    'nom' => $file->nom, 
                    'code' => $file->code,
                    'filiere_id' => $file->filiere_id, 
                    'cheminFichier' => $file->cheminFichier 
                ];
            }
    
            return $files;
        } else {
            return []; 
        }
    }

    public function getAllFilieres() {
        $database = new Database();
        $query = "SELECT id, nom FROM filiere";
        $result = $database->read($query);
    
        $filieres = [];
        if ($result) {
            foreach ($result as $filiere) {
                $filieres[] = ['id' => $filiere->id, 'nom' => $filiere->nom];
            }
        }
        return $filieres;
    }

    public function getCoursByFiliere($filiere_id) {
        $database = new Database();
        $query = "SELECT * FROM cours WHERE filiere_id = :filiere_id";
        $params = [':filiere_id' => $filiere_id];
        $result = $database->read($query, $params);
        return $result;
    }

    
}
?>
