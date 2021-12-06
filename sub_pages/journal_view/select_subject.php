<?php 
ob_start();
include "../../functions.php";
ob_clean();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд журналу</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <p class="msg_notification">Оберіть предмет</p>
    <div class="edit_panel">
        <?php showAllSubjectsView($connection); ?>
    </div>
    <script src="script.js"></script>
</body>
</html>