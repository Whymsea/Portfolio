<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Choix du mode</title>
    <style>
        body {
            margin: 0;
            background-color:rgb(208, 224, 235);
            transition: background-color 0.3s ease;
            min-height: 100vh;
        }

        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2.5rem;
            padding: 20px;
            box-sizing: border-box;
        }

        .portfolio-button {
            padding: 1.5rem 3rem;
            font-size: 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            min-width: 200px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .pro-button {
            background-color:#2b3a67;
            border: 2px solid transparent;
        }

        .pro-button:hover {
            background-color: white;
            color: #2b3a67;
            border: 2px solid rgb(38, 58, 117);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(43, 58, 103, 0.3);
        }

        .pro-button:hover ~ .container {
            background-color:rgb(41, 50, 77);
        }

        .academic-button {
            background-color: #5c88da;
            border: 2px solid transparent;
        }

        .academic-button:hover {
            background-color: white;
            color: #5c88da;
            border: 2px solid #5c88da;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(92, 136, 218, 0.3);
        }

        /* Classe pour le changement de background */
        body.pro-hover {
            background-color:rgb(45, 52, 72);
        }

        body.academic-hover {
            background-image: url('img/hero.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Media queries pour le responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                gap: 3rem;
            }

            .portfolio-button {
                padding: 1.2rem 2rem;
                font-size: 1rem;
                min-width: 80%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .portfolio-button {
                padding: 1rem 1.5rem;
                font-size: 0.9rem;
                min-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="Portfolio_Pro.php" class="portfolio-button pro-button" onmouseover="document.body.classList.add('pro-hover')" onmouseout="document.body.classList.remove('pro-hover')">
            Portfolio Professionnel
        </a>
        <a href="academique.php" class="portfolio-button academic-button" onmouseover="document.body.classList.add('academic-hover')" onmouseout="document.body.classList.remove('academic-hover')">
            Portfolio Académique
        </a>
    </div>

    <script>
        // Pour une transition plus fluide
        document.addEventListener('DOMContentLoaded', function() {
            const proButton = document.querySelector('.pro-button');
            const academicButton = document.querySelector('.academic-button');
            
            proButton.addEventListener('mouseenter', () => {
                document.body.classList.add('pro-hover');
            });
            
            proButton.addEventListener('mouseleave', () => {
                document.body.classList.remove('pro-hover');
            });
            
            academicButton.addEventListener('mouseenter', () => {
                document.body.classList.add('academic-hover');
            });
            
            academicButton.addEventListener('mouseleave', () => {
                document.body.classList.remove('academic-hover');
            });
        });
    </script>
</body>
</html>