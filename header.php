<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
</head>
<body>
    <header class="main-header">
        <nav class="nav-container">
            <div class="logo">
                <a href="index.php">Florian Thomy</a>
            </div>
            <div class="nav-links">
                <?php 
                $current_page = basename($_SERVER['PHP_SELF']);
                
                // Pages du portfolio pro
                $pro_pages = ['Portfolio_Pro.php', 'projet.php'];
                // Pages du portfolio académique
                $academic_pages = ['academique.php', 'projet_academique.php'];
                
                if ($current_page === 'index.php') {
                    // Sur la page d'accueil
                    echo '<a href="#about">À propos</a>';
                    echo '<a href="#skills">Compétences</a>';
                    echo '<a href="#projects">Projets</a>';
                    echo '<a href="#contact">Contact</a>';
                } elseif (in_array($current_page, $pro_pages)) {
                    // Sur les pages du portfolio pro
                    echo '<a href="#about">À propos</a>';
                    echo '<a href="#skills">Compétences</a>';
                    echo '<a href="#projects">Projets</a>';
                    echo '<a href="#contact">Contact</a>';
                    echo '<a href="academique.php" class="switch-portfolio">Portfolio Académique</a>';
                } elseif (in_array($current_page, $academic_pages)) {
                    // Sur les pages du portfolio académique
                    echo '<a href="#about">À propos</a>';
                    echo '<a href="#skills">Compétences</a>';
                    echo '<a href="#projects">Projets</a>';
                    echo '<a href="#contact">Contact</a>';
                    echo '<a href="Portfolio_Pro.php" class="switch-portfolio">Portfolio Professionnel</a>';
                } else {
                    // Sur toute autre page
                    echo '<a href="index.php#about">À propos</a>';
                    echo '<a href="index.php#skills">Compétences</a>';
                    echo '<a href="index.php#projects">Projets</a>';
                    echo '<a href="index.php#contact">Contact</a>';
                }
                ?>
            </div>
            <button class="nav-toggle" aria-label="Toggle navigation">
                <span class="fas fa-bars"></span>
            </button>
        </nav>
    </header>

<?php
// Au début du fichier, après le <body>
$current_page = basename($_SERVER['PHP_SELF']);
$academic_pages = ['academique.php', 'projet_academique.php'];
$pro_pages = ['Portfolio_Pro.php', 'projet.php'];

