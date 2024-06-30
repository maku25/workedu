<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['page_title'] . " - " . WEBSITE_TITLE ?></title>
    <link rel="stylesheet" href="<?= ASSETS ?>css/elements.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <?php $this->view("header", $data); ?>
        <script src="<?= ASSETS ?>/js/header.js"></script>
    </header>
    <main>
        <section class="section background-white">
            <p><?php check_message() ?></p>
            
            <div class="upload-form">
                <h4 class="text-size-20 margin-bottom-20 text-dark text-center">Charger un cours</h4>
                <form method="post" enctype="multipart/form-data" name="contactForm">
                    <input name="name" class="subject" placeholder="Nom du cours" type="text" required value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                    <input name="code" class="subject" placeholder="Code du cours" type="text" required value="<?= isset($_POST['code']) ? htmlspecialchars($_POST['code']) : '' ?>">
                    <input name="filiere_id" class="subject" placeholder="ID de la filière" type="text" required value="<?= isset($_POST['filiere_id']) ? htmlspecialchars($_POST['filiere_id']) : '' ?>">
                    <input name="file" class="subject" type="file" required>
                    <p class="subject-error form-error">Veuillez sélectionner le fichier.</p>
                    <div class="s-12"><button class="s-12 submit-form button background-primary text-white" type="submit">Envoyer</button></div>
                </form>
            </div>

            <?php if (!empty($data['files'])) : ?>
                <?php
                    // Regrouper les fichiers par filière
                    $groupedFiles = [];
                    foreach ($data['files'] as $file) {
                        $filiereId = $file['filiere_id'];
                        $nomCours = $file['nom'];
                        $codeCours = $file['code'];
                        $cheminFichier = $file['cheminFichier'];
                        $filiereNom = ''; // Initialisation du nom de la filière
                        
                        // Récupérer le nom de la filière correspondant à filiere_id
                        foreach ($data['filieres'] as $filiere) {
                            if ($filiere['id'] == $filiereId) {
                                $filiereNom = $filiere['nom'];
                                break;
                            }
                        }
                        
                        // Ajouter le cours au groupe correspondant
                        if (!isset($groupedFiles[$filiereId])) {
                            $groupedFiles[$filiereId] = [
                                'filiere_nom' => $filiereNom,
                                'cours' => []
                            ];
                        }
                        $groupedFiles[$filiereId]['cours'][] = [
                            'nom' => $nomCours,
                            'code' => $codeCours,
                            'cheminFichier' => $cheminFichier
                        ];
                    }
                ?>

                <?php foreach ($groupedFiles as $filiereId => $group) : ?>
                    <div class="filiere-group">
                        <h3><?= strtoupper($group['filiere_nom']) ?></h3>
                        <?php foreach ($group['cours'] as $cours) : ?>
                            <div class="cours-item">
                                <p><strong>Nom du cours:</strong> <?= htmlspecialchars($cours['nom']) ?></p>
                                <p><strong>Code du cours:</strong> <?= htmlspecialchars($cours['code']) ?></p>
                                <p><strong>Chemin du fichier:</strong> <a href="<?= htmlspecialchars($cours['cheminFichier']) ?>" target="_blank"><?= htmlspecialchars($cours['cheminFichier']) ?></a></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

            <?php else : ?>
                <p>Aucun fichier trouvé.</p>
            <?php endif; ?>
        </section> 
    </main>
    <footer>
        <?php $this->view("footer", $data); ?>
    </footer>
</body>
</html>
