<?php
include 'db_connect.php';

$message = "";
$showForm = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $address = $_POST['address'];
    $rooms = $_POST['rooms'];
    $price = $_POST['price'];
    $user_id = $_POST['user_id'];

    $sql = "INSERT INTO apartments (type, address, rooms, price, user_id) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $type, $address, $rooms, $price, $user_id);

    if ($stmt->execute()) {
        $message = "Нове оголошення успішно додано";
        $showForm = false;
    } else {
        $message = "Помилка: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Додати оголошення</title>
    <style>
        body * {
            font-size: 16px;
        }

        h1 {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <h1>Додати нове оголошення</h1>

    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($showForm) : ?>
        <form action="add_apartment.php" method="post">
            <p>
                <label for="type">Тип:</label>
                <select name="type" id="type" required>
                    <option value="здача">Здача</option>
                    <option value="оренда">Оренда</option>
                    <option value="продаж">Продаж</option>
                    <option value="купівля">Купівля</option>
                </select>
            </p>
            <p>
                <label for="address">Адреса:</label>
                <input type="text" name="address" id="address" required>
            </p>
            <p>
                <label for="rooms">Кількість кімнат:</label>
                <input type="number" name="rooms" id="rooms" required>
            </p>
            <p>
                <label for="price">Ціна:</label>
                <input type="number" name="price" id="price" required>
            </p>
            <p>
                <label for="user_id">ID користувача:</label>
                <input type="number" name="user_id" id="user_id" required>
            </p>
            <p>
                <input type="submit" value="Додати">
            </p>
        </form>
    <?php endif; ?>

    <a href='display_apartments.php'>Повернутися на сторінку оголошень</a>
</body>

</html>