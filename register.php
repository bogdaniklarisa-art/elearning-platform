<?php
session_start();
require_once 'config/db.php';

$message = "";
$is_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (!empty($full_name) && !empty($email) && !empty($password) && !empty($role)) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $message = "Ky email ekziston tashmë.";
            $is_error = true;
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $hashed_password, $role]);

            $message = "Regjistrimi u krye me sukses. Tani mund të bëni login.";
        }
    } else {
        $message = "Ju lutem plotësoni të gjitha fushat.";
        $is_error = true;
    }
}
?>

<?php include 'includes/header.php'; ?>

<section class="auth-section">
    <div class="auth-wrapper">
        <div class="auth-side">
            <span class="badge">Create Account</span>
            <h1>Regjistrohu dhe fillo eksperiencën tënde në E-Learning</h1>
            <p>
                Krijo llogarinë tënde si student ose instruktor dhe përdor
                një sistem modern për menaxhimin e kurseve online.
            </p>
            <ul>
                <li>Regjistrim i shpejtë dhe i thjeshtë</li>
                <li>Akses në kurse dhe materiale</li>
                <li>Panel profesional sipas rolit</li>
                <li>Eksperiencë moderne përdorimi</li>
            </ul>
        </div>

        <div class="auth-card">
            <h2>Register</h2>
            <p>Krijo llogarinë tënde për të filluar.</p>

            <?php if($message): ?>
                <div class="<?= $is_error ? 'error-box' : 'message-box' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="form-box">
                <form method="POST">
                    <input type="text" name="full_name" placeholder="Emri i plotë" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>

                    <select name="role" required>
                        <option value="">Zgjidh rolin</option>
                        <option value="student">Student</option>
                        <option value="instructor">Instruktor</option>
                    </select>

                    <button type="submit">Krijo llogari</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>