<?php
// index.php - Page d'accueil
session_start();

// Rediriger vers le dashboard si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confiance - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #0d162c;
        }

        .hero-section {
            background: linear-gradient(135deg, #0d162c 0%, #1a2744 50%, #2a3f5f 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body>
    <div class="min-h-screen hero-section text-white">
        <!-- Header -->
        <header class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <img src="Image/logo.png" alt="Logo Confiance" class="h-12">
                    <h1 class="ml-3 text-2xl font-bold">Confiance</h1>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="auth/login.php" class="hover:text-blue-300 transition-colors">Connexion</a>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="container mx-auto px-6 py-20 text-center">
            <h2 class="text-5xl font-bold mb-6">Bienvenue sur Confiance</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Gérez vos clients, comptes et transactions en toute simplicité avec notre plateforme sécurisée.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="auth/login.php" class="bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Se connecter
                </a>
                <a href="auth/register.php" class="border border-white hover:bg-white hover:text-blue-600 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Créer un compte
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="container mx-auto px-6 py-16">
            <h3 class="text-3xl font-bold text-center mb-12">Pourquoi choisir Confiance ?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 text-center">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-shield-alt text-blue-400"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Sécurité</h4>
                    <p class="text-gray-300">Protection de vos données avec des standards de sécurité élevés</p>
                </div>

                <div class="feature-card bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 text-center">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-chart-line text-green-400"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Performance</h4>
                    <p class="text-gray-300">Interface rapide et réactive pour une gestion efficace</p>
                </div>

                <div class="feature-card bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 text-center">
                    <div class="text-4xl mb-4">
                        <i class="fas fa-users text-yellow-400"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Support</h4>
                    <p class="text-gray-300">Assistance dédiée pour répondre à toutes vos questions</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white text-center py-6 mt-10 shadow-lg">
            <h3 class="font-bold">Confiance</h3>
            &copy; <span id="year"></span> Confiance — Tous droits réservés. | Réalisé par Med_kr
        </footer>
    </div>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>