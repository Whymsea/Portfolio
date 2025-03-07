<?php 
include 'header.php';
include 'connection.php';

// Nombre de projets par page
$projects_per_page = 6;

// Récupérer le numéro de page actuel
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

try {
    // Compter le nombre total de projets
    $count_query = "SELECT COUNT(*) FROM project WHERE ID_project != 19";
    $total_projects = $pdo->query($count_query)->fetchColumn();
    
    // Calculer le nombre total de pages
    $total_pages = ceil($total_projects / $projects_per_page);
    
    // S'assurer que la page demandée est valide
    if ($page < 1) $page = 1;
    if ($page > $total_pages) $page = $total_pages;
    
    // Calculer l'offset pour la requête SQL
    $offset = ($page - 1) * $projects_per_page;
    
    // Requête pour récupérer les projets
    $query = "
        SELECT DISTINCT 
            CASE 
                WHEN p.titre_project = 'Vivliomedia' THEN 'SAE 401'
                ELSE p.titre_project 
            END as titre_project,
            p.ID_project,
            p.description_project,
            ph.chemin_photos,
            ph.titre_photos,
            c.categorie_projet,
            l.lien_photos
        FROM project p
        JOIN photos ph ON p.ID_photos = ph.ID_photos
        JOIN categorie_projet c ON p.ID_categorie_projet = c.ID_categorie_projet
        JOIN lien_photos l ON p.ID_lien_photos = l.ID_lien_photos
        WHERE p.ID_project != 19
        GROUP BY p.ID_project
        ORDER BY RAND()
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $projects_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<style>
    .hero {
        background-image: url('img/hero.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .about {
        background-image: url('img/about.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        min-height: 50vh;
    }

    .skills {
        background-image: url('img/Terre.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .projects {
        background-image: url('img/projets.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }

    .contact {
        background-image: url('img/contact.svg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    .about-text h2{
        color : white;
        margin-top: 5rem;
    }
    .about-text p{
        font-weight: 700;
        font-size: 1.3rem;
        color:white;
    }

    .hero-content, .about-content, .skills-grid, .projects-grid, .contact-content {
        position: relative;
        z-index: 2;
    }

    .hero-content {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .hero::before{
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 2rem;
        gap: 0.6rem;
        position: relative;
        z-index: 2;
    }

    .pagination-button {
        background: var(--secondary-color);
        color: white;
        border: none;
        padding: 0.3rem 0.6rem;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .pagination-button:hover {
        background: var(--secondary-color);
    }

    .pagination-button[disabled] {
        background: #ccc;
        cursor: not-allowed;
        pointer-events: none;
    }

    .page-info {
        color: White;
        font-weight: bold;
        font-size: 0.85rem;
    }

    .hero-text h2 {
    font-size: 2rem;
    color:rgb(0, 105, 175);
    margin-bottom: 20px;
}

/* Styles de base pour les formulaires */
.contact-content {
    display: flex;
    gap: 2rem;
    padding: 2rem;
}

.contact-form, 
.contact-info {
    background-color: rgba(0, 0, 0, 0.35);
    padding: 2rem;
    border-radius: 10px;
    backdrop-filter: blur(5px);
    flex: 1;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 1rem;
    background-color: rgba(255, 255, 255, 0.9);
    color: #000;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 5px;
    padding: 10px;
}

.contact-form input::placeholder,
.contact-form textarea::placeholder {
    color: #666;
}

.contact-form input:focus,
.contact-form textarea:focus {
    outline: none;
    border-color: var(--secondary-color);
    background-color: #fff;
}

/* Ajustement du responsive */
@media (max-width: 768px) {
    .contact-content {
        flex-direction: column;
        padding: 1rem;
    }

    .contact-form, 
    .contact-info {
        width: auto;
        padding: 1rem;
        margin: 0 1rem 1rem 1rem;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .contact-form form {
        width: 100%;
    }

    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 0.8rem;
        background-color: rgba(255, 255, 255, 0.95);
    }
}

/* Pour les très petits écrans */
@media (max-width: 480px) {
    .contact-content {
        padding: 0.5rem;
    }

    .contact-form, 
    .contact-info {
        padding: 1rem;
        margin: 0 0.5rem 1rem 0.5rem;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .contact-form input,
    .contact-form textarea {
        padding: 6px;
    .contact-form h3,
    .contact-info h3 {
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }
}

/* Header personnalisé pour le portfolio académique */
.main-header {
    background-color: #2b3a67; /* Bleu foncé */
}

/* Sections avec fond bleu */
.skills, 
.projects, 
.contact {
    background-color: #2b3a67;
    position: relative;
}

/* Ajustement des cartes de projets */
.project-card {
    background-color: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    border-radius: 10px;
    overflow: hidden;
}

.project-info {
    padding: 1rem;
    background-color: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(5px);
}

/* Footer personnalisé */
.main-footer {
    background-color: #2b3a67;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

/* Cartes de compétences */
.skill-item {
    background-color: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    padding: 1.5rem;
    border-radius: 10px;
}

/* Bouton de switch portfolio */
.switch-portfolio {
    background-color: #5c88da;
    border-color: #5c88da;
}

.switch-portfolio:hover {
    background-color: #3a4d88;
    border-color: #5c88da;
}

/* Ajustement du responsive */
@media (max-width: 768px) {
    .about-content {
        flex-direction: column;
        text-align: center;
        padding: 2rem 1rem;
    }

    .about-text h2 {
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }

    .about-text p {
        font-weight: 700;
        font-size: 1.1rem;
        color: white;
        line-height: 1.6;
    }

    /* Masquer l'image sur mobile */
    .about-image {
        display: none;
    }

    /* Ajustement des boutons de pagination pour mobile */
    .pagination-button {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }

    .pagination-container {
        gap: 0.8rem;
    }

    .page-info {
        font-size: 0.9rem;
    }

    .skill-item, 
    .project-card,
    .project-info {
        background-color: rgba(0, 0, 0, 0.4);
    }
}

/* Pour les très petits écrans */
@media (max-width: 480px) {
    .about-text h2 {
        margin-top: 2.5rem;
        font-size: 1.8rem;
    }

    /* Réduction supplémentaire pour les très petits écrans */
    .pagination-button {
        padding: 0.3rem 0.6rem;
        font-size: 0.85rem;
    }

    .pagination-container {
        gap: 0.6rem;
    }

    .page-info {
        font-size: 0.85rem;
    }

    .skill-item, 
    .project-card,
    .project-info {
        background-color: rgba(0, 0, 0, 0.5);
    }
}

/* Version desktop (à partir de 768px) */
@media (min-width: 768px) {
    .pagination-button {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }

    .pagination-container {
        gap: 1rem;
    }

    .page-info {
        font-size: 1rem;
    }
}
</style>

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
                <p>Bonjour, je m'appelle Florian Thomy et je suis étudiant en développement web, avec une spécialisation en développement back-end. Toujours en quête d'amélioration de mes compétences, je m'efforce de rester à la pointe des technologies et des meilleures pratiques dans ce domaine. En dehors de mes études, je prends plaisir à créer des illustrations en low poly sur Illustrator et à explorer ma passion pour la photographie.</p>
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
                        <a href="projet_academique.php?id=<?php echo $project['ID_project']; ?>" 
                        class="project-link">Voir les détails</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <a href="?page=<?php echo max(1, $page - 1); ?>" 
               class="pagination-button" 
               <?php if($page <= 1) echo 'disabled'; ?>>
                <i class="fas fa-chevron-left"></i>
            </a>
            
            <span class="page-info">Page <?php echo $page; ?> sur <?php echo $total_pages; ?></span>
            
            <a href="?page=<?php echo min($total_pages, $page + 1); ?>" 
               class="pagination-button" 
               <?php if($page >= $total_pages) echo 'disabled'; ?>>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact" class="contact">
        <div class="contact-content">
            <div class="contact-info">
                <h3>Informations</h3>
                <p><i class="fas fa-envelope"></i> florian.thomy01@gmail.com</p>
                <p><i class="fas fa-phone"></i> +33 6 66 51 59 05</p>
            </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.pagination-button');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.hasAttribute('disabled')) {
                e.preventDefault();
                return;
            }
            
            e.preventDefault(); // Empêche le comportement par défaut du lien
            
            // Récupère l'URL du bouton
            const url = new URL(this.href);
            const page = url.searchParams.get('page');
            
            // Effectue une requête AJAX
            fetch(`?page=${page}`)
                .then(response => response.text())
                .then(html => {
                    // Crée un DOM temporaire pour parser la réponse
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Met à jour uniquement la grille de projets et la pagination
                    const projectsGrid = doc.querySelector('.projects-grid');
                    const pagination = doc.querySelector('.pagination-container');
                    
                    document.querySelector('.projects-grid').innerHTML = projectsGrid.innerHTML;
                    document.querySelector('.pagination-container').innerHTML = pagination.innerHTML;
                    
                    // Met à jour l'URL sans recharger la page
                    window.history.pushState({}, '', `?page=${page}#projects`);
                    
                    // Réinitialise les écouteurs d'événements sur les nouveaux boutons
                    initPaginationListeners();
                });
        });
    });
    
    function initPaginationListeners() {
        const newButtons = document.querySelectorAll('.pagination-button');
        newButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.hasAttribute('disabled')) {
                    e.preventDefault();
                    return;
                }
                
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                
                fetch(`?page=${page}`)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const projectsGrid = doc.querySelector('.projects-grid');
                        const pagination = doc.querySelector('.pagination-container');
                        
                        document.querySelector('.projects-grid').innerHTML = projectsGrid.innerHTML;
                        document.querySelector('.pagination-container').innerHTML = pagination.innerHTML;
                        
                        window.history.pushState({}, '', `?page=${page}#projects`);
                        
                        initPaginationListeners();
                    });
            });
        });
    }
});
</script>

<?php include 'footer.php'; ?>