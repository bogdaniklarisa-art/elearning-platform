<?php
require_once 'config/db.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

$stmt = $pdo->prepare("SELECT * FROM courses WHERE title LIKE ? AND status='active'");
$stmt->execute(["%$search%"]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($courses as $course) {
    echo '<div class="course-card">';
    echo '<span class="course-tag">' . htmlspecialchars($course['category']) . '</span>';
    echo '<h3>' . htmlspecialchars($course['title']) . '</h3>';
    echo '<p>' . htmlspecialchars($course['description']) . '</p>';
    echo '<div class="course-meta"><span>Status: ' . htmlspecialchars($course['status']) . '</span></div>';
    echo '<a class="btn-link" href="course-details.php?id=' . $course['id'] . '">Shiko Detajet</a>';
    echo '</div>';
}