<?php
session_start();
require_once 'config/db.php';

$message = "";
$is_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($user['role'] == 'instructor') {
            header("Location: instructor/dashboard.php");
        } else {
            header("Location: student/dashboard.php");
        }
        exit;
    } else {
        $message = "Email ose password i gabuar.";
        $is_error = true;
    }
}
?>

<?php include 'includes/header.php'; ?>

<section class="auth-section">
    <div class="auth-wrapper">
        <div class="auth-side">
            <span class="badge">Welcome Back</span>
            <h1>Hyr në platformën tënde të mësimit online</h1>
            <p>
                Akses i shpejtë për studentët, instruktorët dhe administratorët
                në një ambient modern dhe profesional.
            </p>
            <ul>
                <li>Menaxhim kursesh dhe materialesh</li>
                <li>Ndjekje progresi në kohë reale</li>
                <li>Panele të veçanta sipas rolit</li>
                <li>Eksperiencë moderne dhe responsive</li>
            </ul>
        </div>

        <div class="auth-card">
            <h2>Login</h2>
            <p>Vendos të dhënat e tua për të hyrë në sistem.</p>

            <?php if($message): ?>
                <div class="<?= $is_error ? 'error-box' : 'message-box' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="form-box">
                <form method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Hyr në llogari</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>