<?php
require_once 'includes/auth.php';
require_once 'config/db.php';

if ($_SESSION['role'] !== 'student') {
    die("Vetëm studentët mund të regjistrohen në kurs.");
}

if (!isset($_GET['course_id']) || !is_numeric($_GET['course_id'])) {
    die("Kurs i pavlefshëm.");
}

$course_id = (int) $_GET['course_id'];
$student_id = $_SESSION['user_id'];

// kontrollo nëse ekziston regjistrimi
$stmt = $pdo->prepare("SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?");
$stmt->execute([$student_id, $course_id]);

if ($stmt->fetch()) {
    header("Location: student/my-courses.php?msg=already_enrolled");
    exit;
}

// shto regjistrimin
$stmt = $pdo->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
$stmt->execute([$student_id, $course_id]);

header("Location: student/my-courses.php?msg=enrolled_success");
exit;
require_once 'includes/send-email.php';

$stmt = $pdo->prepare("SELECT email, full_name FROM users WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

$subject = "Regjistrim në kurs";
$email_message = "
    <h2>Përshëndetje, {$student['full_name']}!</h2>
    <p>Ju u regjistruat me sukses në kursin: <strong>{$course['title']}</strong>.</p>
";

sendEmail($student['email'], $subject, $email_message);