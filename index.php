<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Ordinateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    $host = "localhost";
    $db = "tp_1";
    $user = "root";
    $password = "";

    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

    try {
        $pdo = new PDO($dsn, $user, $password);
        if ($pdo) {
            echo "Connected to the $db database successfully";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    require_once('class/Crud.php');
    require_once('class/Ordinateur.php');

    $crud = new Crud($pdo);
    $ordinateurs = $crud->getOrdinateurs();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'Ajouter') {
                $nouvelOrdinateur = [
                    'brand' => $_POST['brand'],
                    'price' => $_POST['price'],
                    'generation' => $_POST['generation']
                ];
                $resultatAjout = $crud->ajouterOrdinateur($nouvelOrdinateur);
                if ($resultatAjout) {
                    echo "Ordinateur ajouté avec l'ID : $resultatAjout";
                } else {
                    echo "Erreur lors de l'ajout de l'ordinateur.";
                }
            } elseif ($_POST['action'] === 'Modifier') {
                $idOrdinateur = $_POST['id'];
                $ordinateurModifie = [
                    'brand' => $_POST['brand'],
                    'price' => $_POST['price'],
                    'generation' => $_POST['generation']
                ];
                $crud->updateOrdinateurById($idOrdinateur, $ordinateurModifie);
                echo "Ordinateur mis à jour avec succès.";
            } elseif ($_POST['action'] === 'Supprimer') {
                $idOrdinateur = $_POST['id'];
                $resultatSuppression = $crud->deleteOrdinateurById($idOrdinateur);
                echo $resultatSuppression;
            }
        }
    }
    ?>

    <h2>Liste des Ordinateurs</h2>
    <ul>
        <?php foreach ($ordinateurs as $ordinateur) : ?>
            <li><?= $ordinateur['brand'] ?> - <?= $ordinateur['generation'] ?> - <?= $ordinateur['price'] ?> $</li>
        <?php endforeach; ?>
    </ul>

    <h2>Ajouter un Ordinateur</h2>
    <form method="post" action="index.php">
        <label>Marque:</label>
        <input type="text" name="brand">
        <label>Génération:</label>
        <input type="text" name="generation">
        <label>Prix:</label>
        <input type="text" name="price">
        <input type="submit" name="action" value="Ajouter">
    </form>

    <h2>Modifier un Ordinateur</h2>
    <form method="post" action="index.php">
        <label>ID de l'ordinateur à modifier:</label>
        <input type="text" name="id">
        <label>Nouvelle Marque:</label>
        <input type="text" name="brand">
        <label>Nouvelle Génération:</label>
        <input type="text" name="generation">
        <label>Nouveau Prix:</label>
        <input type="text" name="price">
        <input type="submit" name="action" value="Modifier">
    </form>

    <h2>Supprimer un Ordinateur</h2>
    <form method="post" action="index.php">
        <label>ID de l'ordinateur à supprimer:</label>
        <input type="text" name="id">
        <input type="submit" name="action" value="Supprimer">
    </form>
</body>
</html>
