<?php
// make_transaction.php - Effectuer une transaction
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_POST['account_id'] ?? '';
    $type = $_POST['type'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? '';

    if (empty($account_id) || empty($type) || empty($amount)) {
        $error = 'Veuillez remplir tous les champs obligatoires';
    } elseif (!is_numeric($amount) || $amount <= 0) {
        $error = 'Le montant doit être un nombre positif';
    } else {
        try {
            Database::getInstance()->beginTransaction();

            // Vérifier le solde pour les retraits
            if ($type === 'withdrawal') {
                $stmt = Database::getInstance()->query("SELECT balance FROM Accounts WHERE id = :account_id", [':account_id' => $account_id]);
                $account = $stmt->fetch();

                if ($account['balance'] < $amount) {
                    throw new Exception('Solde insuffisant pour effectuer ce retrait');
                }
            }

            // Créer la transaction
            $stmt = Database::getInstance()->query("
                INSERT INTO Transactions (account_id, type, amount, description, created_at)
                VALUES (:account_id, :type, :amount, :description, NOW())
            ", [
                ':account_id' => $account_id,
                ':type' => $type,
                ':amount' => $amount,
                ':description' => $description
            ]);

            // Mettre à jour le solde du compte
            $sign = $type === 'deposit' ? '+' : '-';
            $stmt = Database::getInstance()->query("
                UPDATE Accounts 
                SET balance = balance $sign :amount 
                WHERE id = :account_id
            ", [
                ':amount' => $amount,
                ':account_id' => $account_id
            ]);

            Database::getInstance()->commit();
            $success = 'Transaction effectuée avec succès';
        } catch (Exception $e) {
            Database::getInstance()->rollBack();
            $error = 'Erreur lors de la transaction : ' . $e->getMessage();
        }
    }
}

// Récupérer la liste des comptes
$accounts = Database::getInstance()->query("SELECT * FROM Accounts")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Effectuer une transaction — Confiance</title>
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
                        <a href="list_transactions.php" class="text-gray-700 hover:text-blue-600">Retour</a>
                        <a href="../auth/logout.php" class="text-gray-700 hover:text-blue-600">Déconnexion</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Effectuer une transaction</h1>

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

                <form method="POST" action="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Compte *</label>
                            <select name="account_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Sélectionner un compte</option>
                                <?php foreach ($accounts as $account): ?>
                                    <option value="<?php echo $account['id']; ?>">
                                        <?php echo $account['account_number']; ?> - <?php echo number_format($account['balance'], 2); ?> €
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de transaction *</label>
                            <select name="type" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="deposit">Dépôt</option>
                                <option value="withdrawal">Retrait</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Montant *</label>
                            <input type="number" name="amount" step="0.01" min="0.01" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                            <i class="fas fa-exchange-alt mr-2"></i>Effectuer la transaction
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>