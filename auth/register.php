<?php
// auth/register.php - Inscription
session_start();
require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if (empty($username) || empty($password) || empty($email)) {
        $error = 'Veuillez remplir tous les champs obligatoires';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalide';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères';
    } else {
        try {
            // Vérifier si l'utilisateur existe déjà
            $stmt = Database::getInstance()->query("SELECT * FROM Users WHERE username = :username OR email = :email", [
                ':username' => $username,
                ':email' => $email
            ]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $error = 'Nom d\'utilisateur ou email déjà utilisé';
            } else {
                // Hacher le mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insérer le nouvel utilisateur
                $stmt = Database::getInstance()->query("
                    INSERT INTO Users (username, password, email, role, status, created_at)
                    VALUES (:username, :password, :email, :role, 'active', NOW())
                ", [
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':email' => $email,
                    ':role' => $role
                ]);

                $success = 'Compte créé avec succès. Vous pouvez maintenant vous connecter.';
            }
        } catch (PDOException $e) {
            $error = 'Erreur lors de la création du compte : ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Confiance</title>
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
                        <a href="login.php" class="text-gray-700 hover:text-blue-600">Connexion</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Créer un compte</h1>

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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom d'utilisateur *</label>
                            <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
                            <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rôle</label>
                            <select name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="user">Utilisateur</option>
                                <option value="admin">Administrateur</option>
                                <option value="advisor">Conseiller</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                            <i class="fas fa-user-plus mr-2"></i>S'inscrire
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>