// Si nous sommes sur une page académique, ajouter les styles spécifiques
if (in_array($current_page, $academic_pages)) {
    echo '<style>
        /* Header académique */
        .main-header {
            background-color: #2b3a67;
        }

        /* Style pour le container de navigation */
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px; /* Réduit de 80px à 60px */
            padding: 0 20px; /* Ajout de padding horizontal */
        }

        /* Style pour les liens de navigation */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem; 
        }

        .nav-links a {
            color: var(--white);
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 10px;
            font-size: 0.95rem; /* Légère réduction de la taille de police */
        }

        .nav-links a:hover {
            color: #5c88da;
        }

        /* Style pour le bouton de switch portfolio */
        .switch-portfolio {
            background-color: transparent;
            border: 2px solid #5c88da;
            color: var(--white) !important;
            transition: all 0.3s ease;
            padding: 6px 12px !important; /* Réduction du padding */
            display: flex;
            align-items: center;
            height: auto !important;
            border-radius: 4px;
        }

        .switch-portfolio:hover {
            background-color: #5c88da;
            color: var(--white) !important;
            transform: translateY(-2px);
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
        }

        .logo a {
            color: var(--white);
            text-decoration: none;
            font-size: 1.1rem; /* Ajustement de la taille du logo */
        }

        /* Style pour le menu mobile */
        @media (max-width: 768px) {
            .nav-links {
                background-color: rgba(43, 58, 103, 0.95);
                backdrop-filter: blur(10px);
                position: fixed;
                top: 60px;
                left: 0;
                width: 100%;
                height: auto;
                min-height: 320px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 2rem;
                padding: 2rem 0;
                display: none;
                z-index: 999;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                color: var(--white);
                font-size: 1.1rem;
                text-align: center;
                width: 80%;
                padding: 0.75rem;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .nav-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                cursor: pointer;
                width: 40px;
                height: 40px;
                background: transparent;
                border: none;
            }

            .switch-portfolio {
                margin: 0.5rem 0;
                width: 80%;
                max-width: 300px;
                padding: 0.75rem 1.5rem !important;
                justify-content: center;
                font-size: 1.1rem;
            }

            /* Ajout d\'un overlay sombre quand le menu est ouvert */
            body::after {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 998;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease;
            }

            body.menu-open::after {
                opacity: 1;
                visibility: visible;
            }

            /* Ajustement du header en mobile */
            .main-header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            /* Ajustement du contenu principal pour le header fixe */
            body {
                padding-top: 60px;
            }
        }

        @media (max-width: 480px) {
            .nav-links a {
                width: 90%;
                font-size: 1.1rem;
            }

            .switch-portfolio {
                width: 90%;
                font-size: 1.1rem;
            }
        }
    </style>';
} elseif (in_array($current_page, $pro_pages)) {
    echo '<style>
        /* Header professionnel */
        .main-header {
            background-color: #2b3a67;
        }

        /* Style pour le container de navigation */
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Style pour les liens de navigation */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-links a {
            color: var(--white);
            display: flex;
            align-items: center;
            height: 100%;
            padding: 0 10px;
            font-size: 0.95rem;
            position: relative;
            text-decoration: none;
        }

        .nav-links a:hover {
            color: #5c88da;
        }

        /* Style pour le bouton de switch portfolio */
        .switch-portfolio {
            background-color: transparent;
            border: 2px solid #5c88da;
            color: var(--white) !important;
            transition: all 0.3s ease;
            padding: 6px 12px !important;
            display: flex;
            align-items: center;
            height: auto !important;
            border-radius: 4px;
        }

        .switch-portfolio:hover {
            background-color: #5c88da;
            color: var(--white) !important;
            transform: translateY(-2px);
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
        }

        .logo a {
            color: var(--white);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
        }

        /* Style pour le menu mobile */
        @media (max-width: 768px) {
            .nav-links {
                background-color: rgba(43, 58, 103, 0.95);
                backdrop-filter: blur(10px);
                position: fixed;
                top: 60px;
                left: 0;
                width: 100%;
                height: auto;
                min-height: 320px;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 2rem;
                padding: 2rem 0;
                display: none;
                z-index: 999;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                color: var(--white);
                font-size: 1.1rem;
                text-align: center;
                width: 80%;
                padding: 0.75rem;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .nav-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                cursor: pointer;
                width: 40px;
                height: 40px;
                background: transparent;
                border: none;
            }

            .switch-portfolio {
                margin: 0.5rem 0;
                width: 80%;
                max-width: 300px;
                padding: 0.75rem 1.5rem !important;
                justify-content: center;
                font-size: 1.1rem;
            }

            /* Ajout d\'un overlay sombre quand le menu est ouvert */
            body::after {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 998;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease;
            }

            body.menu-open::after {
                opacity: 1;
                visibility: visible;
            }

            /* Ajustement du header en mobile */
            .main-header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            /* Ajustement du contenu principal pour le header fixe */
            body {
                padding-top: 60px;
            }
        }

        @media (max-width: 480px) {
            .nav-links a {
                width: 90%;
                font-size: 1.1rem;
            }

            .switch-portfolio {
                width: 90%;
                font-size: 1.1rem;
            }
        }
    </style>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navToggle = document.querySelector(".nav-toggle");
            const navLinks = document.querySelector(".nav-links");
            const links = document.querySelectorAll(".nav-links a");

            // Toggle menu
            navToggle.addEventListener("click", function() {
                navLinks.classList.toggle("active");
                navToggle.classList.toggle("active");
                document.body.classList.toggle("menu-open");
            });

            // Close menu when clicking on a link
            links.forEach(link => {
                link.addEventListener("click", () => {
                    navLinks.classList.remove("active");
                    navToggle.classList.remove("active");
                    document.body.classList.remove("menu-open");
                });
            });

            // Close menu when clicking outside
            document.addEventListener("click", function(e) {
                if (!navToggle.contains(e.target) && !navLinks.contains(e.target)) {
                    navLinks.classList.remove("active");
                    navToggle.classList.remove("active");
                    document.body.classList.remove("menu-open");
                }
            });
        });
    </script>';
}

// Ajouter le script JavaScript pour toutes les pages
echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navToggle = document.querySelector(".nav-toggle");
        const navLinks = document.querySelector(".nav-links");
        const links = document.querySelectorAll(".nav-links a");

        // Toggle menu
        navToggle.addEventListener("click", function() {
            navLinks.classList.toggle("active");
            document.body.classList.toggle("menu-open");
        });

        // Close menu when clicking on a link
        links.forEach(link => {
            link.addEventListener("click", () => {
                navLinks.classList.remove("active");
                document.body.classList.remove("menu-open");
            });
        });

        // Close menu when clicking outside
        document.addEventListener("click", function(e) {
            if (!navToggle.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove("active");
                document.body.classList.remove("menu-open");
            }
        });
    });
</script>';
?>