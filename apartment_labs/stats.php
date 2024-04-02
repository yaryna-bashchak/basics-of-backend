<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Статистика оголошень та користувачів</title>
    <style>
        body {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <h1>Статистика</h1>

    <?php
    $sql_ads = "SELECT COUNT(*) as total_ads FROM apartments";
    $result_ads = $conn->query($sql_ads);
    $ads_count = $result_ads->fetch_assoc();

    $sql_users = "SELECT COUNT(*) as total_users FROM users";
    $result_users = $conn->query($sql_users);
    $users_count = $result_users->fetch_assoc();

    $sql_ads_last_month = "SELECT COUNT(*) as ads_last_month FROM apartments WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    $result_ads_last_month = $conn->query($sql_ads_last_month);
    $ads_last_month_count = $result_ads_last_month->fetch_assoc();

    $sql_users_last_month = "SELECT COUNT(*) as users_last_month FROM users WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    $result_users_last_month = $conn->query($sql_users_last_month);
    $users_last_month_count = $result_users_last_month->fetch_assoc();

    $sql_latest_ad = "SELECT * FROM apartments ORDER BY created_at DESC LIMIT 1";
    $result_latest_ad = $conn->query($sql_latest_ad);
    $latest_ad = $result_latest_ad->fetch_assoc();

    $sql_top_user = "SELECT u.id, u.firstname, COUNT(a.user_id) as ad_count 
                     FROM apartments a 
                     JOIN users u ON a.user_id = u.id 
                     GROUP BY a.user_id 
                     ORDER BY ad_count DESC 
                     LIMIT 1";
    $result_top_user = $conn->query($sql_top_user);
    $top_user = $result_top_user->fetch_assoc();
    ?>

    <p>Загальна кількість оголошень - <?php echo $ads_count['total_ads']; ?></p>
    <p>Загальна кількість користувачів - <?php echo $users_count['total_users']; ?></p>
    <p>Оголошень створено за останній місяць - <?php echo $ads_last_month_count['ads_last_month']; ?></p>
    <p>Користувачів зареєстровано за останній місяць - <?php echo $users_last_month_count['users_last_month']; ?></p>
    <p>Останнє оголошення: <a href='display_apartments.php?id=<?php echo $latest_ad['id']; ?>'><?php echo $latest_ad['id']; ?></a></p>
    <p>Користувач з найбільшою кількістю оголошень - <?php echo $top_user['ad_count']; ?> шт. <a href='user_info.php?user_id=<?php echo $top_user['id']; ?>'><?php echo $top_user['firstname']; ?></a></p>

    <a href='display_apartments.php'>Повернутися на сторінку оголошень</a>

    <?php
    $conn->close();
    ?>
</body>

</html>