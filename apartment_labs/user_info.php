<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Інформація про користувача</title>
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
    <h1>Інформація про користувача</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Прізвище</th>
            <th>Електронна пошта</th>
        </tr>
        <?php
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            $sql = "SELECT * FROM users WHERE id = $user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["firstname"] . "</td>";
                    echo "<td>" . $row["lastname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Користувача не знайдено</td></tr>";
            }
            $conn->close();
        } else {
            echo "<tr><td colspan='6'>Користувача не вказано</td></tr>";
        }
        ?>
    </table><br>

    <a href='display_apartments.php'>Повернутися на сторінку оголошень</a>
</body>

</html>