<?php
// db.php
$host = "localhost";
$dbname = "Confiance";
$user = "root";
$pass = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur DB : " . $e->getMessage());
}

// Statistiques
$totalClients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
$totalAccounts = $pdo->query("SELECT COUNT(*) FROM accounts")->fetchColumn();
$transactionsToday = $pdo->query("SELECT COUNT(*) FROM transactions WHERE DATE(created_at) = CURDATE()")->fetchColumn();

// Derniers clients
$clients = $pdo->query("SELECT * FROM clients ORDER BY registration_date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Derniers comptes
$accounts = $pdo->query("
    SELECT a.*, c.full_name as client_name
    FROM accounts a
    JOIN clients c ON a.client_id = c.id
    ORDER BY a.created_at DESC LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Dernières transactions
$transactions = $pdo->query("
    SELECT t.*, a.numero as account_num
    FROM transactions t
    JOIN accounts a ON t.account_id = a.id
    ORDER BY t.created_at DESC LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confiance — Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <header>
        <img src="Image/logo.png" alt="Logo Confiance" />
        <nav>
            <a href="list_accounts.php">Comptes</a>
            <a href="list_clients.php">Clients</a>
            <a href="list_transactions.php">Transactions</a>
            <a href="dashboard.php">Dashboard</a>
        </nav>
    </header>

    <main>
        <section>
            <h1>Tableau de bord — Confiance</h1>
            <p>Gérer les clients, comptes et transactions</p>
        </section>

        <section class="stats">
            <div>
                <h3>Clients</h3>
                <p><?= $totalClients ?></p>
            </div>
            <div>
                <h3>Comptes</h3>
                <p><?= $totalAccounts ?></p>
            </div>
            <div>
                <h3>Transactions aujourd'hui</h3>
                <p><?= $transactionsToday ?></p>
            </div>
        </section>

        <section>
            <h2>Derniers clients</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= $client['id'] ?></td>
                            <td><?= htmlspecialchars($client['full_name']) ?></td>
                            <td><?= htmlspecialchars($client['email']) ?></td>
                            <td><?= $client['phone'] ?></td>
                            <td><?= $client['registration_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Derniers comptes</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Numéro</th>
                        <th>Type</th>
                        <th>Solde</th>
                        <th>Client</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $acc): ?>
                        <tr>
                            <td><?= $acc['id'] ?></td>
                            <td><?= $acc['numero'] ?></td>
                            <td><?= $acc['type'] ?></td>
                            <td><?= $acc['solde'] ?></td>
                            <td><?= htmlspecialchars($acc['client_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Dernières transactions</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Compte</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><?= $t['account_num'] ?></td>
                            <td><?= $t['type'] ?></td>
                            <td><?= $t['amount'] ?></td>
                            <td><?= $t['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date("Y") ?> Confiance — Tous droits réservés.</p>
    </footer>
</body>

</html>