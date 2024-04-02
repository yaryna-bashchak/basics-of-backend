<?php include 'db_connect.php'; ?>

<?php
$sql = "CREATE TABLE apartments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type VARCHAR(50),
    address VARCHAR(255),
    rooms INT,
    date_posted DATE,
    price DECIMAL(10, 2)
)";

if ($conn->query($sql) === TRUE) {
    echo "Таблиця 'apartments' успішно створена";
} else {
    echo "Помилка при створенні таблиці: " . $conn->error;
}

$conn->close();
?>
