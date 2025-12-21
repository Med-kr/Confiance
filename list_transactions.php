<?php
// list_transactions.php - Liste des transactions
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Pagination
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Recherche
$search = isset($_GET['q']) ? $_GET['q'] : '';

// Construction de la requête
$whereClause = '';
$params = [];

if (!empty($search)) {
    $whereClause = "WHERE t.description LIKE :search OR c.nom LIKE :search OR c.prenom LIKE :search OR a.account_number LIKE :search";
    $params[':search'] = "%$search%";
}

try {
    // Récupérer les transactions
    $stmt = Database::getInstance()->query("
        SELECT t.*, c.nom, c.prenom, a.account_number, a.account_type 
        FROM Transactions t 
        JOIN Accounts a ON t.account_id = a.id 
        JOIN Clients c ON a.customer_id = c.id
        $whereClause
        ORDER BY t.created_at DESC
        LIMIT :limit OFFSET :offset
    ", array_merge($params, [
        ':limit' => $perPage,
        ':offset' => $offset
    ]));
    $transactions = $stmt->fetchAll();

    // Compter le total
    $countStmt = Database::getInstance()->query("
        SELECT COUNT(*) as total 
        FROM Transactions t 
        JOIN Accounts a ON t.account_id = a.id 
        JOIN Clients c ON a.customer_id = c.id
        $whereClause
    ", $params);
    $total = $countStmt->fetch()['total'];
    $totalPages = ceil($total / $perPage);
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des transactions — Confiance</title>
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
                    <a href="make_transaction.php" class="text-gray-700 hover:text-blue-600">Nouvelle transaction</a>
                    <a href="../auth/logout.php" class="text-gray-700 hover:text-blue-600">Déconnexion</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Liste des transactions</h1>
                <p class="text-gray-600 mt-1">Historique des transactions bancaires</p>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Rechercher une transaction..."
                            value="<?php echo htmlspecialchars($search); ?>"
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            onkeyup="this.form.submit()">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <div class="text-sm text-gray-600">
                        Affichage de <?php echo min($perPage, $total); ?> sur <?php echo $total; ?> transactions
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compte</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($transactions as $transaction): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#<?php echo $transaction['transaction_id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $transaction['account_number']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($transaction['prenom'] . ' ' . $transaction['nom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?php echo $transaction['type'] === 'deposit' ? 'green' : 'red'; ?>-100 text-<?php echo $transaction['type'] === 'deposit' ? 'green' : 'red'; ?>-800">
                                            <?php echo ucfirst($transaction['type']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium <?php echo $transaction['type'] === 'deposit' ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $transaction['type'] === 'deposit' ? '+' : '-'; ?><?php echo number_format($transaction['amount'], 2); ?> €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($transaction['description']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('d/m/Y H:i', strtotime($transaction['created_at'])); ?></td>
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