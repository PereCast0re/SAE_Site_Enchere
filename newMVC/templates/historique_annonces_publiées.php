<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


</head>

<body>
    <?php include_once('../Modele/pdo.php');
      $id_client = $_SESSION['id_client'];
      $annonces = get_termined_annonces_by_client($id_client); ?>
    <div class="Historique_annonces">
        <h2>Historique des annonces publiées</h2>
        <div class="Annonces-list-cards">
            <? foreach ($annonces as $a): ?>
                <div class="card">
                    <!--- image --->
                    <h3><?= htmlspecialchars($a['titre']) ?></h3>
                    <p>Prix actuel : <?= htmlspecialchars($a['prix_en_cours']) ?> €</p>
                </div>
            <? endforeach; ?>
        </div>
    </div>

    
</body>
</html>