<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $_SESSION['cart'][] = $productId;
}

$conn = new mysqli("localhost", "root", "", "eshop");
if ($conn->connect_error) {
    die("Σφάλμα σύνδεσης: " . $conn->connect_error);
}

$items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', $_SESSION['cart']));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
        $total += $row['price'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Καλάθι Αγορών</title>
</head>
<body>
    <h1>Το Καλάθι σας</h1>
    <?php if (empty($items)): ?>
        <p>Το καλάθι είναι άδειο.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Όνομα</th>
                <th>Περιγραφή</th>
                <th>Τιμή (€)</th>
            </tr>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2"><strong>Σύνολο</strong></td>
                <td><strong>€<?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </table>
    <?php endif; ?>
    <br>
    <a href="index.php">⬅ Επιστροφή στο κατάστημα</a>
</body>
</html>
<?php $conn->close(); ?>
