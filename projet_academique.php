<?php 
include 'header.php';
include 'connection.php';

// Récupérer l'ID du projet depuis l'URL
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Récupérer les détails du projet
    $query = "
        SELECT p.*, ph.chemin_photos, ph.titre_photos, c.categorie_projet, l.lien_photos,
               a.annee,
               GROUP_CONCAT(DISTINCT cp.competences) as competences,
               GROUP_CONCAT(DISTINCT cl.apprentissage_critique) as critical_learnings,
               GROUP_CONCAT(DISTINCT t.nom_technologie) as technologies
        FROM project p
        JOIN photos ph ON p.ID_photos = ph.ID_photos
        JOIN categorie_projet c ON p.ID_categorie_projet = c.ID_categorie_projet
        JOIN lien_photos l ON p.ID_lien_photos = l.ID_lien_photos
        JOIN annee_project a ON p.ID_Annee_project = a.ID_Annee_project
        LEFT JOIN project_competences pc ON p.ID_project = pc.ID_project
        LEFT JOIN competences_project cp ON pc.ID_Competences_project = cp.ID_Competences_project
        LEFT JOIN project_Apprentissage_critique pcl ON p.ID_project = pcl.ID_project
        LEFT JOIN apprentissage_critique_project cl ON pcl.ID_Apprentissage_critique_project = cl.ID_Apprentissage_critique_project
        LEFT JOIN project_technologies pt ON p.ID_project = pt.ID_project
        LEFT JOIN technologies t ON pt.ID_technologies = t.ID_technologies
        WHERE p.ID_project = :id
        GROUP BY p.ID_project
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $project_id]);
    $project = $stmt->fetch();

    if (!$project) {
        header('Location: index.php');
        exit();
    }

    // Requête pour obtenir les AC avec leurs descriptions
    $ac_query = "
        SELECT ac.apprentissage_critique, ac.description_apprentissage_critique
        FROM project_apprentissage_critique pac
        JOIN apprentissage_critique_project ac ON pac.ID_Apprentissage_critique_project = ac.ID_Apprentissage_critique_project
        WHERE pac.ID_project = :id
    ";
    $ac_stmt = $pdo->prepare($ac_query);
    $ac_stmt->execute(['id' => $project_id]);
    $apprentissages = $ac_stmt->fetchAll();

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<style>
    /* Header personnalisé pour les projets académiques */
    .main-header {
        background-color: #2b3a67; /* Bleu foncé */
    }

    /* Section détails du projet */
    .project-details {
        background-image: url('img/contact.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    /* Ajout d'un overlay pour assurer la lisibilité */
    .project-details::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(43, 58, 103, 0.4); /* Bleu foncé avec 30% d'opacité */
        z-index: 1;
    }

    /* S'assurer que le contenu reste au-dessus de l'overlay */
    .project-details .container {
        position: relative;
        z-index: 2;
    }

    /* Contenu du projet */
    .project-content {
        background-color: rgba(0, 0, 0, 0.1); /* Fond semi-transparent noir */
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border-radius: 10px;
        padding: 2rem;
    }

    /* Ajustement pour le responsive */
    @media (max-width: 768px) {
        .project-content {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .project-content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 1rem;
        }
    }

    /* Tags des technologies - Garder le style existant */
    .tech-tag {
        background-color: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Style pour les AC tags */
    .ac-tag {
        position: relative;
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 8px 12px;
        margin: 5px;
        display: inline-block;
        color: white;
    }

    /* Style de base pour le tooltip */
    .tooltip {
        visibility: hidden;
        opacity: 0;
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 400px;
        background-color: rgba(0, 0, 0, 0.95);
        color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        transition: opacity 0.3s;
        z-index: 1000;
        font-size: 1rem;
        line-height: 1.5;
    }

    /* Version desktop */
    @media (min-width: 769px) {
        .tooltip {
            position: absolute;
            bottom: 100%;
            width: 300px;
            margin-bottom: 15px;
        }

        .tooltip strong {
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
        }
    }

    /* Version mobile */
    @media (max-width: 768px) {
        .ac-tag::after {
            content: ' 👆';
            font-size: 0.8em;
        }

        .ac-tag.active .tooltip {
            visibility: visible;
            opacity: 1;
        }
    }

    /* Footer */
    .main-footer {
        background-color: rgba(43, 58, 103, 0.3); /* Bleu foncé avec 30% d'opacité */
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Liens - Garder opaques pour la lisibilité */
    .project-link,
    .back-link {
        background-color: #5c88da;
    }

    .project-link:hover,
    .back-link:hover {
        background-color: #3a4d88;
        border: 1px solid #5c88da;
    }
</style>

<main>
    <section class="project-details">
        <div class="container">
            <!-- En-tête du projet -->
            <div class="project-header">
                <h1><?php echo htmlspecialchars($project['titre_project']); ?></h1>
                <span class="category">
                    <?php 
                    // Récupérer l'année depuis la base de données
                    echo htmlspecialchars($project['annee']) . ' - ' . htmlspecialchars($project['categorie_projet']); 
                    ?>
                </span>
            </div>

            <div class="project-content">
                <!-- Image du projet -->
                <div class="project-image">
                    <img src="<?php echo htmlspecialchars($project['chemin_photos']); ?>" 
                         alt="<?php echo htmlspecialchars($project['titre_photos']); ?>">
                </div>

                <!-- Description du projet -->
                <div class="project-description">
                    <h2>Description du projet</h2>
                    <p><?php echo nl2br(htmlspecialchars($project['description_project'])); ?></p>
                </div>

                <!-- Section technologies -->
                <div class="project-technologies">
                    <h2>Technologies utilisées</h2>
                    <div class="tech-tags">
                        <?php 
                        $technologies = explode(',', $project['technologies']);
                        foreach ($technologies as $tech) : 
                            if(trim($tech) != ''): ?>
                                <span class="tech-tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                        <?php endif; endforeach; ?>
                    </div>
                </div>

                <!-- Section apprentissages critiques -->
                <?php 
                // Vérifier si il y a des apprentissages critiques valides
                $hasValidAC = false;
                foreach ($apprentissages as $ac) {
                    if (!empty($ac['apprentissage_critique']) && $ac['apprentissage_critique'] !== 'aucune') {
                        $hasValidAC = true;
                        break;
                    }
                }

                // N'afficher la section que si des apprentissages critiques valides existent
                if ($hasValidAC): ?>
                    <div class="project-apprentissages">
                        <h2>Apprentissages critiques</h2>
                        <div class="ac-tags">
                            <?php foreach ($apprentissages as $ac) : 
                                if(!empty($ac['apprentissage_critique']) && $ac['apprentissage_critique'] !== 'aucune'): ?>
                                    <span class="ac-tag">
                                        <?php echo htmlspecialchars($ac['apprentissage_critique']); ?>
                                        <div class="tooltip">
                                            <strong><?php echo htmlspecialchars($ac['apprentissage_critique']); ?></strong><br>
                                            <?php echo htmlspecialchars($ac['description_apprentissage_critique']); ?>
                                        </div>
                                    </span>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Liens du projet -->
                <div class="project-links">
                    <?php if ($project['lien_photos']) : ?>
                        <a href="<?php echo htmlspecialchars($project['lien_photos']); ?>" 
                           class="project-link" target="_blank">Voir le projet en ligne</a>
                    <?php endif; ?>
                    <a href="academique.php#projects" class="back-link">Retour aux projets</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const acTags = document.querySelectorAll('.ac-tag');
    let activeTag = null;

    // Fonction pour fermer le tooltip actif
    function closeActiveTooltip() {
        if (activeTag) {
            activeTag.classList.remove('active');
            activeTag = null;
        }
    }

    // Gestionnaire pour chaque tag AC
    acTags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            e.stopPropagation(); // Empêche la propagation au document
            
            // Si ce tag est déjà actif, on le ferme
            if (this === activeTag) {
                closeActiveTooltip();
                return;
            }

            // Ferme le tooltip actif précédent
            closeActiveTooltip();
            
            // Active le nouveau tooltip
            this.classList.add('active');
            activeTag = this;
        });
    });

    // Ferme le tooltip si on clique ailleurs sur la page
    document.addEventListener('click', function() {
        closeActiveTooltip();
    });
});
</script>

<?php include 'footer.php'; ?>