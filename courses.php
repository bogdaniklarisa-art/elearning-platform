<?php
require_once 'config/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM courses WHERE status='active' ORDER BY created_at DESC");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="section">
    <div class="section-title">
        <div class="eyebrow">Kurset</div>
        <h2>Zbulo kurset tona</h2>
        <p>
            Kërko dhe eksploro kurse të ndryshme sipas interesit tënd.
        </p>
    </div>

    <div class="search-box">
        <input type="text" id="live-search" placeholder="Kërko kurs...">
    </div>

    <div id="search-results" class="courses-list">
        <?php foreach($courses as $course): ?>
            <div class="course-card">
                <span class="course-tag"><?= htmlspecialchars($course['category']) ?></span>
                <h3><?= htmlspecialchars($course['title']) ?></h3>
                <p><?= htmlspecialchars($course['description']) ?></p>

                <div class="course-meta">
                    <span>Status: <?= htmlspecialchars($course['status']) ?></span>
                </div>

                <a class="btn-link" href="course-details.php?id=<?= $course['id'] ?>">Shiko Detajet</a>

                <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'student'): ?>
                    <a class="btn-soft" href="enroll-course.php?course_id=<?= $course['id'] ?>">Regjistrohu</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script src="assets/js/main.js"></script>

<?php include 'includes/footer.php'; ?>