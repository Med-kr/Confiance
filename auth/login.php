<?php
// auth/login.php - Page de connexion améliorée

session_start();

// Inclusion de la configuration de la base de données
require_once '../config/db.php';

$error = '';
$login_attempts = [];

// Gestion des tentatives de connexion
if (isset($_SESSION['login_attempts'])) {
    $login_attempts = $_SESSION['login_attempts'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation des entrées
    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = 'Le nom d\'utilisateur doit contenir entre 3 et 50 caractères';
    }else {
        try {
            // Vérification des tentatives de connexion excessives
            if (count($login_attempts) >= 5) {
                $error = 'Trop de tentatives de connexion. Veuillez réessayer plus tard.';
            } else {
                // Préparation de la requête pour éviter les injections SQL
                $stmt = Database::getInstance()->query("SELECT * FROM Users WHERE username = :username", [':username' => $username]);
                $user = $stmt->fetch();

                if ($user) {
                    // Vérification du mot de passe
                    if (password_verify($password, $user['password'])) {
                        // Vérification supplémentaire pour la sécurité
                        if ($user['status'] === 'active') {
                            // Stockage des informations de session
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['username'] = $user['username'];
                            $_SESSION['role'] = $user['role'];
                            $_SESSION['logged_in'] = true;
                            $_SESSION['last_activity'] = time();

                            // Réinitialiser les tentatives de connexion
                            $_SESSION['login_attempts'] = [];

                            // Regénération de l'ID de session pour la sécurité
                            session_regenerate_id(true);

                            // Redirection vers le dashboard
                            header('Location: ../dashboard.php');
                            exit();
                        } else {
                            $error = 'Compte désactivé. Contactez l\'administrateur.';
                        }
                    } else {
                        // Enregistrement de la tentative de connexion échouée
                        $login_attempts[] = [
                            'username' => $username,
                            'timestamp' => time()
                        ];
                        $_SESSION['login_attempts'] = $login_attempts;
                        $error = 'Identifiants incorrects';
                    }
                } else {
                    // Enregistrement de la tentative de connexion échouée
                    $login_attempts[] = [
                        'username' => $username,
                        'timestamp' => time()
                    ];
                    $_SESSION['login_attempts'] = $login_attempts;
                    $error = 'Identifiants incorrects';
                }
            }
        } catch (PDOException $e) {
            $error = 'Erreur de connexion à la base de données. Veuillez réessayer plus tard.';
            error_log('Login error: ' . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Confiance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0d162c;
            background-image: linear-gradient(135deg, #0d162c 0%, #1a2744 50%, #2a3f5f 100%);
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .input-field {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            outline: none;
        }

        .login-button {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .divider {
            color: rgba(255, 255, 255, 0.5);
        }

        .error-shake {
            animation: shake 0.5s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-10px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(10px);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">
    <div class="login-container p-8 rounded-xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <img src="../Image/logo.png" alt="Logo Confiance" class="mx-auto h-16">
            <h1 class="text-2xl font-bold text-white mt-4">Confiance</h1>
            <p class="text-gray-300 text-sm mt-2">Plateforme de gestion bancaire</p>
        </div>

        <form method="POST" action="">
            <div class="mb-4">
                <label class="block text-white mb-2 text-sm font-medium">Nom d'utilisateur</label>
                <input type="text" name="username"
                    class="w-full p-3 rounded-lg input-field text-white placeholder-gray-300 focus:outline-none"
                    placeholder="Entrez votre nom d'utilisateur" required
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>

            <div class="mb-6">
                <label class="block text-white mb-2 text-sm font-medium">Mot de passe</label>
                <input type="password" name="password"
                    class="w-full p-3 rounded-lg input-field text-white placeholder-gray-300 focus:outline-none"
                    placeholder="Entrez votre mot de passe" required>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-200 p-3 rounded-lg mb-4 text-sm error-shake">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="w-full login-button text-white py-3 rounded-lg font-semibold">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </button>
        </form>

        <div class="text-center mt-6 text-gray-400 text-sm">
            <a href="forgot_password.php" class="hover:text-white transition-colors">Mot de passe oublié ?</a>
            <span class="mx-2">|</span>
            <a href="register.php" class="hover:text-white transition-colors">Créer un compte</a>
        </div>

        <?php if (count($login_attempts) >= 3): ?>
            <div class="mt-4 text-center text-yellow-300 text-xs">
                <i class="fas fa-info-circle mr-1"></i>
                Attention : Trop de tentatives de connexion échouées peuvent bloquer votre compte
            </div>
        <?php endif; ?>
    </div>

    <!-- Script pour améliorer l'expérience utilisateur -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('input');

            // Effet de focus sur les inputs
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-105');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-105');
                });
            });

            // Gestion de la soumission du formulaire
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Connexion...';
                submitBtn.disabled = true;
            });

            // Animation de secouement pour les erreurs
            const errorDiv = document.querySelector('.error-shake');
            if (errorDiv) {
                setTimeout(() => {
                    errorDiv.classList.remove('error-shake');
                }, 500);
            }
        });
    </script>
</body>

</html>