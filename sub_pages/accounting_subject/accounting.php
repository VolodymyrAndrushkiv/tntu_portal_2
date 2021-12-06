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
    <title>Розрахунок обрання предмету за вибором</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<p class="msg_notification">Розрахунок обрання предмету за вибором</p>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <div class="edit_panel">
        <div class="table_block">
            <h3>Виберіть предмети для розрахунку</h3>
            <form name="accounting_form" action="" method="post">
                <?php showTableAccounting($connection); ?>
            </form>
        </div>
        <?php accountingResult(); ?>
    </div>

    <script src="acounting.js"></script>
</body>
</html>