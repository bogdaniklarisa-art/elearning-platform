<?php
require_once 'config/db.php';
include 'includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Kurs i pavlefshëm.");
}

$course_id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT courses.*, users.full_name AS instructor_name
    FROM courses
    INNER JOIN users ON courses.instructor_id = users.id
    WHERE courses.id = ? AND courses.status = 'active'
");
$stmt->execute([$course_id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die("Kursi nuk u gjet.");
}
?>

<h2><?= htmlspecialchars($course['title']) ?></h2>

<div class="course-card">
    <p><strong>Instruktori:</strong> <?= htmlspecialchars($course['instructor_name']) ?></p>
    <p><strong>Kategoria:</strong> <?= htmlspecialchars($course['category']) ?></p>
    <p><strong>Përshkrimi:</strong></p>
    <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>

    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] === 'student'): ?>
        <a class="btn-link" href="enroll-course.php?course_id=<?= $course['id'] ?>">Regjistrohu në Kurs</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>