<?php
// Inclure le modèle ModelFile pour accéder aux fonctions de recherche
include_once '.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
    $searchQuery = $_POST['query'];

    // Créer une instance de ModelFile
    $modelFile = new ModelFile();

    // Appeler la méthode de recherche de cours par nom
    $searchResults = $modelFile->searchCoursByName($searchQuery);

    // Afficher les résultats de la recherche
    if ($searchResults) {
        foreach ($searchResults as $result) {
            echo '<p>' . $result->nom . ' - ' . $result->code . '</p>';
        }
    } else {
        echo '<p>Aucun résultat trouvé.</p>';
    }
}
?>
