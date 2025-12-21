<?php
// Démarrage de la session et configuration
session_start();
require_once 'config/db.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$error = '';
$stats = [];

try {
    // Récupérer l'instance de la base de données
    $db = Database::getInstance();

    // Vérification de la connexion
    $pdo = $db->getConnection();
    if (!$pdo) {
        throw new Exception("La connexion à la base de données n'est pas disponible");
    }

    // Vérifier si les tables existent
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $requiredTables = ['Customers', 'Advisors', 'Accounts', 'Transactions'];

    foreach ($requiredTables as $table) {
        if (!in_array($table, $tables)) {
            throw new Exception("La table $table n'existe pas dans la base de données");
        }
    }

    // Récupérer les statistiques avec des requêtes plus robustes
    $stats = [
        'totalCustomers' => $db->query("SELECT COUNT(*) as total FROM Customers")->fetch()['total'],
        'totalAdvisors' => $db->query("SELECT COUNT(*) as total FROM Advisors")->fetch()['total'],
        'totalAccounts' => $db->query("SELECT COUNT(*) as total FROM Accounts")->fetch()['total'],
        'totalBalance' => $db->query("SELECT IFNULL(SUM(balance), 0) as total FROM Accounts")->fetch()['total'],
        'recentTransactions' => $db->query("
            SELECT 
                t.transaction_id, 
                t.amount, 
                t.transaction_type as type,
                t.transaction_date as created_at,
                c.full_name,  // CORRIGÉ: c.full_name au lieu de c.nom et c.prenom
                a.account_number 
            FROM Transactions t 
            JOIN Accounts a ON t.account_id = a.id 
            JOIN Customers c ON a.customer_id = c.customer_id  // CORRIGÉ: join sur customer_id
            ORDER BY t.transaction_date DESC 
            LIMIT 5
        ")->fetchAll()
    ];
} catch (Exception $e) {
    // Gestion des erreurs avec message utilisateur et enregistrement détaillé
    $error = 'Erreur : ' . htmlspecialchars($e->getMessage());
    error_log("Erreur dashboard : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="src/output.css" />
    <title>Confiance — Dashboard</title>

    <link rel="icon" href="Image/logo_confiance.jpeg" type="image/jpeg" />

    <link rel="stylesheet" href="styles.css" />

    <style>
        /* Style minimal */
        :root {
            --accent: #0d6efd;
            --bg: #0d162c;
            --card: #ffffff;
            --muted: #6b7280;
            --primary: #0d162c;
            --secondary: #1a2744;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, Arial, sans-serif;
            margin: 0;
            background: var(--bg);
            color: #111;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 20px;
            background: var(--card);
            box-shadow: 0 1px 4px rgba(10, 10, 10, 0.04);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .logo img {
            height: 42px;
            width: auto;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(13, 22, 44, 0.05);
            transition: all 0.2s;
        }

        .user-profile:hover {
            background: rgba(13, 22, 44, 0.1);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
        }

        .user-role {
            font-size: 12px;
            color: var(--muted);
        }

        .menu-button {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
        }

        nav.primary {
            margin-left: auto;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        nav.primary a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            text-decoration: none;
            color: inherit;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        nav.primary a:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }

        nav.primary a img {
            height: 26px;
            width: 26px;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 16px;
        }

        .grid {
            display: grid;
            gap: 16px;
        }

        .grid.cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .card {
            background: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(10, 10, 10, 0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .toolbar {
            display: flex;
            gap: 16px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-success {
            background: #22c55e;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .stat-card {
            text-align: center;
            padding: 24px 16px;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 8px 0;
            background: linear-gradient(135deg, var(--accent), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--muted);
            font-weight: 500;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            background: rgba(13, 22, 44, 0.03);
            transition: background-color 0.2s;
        }

        .activity-item:hover {
            background: rgba(13, 22, 44, 0.06);
        }

        .activity-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin: 0;
            font-size: 14px;
        }

        .activity-subtitle {
            font-size: 12px;
            color: var(--muted);
            margin: 2px 0 0;
        }

        .activity-arrow {
            color: var(--muted);
            transition: transform 0.2s;
        }

        .activity-item:hover .activity-arrow {
            transform: translateX(4px);
        }

        .chart-container {
            height: 200px;
            background: rgba(13, 22, 44, 0.03);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
        }

        @media (max-width: 900px) {
            .grid.cols-3 {
                grid-template-columns: 1fr;
            }

            nav.primary {
                display: none;
            }

            .menu-button {
                display: inline-block;
                margin-left: auto;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .user-profile {
                order: -1;
            }
        }
    </style>
</head>

<body>
    <header class="flex items-center h-20 px-8 bg-white shadow">
        <div class="flex items-center gap-8">
            <img
                src="Image/logo.png"
                class="h-22 w-auto object-contain"
                alt="Logo Confiance" />

            <!-- Bouton menu mobile -->
            <button class="menu-button" aria-label="Ouvrir le menu">
                <img src="Image/menu.png" class="h-22 w-auto object-contain" alt="Menu" style="height: 28px" />
            </button>
        </div>

        <nav class="primary" aria-label="Navigation principale">
            <a href="list_accounts.php" title="Comptes">
                <img src="Image/Acounts.png" alt="Comptes" />
            </a>
            <a href="list_Customers.php" title="Customers">
                <img src="Image/customer-review.png" alt="Customers" />
            </a>
            <a href="list_transactions.php" title="Transactions">
                <img src="Image/transitions.png" alt="Transactions" />
            </a>
            <a href="dashboard.php" title="Tableau de bord">
                <img src="Image/dashboard.png" alt="Tableau de bord" />
            </a>
        </nav>

        <div class="user-profile">
            <div class="user-avatar">
                <?php echo substr($_SESSION['user_name'] ?? 'U', 0, 1); ?>
            </div>
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur'); ?></span>
                <span class="user-role"><?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Admin'); ?></span>
            </div>
            <i class="fas fa-chevron-down activity-arrow"></i>
        </div>
    </header>

    <main>
        <!-- Barre d'outils -->
        <section class="card toolbar">
            <div>
                <h1 style="margin: 0; font-size: 1.5rem;">Tableau de bord — Confiance</h1>
                <p style="margin: 4px 0 0; color: var(--muted); font-size: 14px">
                    Gérer les Customers, comptes et transactions
                </p>
            </div>

            <form class="search" action="list_Customers.php" method="get">
                <input
                    type="search"
                    name="q"
                    placeholder="Rechercher..."
                    style="
                        width: 300px;
                        padding: 10px 16px;
                        border: 1px solid #e6e9ef;
                        border-radius: 8px;
                        font-size: 14px;
                    " />
            </form>

            <div style="display: flex; gap: 12px;">
                <a
                    href="add_client.php"
                    class="btn btn-primary"
                    style="
                        color: #fff;
                        text-decoration: none;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 10px 20px;
                    ">
                    <i class="fas fa-user-plus"></i> + Client
                </a>

                <a
                    href="add_account.php"
                    class="btn btn-success"
                    style="
                        color: #fff;
                        text-decoration: none;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 10px 20px;
                    ">
                    <i class="fas fa-plus-circle"></i> + Compte
                </a>
            </div>
        </section>

        <!-- Statistiques -->
        <section class="grid cols-3" style="margin-top: 16px">
            <div class="card stat-card">
                <div class="stat-value"><?php echo number_format($stats['totalCustomers'] ?? 0); ?></div>
                <div class="stat-label">Customers enregistrés</div>
            </div>

            <div class="card stat-card">
                <div class="stat-value"><?php echo number_format($stats['totalAccounts'] ?? 0); ?></div>
                <div class="stat-label">Comptes actifs</div>
            </div>

            <div class="card stat-card">
                <div class="stat-value"><?php echo number_format($stats['totalBalance'] ?? 0, 2); ?></div>
                <div class="stat-label">Total des soldes (MAD)</div>
            </div>
        </section>

        <!-- Activité récente -->
        <section class="card" style="margin-top: 16px">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h2 style="margin: 0; font-size: 1.25rem;">Activité récente</h2>
                <a href="list_transactions.php" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                    Voir tout <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div>
                <?php
                // Récupérer les activités récentes
                $activities = $db->query("
                    SELECT 
                        t.transaction_id, 
                        t.amount, 
                        t.transaction_type as type,
                        t.transaction_date as created_at,
                        c.full_name,  // CORRIGÉ: full_name au lieu de nom et prenom
                        a.account_number
                    FROM Transactions t 
                    JOIN Accounts a ON t.account_id = a.id 
                    JOIN Customers c ON a.customer_id = c.customer_id  // CORRIGÉ: join sur customer_id
                    ORDER BY t.transaction_date DESC 
                    LIMIT 5
                ")->fetchAll();

                if (!empty($activities)):
                ?>
                    <?php foreach ($activities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <?php echo substr($activity['full_name'], 0, 1); ?> // CORRIGÉ: utilise full_name
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">
                                    <?php echo htmlspecialchars($activity['full_name']); ?> // CORRIGÉ: utilise full_name
                                </div>
                                <div class="activity-subtitle">
                                    Compte: <?php echo htmlspecialchars($activity['account_number']); ?> |
                                    <?php echo $activity['type'] === 'credit' ? 'Crédit' : 'Débit'; ?> de
                                    <?php echo number_format($activity['amount'], 2); ?> MAD
                                </div>
                            </div>
                            <i class="fas fa-chevron-right activity-arrow"></i>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; color: var(--muted);">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                        <p>Aucune activité récente</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Graphique des transactions -->
        <section class="card" style="margin-top: 16px">
            <h2 style="margin: 0 0 16px; font-size: 1.25rem;">Tendances des transactions</h2>
            <div class="chart-container">
                <div style="text-align: center;">
                    <i class="fas fa-chart-line" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p style="font-size: 14px;">Graphique des transactions (en cours de développement)</p>
                </div>
            </div>
        </section>

        <!-- Derniers Customers -->
        <section class="card" style="margin-top: 16px">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h2 style="margin: 0; font-size: 1.25rem;">Derniers Customers</h2>
                <a href="list_Customers.php" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                    Voir tout <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Récupérer les derniers Customers
                    $customers = $db->query("SELECT * FROM Customers ORDER BY registration_date DESC LIMIT 5")->fetchAll();
                    foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['customer_id']; ?></td>
                            <td><?php echo htmlspecialchars($customer['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($customer['registration_date'])); ?></td>
                            <td>
                                <a href="view_client.php?id=<?php echo $customer['customer_id']; ?>" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Voir</a>
                                <a href="edit_client.php?id=<?php echo $customer['customer_id']; ?>" class="btn btn-warning" style="padding: 4px 8px; font-size: 12px;">Modifier</a>
                                <a href="delete_client.php?id=<?php echo $customer['customer_id']; ?>" onclick="return confirm('Confirmer la suppression ?')" class="btn btn-danger" style="padding: 4px 8px; font-size: 12px;">Suppr.</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer
        style="
            text-align: center;
            padding: 32px 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            margin-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        ">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <h3 style="margin: 0 0 8px; font-size: 1.2rem; font-weight: 600;">Confiance Banking System</h3>
            <p style="margin: 0 0 16px; font-size: 0.9rem; opacity: 0.8;">
                Gestion complète de vos Customers, comptes et transactions
            </p>

            <div style="display: flex; justify-content: center; gap: 24px; margin: 24px 0; flex-wrap: wrap;">
                <div>
                    <h4 style="margin: 0 0 8px; font-size: 0.9rem; font-weight: 500;">Contact</h4>
                    <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;">support@confiance.com</p>
                    <p style="margin: 4px 0 0; font-size: 0.8rem; opacity: 0.7;">+212 5 22 34 56 78</p>
                </div>

                <div>
                    <h4 style="margin: 0 0 8px; font-size: 0.9rem; font-weight: 500;">Heures</h4>
                    <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;">Lun-Ven: 9h-18h</p>
                    <p style="margin: 4px 0 0; font-size: 0.8rem; opacity: 0.7;">Sam: 9h-14h</p>
                </div>

                <div>
                    <h4 style="margin: 0 0 8px; font-size: 0.9rem; font-weight: 500;">Suivez-nous</h4>
                    <div style="display: flex; gap: 12px; margin-top: 8px;">
                        <a href="#" style="color: white; opacity: 0.7; font-size: 1.2rem;"><i class="fab fa-facebook"></i></a>
                        <a href="#" style="color: white; opacity: 0.7; font-size: 1.2rem;"><i class="fab fa-twitter"></i></a>
                        <a href="#" style="color: white; opacity: 0.7; font-size: 1.2rem;"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 16px; margin-top: 16px;">
                <p style="margin: 0; font-size: 0.8rem; opacity: 0.6;">
                    © <?php echo date('Y'); ?> Confiance — Tous droits réservés | Réalisé par Med_kr
                </p>
            </div>
        </div>
    </footer>

    <script src="main.js"></script>
</body>

</html>