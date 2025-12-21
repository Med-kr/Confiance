<?php
// edit_account.php - Modifier un compte
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$account = null;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $account_type = $_POST['account_type'] ?? '';
    $advisor_id = $_POST['advisor_id'] ?? '';

    if (empty($account_type)) {
        $error = 'Veuillez remplir tous les champs obligatoires';
    } else {
        try {
            $stmt = Database::getInstance()->query("
                UPDATE Accounts 
                SET account_type = :account_type, advisor_id = :advisor_id
                WHERE id = :id
            ", [
                ':account_type' => $account_type,
                ':advisor_id' => $advisor_id,
                ':id' => $id
            ]);

            $success = 'Compte mis à jour avec succès';
        } catch (PDOException $e) {
            $error = 'Erreur lors de la mise à jour du compte : ' . $e->getMessage();
        }
    }
} else {
    // Récupérer les informations du compte
    $id = $_GET['id'] ?? '';
    if (!empty($id)) {
        $stmt = Database::getInstance()->query("SELECT * FROM Accounts WHERE id = :id", [':id' => $id]);
        $account = $stmt->fetch();

        if (!$account) {
            $error = 'Compte non trouvé';
        }
    } else {
        $error = 'ID de compte manquant';
    }
}

// Récupérer la liste des conseillers
$advisors = Database::getInstance()->query("SELECT * FROM Advisors")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un compte — Confiance</title>
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
                        <a href="list_accounts.php" class="text-gray-700 hover:text-blue-600">Retour à la liste</a>
                        <a href="../auth/logout.php" class="text-gray-700 hover:text-blue-600">Déconnexion</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier le compte</h1>

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

                <?php if ($account): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $account['id']; ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de compte</label>
                                <input type="text" value="<?php echo $account['account_number']; ?>" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type de compte *</label>
                                <select name="account_type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="Checking" <?php echo $account['account_type'] === 'Checking' ? 'selected' : ''; ?>>Compte Courant</option>
                                    <option value="Savings" <?php echo $account['account_type'] === 'Savings' ? 'selected' : ''; ?>>Compte Épargne</option>
                                    <option value="Business" <?php echo $account['account_type'] === 'Business' ? 'selected' : ''; ?>>Compte Entreprise</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Solde</label>
                                <input type="text" value="<?php echo number_format($account['balance'], 2); ?> €" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100" readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Conseiller</label>
                                <select name="advisor_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Aucun</option>
                                    <?php foreach ($advisors as $advisor): ?>
                                        <option value="<?php echo $advisor['id']; ?>" <?php echo $account['advisor_id'] == $advisor['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($advisor['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                            </button>
                            <a href="list_accounts.php" class="ml-4 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
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