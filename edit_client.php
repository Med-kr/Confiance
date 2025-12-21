<?php
// edit_client.php - Modifier un client
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$client = null;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $conseiller_id = $_POST['conseiller_id'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email)) {
        $error = 'Veuillez remplir tous les champs obligatoires';
    } else {
        try {
            $stmt = Database::getInstance()->query("
                UPDATE Clients 
                SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, 
                    adresse = :adresse, conseiller_id = :conseiller_id
                WHERE id = :id
            ", [
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':telephone' => $telephone,
                ':adresse' => $adresse,
                ':conseiller_id' => $conseiller_id,
                ':id' => $id
            ]);

            $success = 'Client mis à jour avec succès';
        } catch (PDOException $e) {
            $error = 'Erreur lors de la mise à jour du client : ' . $e->getMessage();
        }
    }
} else {
    // Récupérer les informations du client
    $id = $_GET['id'] ?? '';
    if (!empty($id)) {
        $stmt = Database::getInstance()->query("SELECT * FROM Clients WHERE id = :id", [':id' => $id]);
        $client = $stmt->fetch();

        if (!$client) {
            $error = 'Client non trouvé';
        }
    } else {
        $error = 'ID de client manquant';
    }
}

// Récupérer la liste des conseillers
$conseillers = Database::getInstance()->query("SELECT * FROM Advisors")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un client — Confiance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <img src="../Image/logo.png" alt="Logo" class="h-8">
                        <span class="ml-2 text-xl font-semibold text-gray-900">Confiance</span>
                    </div>
                    <nav class="flex space-x-8">
                        <a href="list_clients.php" class="text-gray-700 hover:text-blue-600">Retour à la liste</a>
                        <a href="../auth/logout.php" class="text-gray-700 hover:text-blue-600">Déconnexion</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier le client</h1>

                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <?php if ($client): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $client['id']; ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                <input type="text" name="nom" value="<?php echo htmlspecialchars($client['nom']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                                <input type="text" name="prenom" value="<?php echo htmlspecialchars($client['prenom']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="tel" name="telephone" value="<?php echo htmlspecialchars($client['telephone']); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <textarea name="adresse" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"><?php echo htmlspecialchars($client['adresse']); ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Conseiller *</label>
                                <select name="conseiller_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Sélectionner un conseiller</option>
                                    <?php foreach ($conseillers as $conseiller): ?>
                                        <option value="<?php echo $conseiller['id']; ?>" <?php echo $client['conseiller_id'] == $conseiller['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($conseiller['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                            </button>
                            <a href="list_clients.php" class="ml-4 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                                Annuler
                            </a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>