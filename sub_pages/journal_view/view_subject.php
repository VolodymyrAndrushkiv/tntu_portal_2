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
    <title>Редагування предмету</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <a href="select_subject.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <p class="msg_notification"><?php echo $_GET['sub'];?></p>

    <div class="opt_main_block">

        <?php showJournal($connection) ?>
    </div>
</body>
</html>