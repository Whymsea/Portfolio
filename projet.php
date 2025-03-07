<?php 
include 'header.php';
include 'connection.php';

// Récupérer l'ID du projet depuis l'URL
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Récupérer les détails du projet
    $query = "
        SELECT p.*, ph.chemin_photos, ph.titre_photos, c.categorie_projet, l.lien_photos,
               GROUP_CONCAT(DISTINCT cp.competences) as competences,
               GROUP_CONCAT(DISTINCT cl.apprentissage_critique) as critical_learnings,
               GROUP_CONCAT(DISTINCT t.nom_technologie) as technologies
        FROM project p
        JOIN photos ph ON p.ID_photos = ph.ID_photos
        JOIN categorie_projet c ON p.ID_categorie_projet = c.ID_categorie_projet
        JOIN lien_photos l ON p.ID_lien_photos = l.ID_lien_photos
        LEFT JOIN project_competences pc ON p.ID_project = pc.ID_project
        LEFT JOIN competences_project cp ON pc.ID_Competences_project = cp.ID_Competences_project
        LEFT JOIN project_apprentissage_critique pcl ON p.ID_project = pcl.ID_project
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
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<main>
    <section class="project-details">
        <div class="container">
            <!-- En-tête du projet -->
            <div class="project-header">
                <h1><?php echo htmlspecialchars($project['titre_project']); ?></h1>
                <span class="category"><?php echo htmlspecialchars($project['categorie_projet']); ?></span>
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

                <!-- Section technologies commentée temporairement -->

                <div class="project-technologies">
                    <h2>Technologies utilisées</h2>
                    <div class="tech-tags">
                        <?php 
                        $technologies = explode(',', $project['technologies']);
                        foreach ($technologies as $tech) : 
                        ?>
                            <span class="tech-tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Liens du projet -->
                <div class="project-links">
                    <?php if ($project['lien_photos']) : ?>
                        <a href="<?php echo htmlspecialchars($project['lien_photos']); ?>" 
                           class="project-link" target="_blank">Voir le projet en ligne</a>
                    <?php endif; ?>
                    <a href="index.php#projects" class="back-link">Retour aux projets</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>