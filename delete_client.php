<?php
// delete_client.php - Supprimer un client
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    try {
        // Vérifier si le client a des comptes associés
        $stmt = Database::getInstance()->query("SELECT COUNT(*) as count FROM Accounts WHERE client_id = :id", [':id' => $id]);
        $count = $stmt->fetch()['count'];

        if ($count > 0) {
            $error = 'Impossible de supprimer ce client car il a des comptes associés';
        } else {
            $stmt = Database::getInstance()->query("DELETE FROM Clients WHERE id = :id", [':id' => $id]);
            $success = 'Client supprimé avec succès';
        }
    } catch (PDOException $e) {
        $error = 'Erreur lors de la suppression du client : ' . $e->getMessage();
    }
} else {
    $id = $_GET['id'] ?? '';
    if (empty($id)) {
        $error = 'ID de client manquant';
    }
}

// Redirection après traitement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($success) {
        header('Location: list_clients.php?message=' . urlencode($success));
    } else {
        header('Location: list_clients.php?error=' . urlencode($error));
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un client — Confiance</title>
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
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Supprimer un client</h1>

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

                <?php if (!empty($id)): ?>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-yellow-800">Confirmation de suppression</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible.</p>
                                </div>
                                <div class="mt-4">
                                    <form method="POST" action="">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <div class="flex space-x-3">
                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                                <i class="fas fa-trash mr-2"></i>Confirmer la suppression
                                            </button>
                                            <a href="list_clients.php" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors font-semibold">
                                                Annuler
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>