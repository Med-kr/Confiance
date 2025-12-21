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
$accounts = [];
$total = 0;
$totalPages = 0;
$search = '';
$page = 1;
$perPage = 10;

try {
    // Pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    // Recherche
    $search = isset($_GET['q']) ? $_GET['q'] : '';

    // Construction de la requête
    $whereClause = '';
    $params = [];

    if (!empty($search)) {
        $whereClause = "WHERE a.account_number LIKE :search OR c.nom LIKE :search OR c.prenom LIKE :search";
        $params[':search'] = "%$search%";
    }

    // Récupérer les comptes
    $db = Database::getInstance();
    $stmt = $db->query("
        SELECT a.*, c.nom, c.prenom, ad.name as advisor_name 
        FROM Accounts a 
        JOIN Customers c ON a.customer_id = c.id 
        LEFT JOIN Advisors ad ON a.advisor_id = ad.id
        $whereClause
        ORDER BY a.account_number
        LIMIT :limit OFFSET :offset
    ", array_merge($params, [
        ':limit' => $perPage,
        ':offset' => $offset
    ]));
    $accounts = $stmt->fetchAll();

    // Compter le total
    $countStmt = $db->query("
        SELECT COUNT(*) as total 
        FROM Accounts a 
        JOIN Customers c ON a.customer_id = c.id
        $whereClause
    ", $params);
    $total = $countStmt->fetch()['total'];
    $totalPages = ceil($total / $perPage);
} catch (PDOException $e) {
    $error = "Erreur de base de données : " . $e->getMessage();
    error_log("Erreur list_accounts : " . $e->getMessage());
} catch (Exception $e) {
    $error = "Erreur : " . $e->getMessage();
    error_log("Erreur list_accounts : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des comptes — Confiance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <img src="../Image/logo.png" alt="Logo" class="h-8">
                    <span class="ml-2 text-xl font-semibold text-gray-900">Confiance</span>
                </div>
                <nav class="flex space-x-8">
                    <a href="add_account.php" class="text-gray-700 hover:text-blue-600">Ajouter compte</a>
                    <a href="../auth/logout.php" class="text-gray-700 hover:text-blue-600">Déconnexion</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Liste des comptes</h1>
                <p class="text-gray-600 mt-1">Gestion des comptes bancaires</p>
            </div>

            <?php if ($error): ?>
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 m-4 rounded">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Rechercher un compte..."
                            value="<?php echo htmlspecialchars($search); ?>"
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <div class="text-sm text-gray-600">
                        Affichage de <?php echo min($perPage, $total); ?> sur <?php echo $total; ?> comptes
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conseiller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($accounts as $account): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $account['account_number']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($account['prenom'] . ' ' . $account['nom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $account['account_type']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo number_format($account['balance'], 2); ?> €</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($account['advisor_name'] ?? 'Non assigné'); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="make_transaction.php?account_id=<?php echo $account['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                            <i class="fas fa-exchange-alt"></i> Transaction
                                        </a>
                                        <a href="edit_account.php?id=<?php echo $account['id']; ?>" class="text-green-600 hover:text-green-900 mr-4">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="delete_account.php?id=<?php echo $account['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Voulez-vous vraiment supprimer ce compte ?');">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($totalPages > 1): ?>
                    <div class="flex justify-center mt-6">
                        <nav class="flex space-x-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?>&q=<?php echo urlencode($search); ?>" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Précédent
                                </a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php if ($i == $page): ?>
                                    <span class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md">
                                        <?php echo $i; ?>
                                    </span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?>&q=<?php echo urlencode($search); ?>" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?php echo $page + 1; ?>&q=<?php echo urlencode($search); ?>" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Suivant
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>