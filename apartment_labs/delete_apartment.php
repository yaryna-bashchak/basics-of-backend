<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $apartment_id = $_POST['apartment_id'];

    $sql = "DELETE FROM apartments WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $apartment_id);

    if ($stmt->execute()) {
        $message = "Оголошення успішно видалено";
    } else {
        $message = "Помилка видалення: " . $conn->error;
    }

    $stmt->close();
}

$sql = "SELECT * FROM apartments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Видалити оголошення</title>
    <style>
        body * {
            font-size: 16px;
        }

        h1 {
            font-size: 24px;
        }
        
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        table {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Видалити оголошення</h1>

    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Тип</th>
                <th>Адреса</th>
                <th>Кількість кімнат</th>
                <th>Ціна</th>
                <th>Дія</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["rooms"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>
                        <form action='delete_apartment.php' method='post'>
                            <input type='hidden' name='apartment_id' value='" . $row["id"] . "'>
                            <input type='submit' value='Видалити'>
                        </form>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php else : ?>
        <p>Оголошень немає</p>
    <?php endif; ?>

    <a href='display_apartments.php'>Повернутися на сторінку оголошень</a>

    <?php
    $conn->close();
    ?>
</body>

</html>