<?php include 'db_connect.php';

$order = '';
$filter = '';

if (isset($_GET['order']) && in_array(strtolower($_GET['order']), ['asc', 'desc'])) {
    $order = 'ORDER BY created_at ' . strtoupper($_GET['order']);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $address = isset($_GET['address']) ? $_GET['address'] : '';
    $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
    $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

    $conditions = [];
    if (!empty($id)) $conditions[] = "id = '$id'";
    if (!empty($type)) $conditions[] = "type = '$type'";
    if (!empty($address)) $conditions[] = "address LIKE '%$address%'";
    if (!empty($startDate)) $conditions[] = "created_at >= '$startDate'";
    if (!empty($endDate)) $conditions[] = "created_at <= '$endDate'";

    if (count($conditions) > 0) {
        $filter = "WHERE " . implode(' AND ', $conditions);
    }
}

$sortingParams = http_build_query([
    'id' => $id,
    'type' => $type,
    'address' => $address,
    'startDate' => $startDate,
    'endDate' => $endDate
]);

$asc_url = "display_apartments.php?order=asc&" . $sortingParams;
$desc_url = "display_apartments.php?order=desc&" . $sortingParams;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Оголошення про квартири</title>
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
    </style>
</head>

<body>
    <h1>Список оголошень</h1>
    <form action="display_apartments.php" method="get">
        ID: <input type="text" name="id" value="<?php echo $id; ?>">
        Тип:
        <select name="type">
            <option value=""></option>
            <option value="здача" <?php echo $type == 'здача' ? 'selected' : ''; ?>>Здача</option>
            <option value="оренда" <?php echo $type == 'оренда' ? 'selected' : ''; ?>>Оренда</option>
            <option value="продаж" <?php echo $type == 'продаж' ? 'selected' : ''; ?>>Продаж</option>
            <option value="купівля" <?php echo $type == 'купівля' ? 'selected' : ''; ?>>Купівля</option>
        </select>
        Адреса: <input type="text" name="address" value="<?php echo $address; ?>"><br><br>
        Дата початку: <input type="date" name="startDate" value="<?php echo $startDate; ?>">
        Дата закінчення: <input type="date" name="endDate" value="<?php echo $endDate; ?>"><br><br>
        <input type="submit" value="Знайти">
        <a href="display_apartments.php"><button type="button">Скинути фільтри</button></a>
    </form>
    <p>
        <button>
            <a href="add_apartment.php">Додати нове оголошення</a>
        </button>
        <button>
            <a href="delete_apartment.php">Видалити деякі оголошенні</a>
        </button>
        <button>
            <a href="<?php echo $asc_url; ?>">Сортувати за датою (за зростанням)</a>
        </button>
        <button>
            <a href="<?php echo $desc_url; ?>">Сортувати за датою (за спаданням)</a>
        </button>
    </p>
    <table>
        <tr>
            <th>ID</th>
            <th>Тип</th>
            <th>Адреса</th>
            <th>Кількість кімнат</th>
            <th>Дата</th>
            <th>Ціна</th>
            <th>Користувач</th>
            <th>Дії</th>
        </tr>
        <?php
        $sql = "SELECT * FROM apartments $filter $order";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["rooms"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td><a href='user_info.php?user_id=" . $row["user_id"] . "'>" . $row["user_id"] . "</a></td>";
                echo "<td><a href='update_apartment.php?id=" . $row["id"] . "'>Оновити</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Наразі немає оголошень, що відповідають заданим критеріям</td></tr>";
        }
        $conn->close();
        ?>
    </table><br>

    <a href='stats.php'>Переглянути статистику</a>
</body>

</html>