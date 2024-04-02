<?php
include 'db_connect.php';

$message = "";
$apartment_id = isset($_GET['id']) ? $_GET['id'] : "";

if ($apartment_id) {
    $stmt = $conn->prepare("SELECT * FROM apartments WHERE id = ?");
    $stmt->bind_param("i", $apartment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $apartment = $result->fetch_assoc();
    } else {
        $message = "Оголошення не знайдено";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $address = $_POST['address'];
    $rooms = $_POST['rooms'];
    $price = $_POST['price'];
    $user_id = $_POST['user_id'];
    $apartment_id = $_POST['apartment_id'];

    $sql = "UPDATE apartments SET type = ?, address = ?, rooms = ?, price = ?, user_id = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiii", $type, $address, $rooms, $price, $user_id, $apartment_id);

    if ($stmt->execute()) {
        $message = "Оголошення успішно оновлено";
    } else {
        $message = "Помилка оновлення: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Оновити оголошення</title>
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
    <h1>Оновити оголошення</h1>

    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (isset($apartment)) : ?>
        <form action="update_apartment.php" method="post">
            <input type="hidden" name="apartment_id" value="<?php echo $apartment_id; ?>">
            <p>
                <label for="type">Тип:</label>
                <select name="type" id="type" required>
                    <option value="здача" <?php if ($apartment['type'] == 'здача') echo 'selected'; ?>>Здача</option>
                    <option value="оренда" <?php if ($apartment['type'] == 'оренда') echo 'selected'; ?>>Оренда</option>
                    <option value="продаж" <?php if ($apartment['type'] == 'продаж') echo 'selected'; ?>>Продаж</option>
                    <option value="купівля" <?php if ($apartment['type'] == 'купівля') echo 'selected'; ?>>Купівля</option>
                </select>
            </p>
            <p>
                <label for="address">Адреса:</label>
                <input type="text" name="address" id="address" required value="<?php echo $apartment['address']; ?>">
            </p>
            <p>
                <label for="rooms">Кількість кімнат:</label>
                <input type="number" name="rooms" id="rooms" required value="<?php echo $apartment['rooms']; ?>">
            </p>
            <p>
                <label for="price">Ціна:</label>
                <input type="number" name="price" id="price" required value="<?php echo $apartment['price']; ?>">
            </p>
            <p>
                <label for="user_id">ID користувача:</label>
                <input type="number" name="user_id" id="user_id" required value="<?php echo $apartment['user_id']; ?>">
            </p>
            <p>
                <input type="submit" value="Оновити">
            </p>
        </form>
    <?php endif; ?>

    <a href='display_apartments.php'>Повернутися на сторінку оголошень</a>
</body>

</html>