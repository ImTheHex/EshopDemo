<?php
session_start();
$conn = new mysqli("localhost", "root", "", "eshop");
if ($conn->connect_error) {
    die("Σφάλμα σύνδεσης: " . $conn->connect_error);
}
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    }
}
echo "Λανθασμένα στοιχεία σύνδεσης.";
?>
