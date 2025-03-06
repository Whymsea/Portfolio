<?php
// Au début du fichier, avant le footer
$current_page = basename($_SERVER['PHP_SELF']);
$academic_pages = ['academique.php', 'projet_academique.php'];

echo '<style>
    /* Styles communs pour le footer */
    .footer-section ul li {
        width: auto;
        display: block;
    }

    .footer-section ul li a {
        display: inline-block;
        width: auto;
    }

    /* Style commun pour le bouton de switch portfolio */
    .footer-section .switch-portfolio {
        display: inline-block;
        background-color: transparent;
        padding: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
        width: auto;
    }

    .footer-section .switch-portfolio:hover {
        transform: translateY(-2px);
    }
</style>';

// Si nous sommes sur une page académique, ajouter les styles spécifiques
if (in_array($current_page, $academic_pages)) {
    echo '<style>
        /* Footer académique */
        .main-footer {
            background-color: #2b3a67;
        }

        .footer-section h3 {
            color: #5c88da;
        }

        .footer-section a:hover {
            color: #5c88da;
        }

        .social-links a:hover {
            color: #5c88da;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Style spécifique pour le bouton de switch portfolio version académique */
        .footer-section .switch-portfolio {
            border: 2px solid #5c88da;
            color: var(--white) !important;
        }

        .footer-section .switch-portfolio:hover {
            background-color: #5c88da;
            color: var(--white) !important;
        }
    </style>';
}
?>

<footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: florian.thomy01@gmail.com</p>
                <p>Téléphone: +33 6 66 51 59 05</p>
            </div>
            <div class="footer-section">
                <h3>Réseaux sociaux</h3>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/florian-thomy-233611229/" target="_blank"><i class="fab fa-linkedin"></i></a>
                    <a href="https://github.com/Whymsea" target="_blank"><i class="fab fa-github"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Navigation</h3>
                <ul>
                    <?php 
                    $current_page = basename($_SERVER['PHP_SELF']);
                    $pro_pages = ['Portfolio_Pro.php', 'projet.php'];
                    $academic_pages = ['academique.php', 'projet_academique.php'];

                    if ($current_page === 'index.php') {
                        // Sur la page d'accueil
                        echo '<li><a href="#about">À propos</a></li>';
                        echo '<li><a href="#skills">Compétences</a></li>';
                        echo '<li><a href="#projects">Projets</a></li>';
                        echo '<li><a href="#contact">Contact</a></li>';
                    } elseif (in_array($current_page, $pro_pages)) {
                        // Sur les pages du portfolio pro
                        echo '<li><a href="#about">À propos</a></li>';
                        echo '<li><a href="#skills">Compétences</a></li>';
                        echo '<li><a href="#projects">Projets</a></li>';
                        echo '<li><a href="#contact">Contact</a></li>';
                        echo '<li><a href="academique.php" class="switch-portfolio">Portfolio Académique</a></li>';
                    } elseif (in_array($current_page, $academic_pages)) {
                        // Sur les pages du portfolio académique
                        echo '<li><a href="#about">À propos</a></li>';
                        echo '<li><a href="#skills">Compétences</a></li>';
                        echo '<li><a href="#projects">Projets</a></li>';
                        echo '<li><a href="#contact">Contact</a></li>';
                        echo '<li><a href="Portfolio_Pro.php" class="switch-portfolio">Portfolio Professionnel</a></li>';
                    } else {
                        // Sur toute autre page
                        echo '<li><a href="index.php#about">À propos</a></li>';
                        echo '<li><a href="index.php#skills">Compétences</a></li>';
                        echo '<li><a href="index.php#projects">Projets</a></li>';
                        echo '<li><a href="index.php#contact">Contact</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p> Florian THOMY. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Menu mobile toggle
        document.querySelector('.nav-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });

        // Smooth scroll pour les liens d'ancrage
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>