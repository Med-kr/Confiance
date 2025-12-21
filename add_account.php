<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session et configuration
session_start();
require_once 'config/db.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$error = '';
$success = '';
$clients = [];
$advisors = [];

try {
    // Récupérer la liste des clients et conseillers
    $db = Database::getInstance();
    $clients = $db->query("SELECT id, prenom, nom FROM Clients ORDER BY nom")->fetchAll();
    $advisors = $db->query("SELECT id, nom FROM Advisors ORDER BY nom")->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $customer_id = $_POST['customer_id'] ?? '';
        $account_type = $_POST['account_type'] ?? '';
        $initial_balance = $_POST['initial_balance'] ?? '0';
        $advisor_id = $_POST['advisor_id'] ?? '';

        // Valider les données
        if (empty($customer_id) || empty($account_type)) {
            throw new Exception("Tous les champs obligatoires doivent être remplis");
        }

        // Insérer le compte dans la base de données
        $stmt = $db->query("
            INSERT INTO Accounts (customer_id, account_type, balance, advisor_id, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ", [
            $customer_id,
            $account_type,
            $initial_balance,
            $advisor_id
        ]);

        $success = "Compte ajouté avec succès !";

        // Rediriger vers la liste des comptes
        header('Location: list_accounts.php');
        exit();
    }
} catch (Exception $e) {
    $error = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un compte - Confiance</title>
    <link rel="stylesheet" href="src/output.css">
    <style>
        body {
            background-color: #0d162c;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            color: black;
        }

        button {
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0b5ed7;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ajouter un nouveau compte</h1>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="customer_id">Client</label>
                <select id="customer_id" name="customer_id" required>
                    <option value="">Sélectionner un client</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['id']; ?>">
                            <?php echo htmlspecialchars($client['prenom'] . ' ' . $client['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="account_type">Type de compte</label>
                <select id="account_type" name="account_type" required>
                    <option value="">Sélectionner un type</option>
                    <option value="checking">Compte Courant</option>
                    <option value="savings">Compte Épargne</option>
                    <option value="business">Compte Professionnel</option>
                </select>
            </div>

            <div class="form-group">
                <label for="initial_balance">Solde initial</label>
                <input type="number" id="initial_balance" name="initial_balance" step="0.01" value="0">
            </div>

            <div class="form-group">
                <label for="advisor_id">Conseiller</label>
                <select id="advisor_id" name="advisor_id">
                    <option value="">Sélectionner un conseiller</option>
                    <?php foreach ($advisors as $advisor): ?>
                        <option value="<?php echo $advisor['id']; ?>">
                            <?php echo htmlspecialchars($advisor['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Ajouter le compte</button>
        </form>
    </div>
</body>

</html>