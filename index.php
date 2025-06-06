<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Αρχική Σελίδα - E-Shop</title>
</head>
<body>
    <h1>Καλώς ήρθατε στο E-Shop μας!</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Γεια σου, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <?php else: ?>
        <p><a href="signup.php">Εγγραφή</a> | <a href="login.php">Σύνδεση</a></p>
    <?php endif; ?>

    <h2>Προϊόντα</h2>
    <ul>
    <?php
    $conn = new mysqli("localhost", "root", "", "eshop");
    if ($conn->connect_error) {
        die("Σφάλμα σύνδεσης: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM products");
    while ($row = $result->fetch_assoc()):
    ?>
        <li>
            <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
            <?php echo htmlspecialchars($row['description']); ?><br>
            Τιμή: €<?php echo number_format($row['price'], 2); ?><br>
            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <input type="submit" value="Προσθήκη στο Καλάθι">
            </form>
        </li>
    <?php endwhile;
    $conn->close();
    ?>
    </ul>
</body>
</html>
