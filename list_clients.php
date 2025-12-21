<?php
// list_clients.php - Liste des clients
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
    $whereClause = "WHERE c.nom LIKE :search OR c.prenom LIKE :search OR c.email LIKE :search";
    $params[':search'] = "%$search%";
}

try {
    // Récupérer les clients
    $stmt = Database::getInstance()->query("
        SELECT c.*, a.name as advisor_name 
        FROM Clients c 
        LEFT JOIN Advisors a ON c.conseiller_id = a.id
        $whereClause
        ORDER BY c.nom, c.prenom
        LIMIT :limit OFFSET :offset
    ", array_merge($params, [
        ':limit' => $perPage,
        ':offset' => $offset
    ]));
    $clients = $stmt->fetchAll();

    // Compter le total
    $countStmt = Database::getInstance()->query("
        SELECT COUNT(*) as total 
        FROM Clients c 
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
    <title>Liste des clients — Confiance</title>
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
                    <a href="add_client.php" class="text-gray-700 hover:text-blue-600">Ajouter client</a>
                    <a href="../auth/logout.php" class="text-gray-700 hover:text-blue-600">Déconnexion</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Liste des clients</h1>
                <p class="text-gray-600 mt-1">Gestion des clients de l'entreprise</p>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Rechercher un client..."
                            value="<?php echo htmlspecialchars($search); ?>"
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            onkeyup="this.form.submit()">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <div class="text-sm text-gray-600">
                        Affichage de <?php echo min($perPage, $total); ?> sur <?php echo $total; ?> clients
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conseiller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($clients as $client): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#<?php echo $client['id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($client['nom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($client['prenom']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($client['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($client['telephone']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($client['advisor_name'] ?? 'Non assigné'); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="edit_client.php?id=<?php echo $client['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-4">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a href="delete_client.php?id=<?php echo $client['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Voulez-vous vraiment supprimer ce client ?');">
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