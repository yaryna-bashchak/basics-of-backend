<?php include 'db_connect.php'; ?>

<?php
$sql = "INSERT INTO Users (firstname, lastname, email)
VALUES ('Yaryna', 'Bashchak', 'yaryna@gmail.com')";

if ($conn->query($sql) === TRUE) {
    echo "Новий запис успішно створено";
} else {
    echo "Помилка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
