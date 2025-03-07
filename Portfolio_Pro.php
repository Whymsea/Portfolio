<?php 
include 'header.php';
include 'connection.php';

// Récupérer uniquement les projets professionnels
try {
    $query = "
        SELECT p.*, ph.chemin_photos, ph.titre_photos, c.categorie_projet, l.lien_photos
        FROM project p
        JOIN photos ph ON p.ID_photos = ph.ID_photos
        JOIN categorie_projet c ON p.ID_categorie_projet = c.ID_categorie_projet
        JOIN lien_photos l ON p.ID_lien_photos = l.ID_lien_photos
        WHERE p.ID_type_projet = 2
        ORDER BY p.ID_project DESC
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<main>
    <!-- Section Hero -->
    <section id="home" class="hero">
        <div class="hero-content">
            <div class="hero-image">
                <img src="img/Pdp.jpg" alt="Profile Image">
            </div>
            <div class="hero-text">
                <h1>Florian THOMY</h1>
                <h2>Développeur Web</h2>
                <p>"Les idées ne valent rien si elles ne sont pas mises en œuvre."
                Albert Einstein</p>
            </div>
        </div>
    </section>

    <!-- Section À propos -->
    <section id="about" class="about">
        <div class="about-content">
            <div class="about-text">
                <h2>À propos de moi</h2>
                <p>Bonjour, je m’appelle Florian Thomy et je suis étudiant en développement web, avec une spécialisation en développement back-end. Toujours en quête d’amélioration de mes compétences, je m’efforce de rester à la pointe des technologies et des meilleures pratiques dans ce domaine. En dehors de mes études, je prends plaisir à créer des illustrations en low poly sur Illustrator et à explorer ma passion pour la photographie.</p>
            </div>
            <div class="about-image">
                <img src="img/photo_paysage.jpg" alt="Image paysage">
            </div>
        </div>
    </section>

    <!-- Section Compétences -->
    <section id="skills" class="skills">
        <h2>Mes Compétences</h2>
        <div class="skills-grid">
            <div class="skill-item">
                <i class="fas fa-code"></i>
                <h3>Développement Web</h3>
                <p>HTML, CSS, JavaScript, PHP, MySQL</p>
            </div>
            <div class="skill-item">
                <i class="fas fa-mobile-alt"></i>
                <h3>Design</h3>
                <p>Design 2D Low Poly</p>
            </div>
            <div class="skill-item">
                <i class="fas fa-paint-brush"></i>
                <h3>UI/UX Design</h3>
                <p>Figma, Adobe XD</p>
            </div>
            <div class="skill-item">
                <i class="fas fa-server"></i>
                <h3>Backend</h3>
                <p>Node.js, Express, MongoDB</p>
            </div>
        </div>
    </section>

    <!-- Section Projets -->
    <section id="projects" class="projects">
        <h2>Mes Projets</h2>
        <div class="projects-grid">
            <?php foreach ($projects as $project) : ?>
                <div class="project-card">
                    <img src="<?php echo htmlspecialchars($project['chemin_photos']); ?>" 
                        alt="<?php echo htmlspecialchars($project['titre_photos']); ?>">
                    <div class="project-info">
                        <h3><?php echo htmlspecialchars($project['titre_project']); ?></h3>
                        <a href="projet.php?id=<?php echo $project['ID_project']; ?>" 
                        class="project-link">Voir les détails</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact" class="contact">
        <h2>Contact</h2>
        <div class="contact-content">
            <div class="contact-info">
                <h3>Informations</h3>
                <p><i class="fas fa-envelope"></i> florian.thomy01@gmail.com</p>
                <p><i class="fas fa-phone"></i> +33 6 66 51 59 05</p>
            </div>
           <!-- Dans la section contact, juste avant le formulaire -->
            <div class="contact-form">
                <h3>Envoyez-moi un message</h3>
                <?php if(isset($_GET['status'])): ?>
                    <?php if($_GET['status'] == 'success'): ?>
                        <div class="alert success">
                            Votre message a été envoyé avec succès !
                        </div>
                    <?php elseif($_GET['status'] == 'error'): ?>
                        <div class="alert error">
                            Une erreur est survenue lors de l'envoi du message. Veuillez réessayer.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <form action="process.php" method="POST">
                    <input type="text" name="name" placeholder="Votre nom" required>
                    <input type="email" name="email" placeholder="Votre email" required>
                    <textarea name="message" placeholder="Votre message" required></textarea>
                    <button type="submit" class="submit-btn">Envoyer</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>