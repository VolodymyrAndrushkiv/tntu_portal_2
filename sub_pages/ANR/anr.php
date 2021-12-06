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
    <title>АНР</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<p class="msg_notification">АНР</p>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <div class="opt_main_block">
        <form action="" name="anr_form" class="anr_form" method="post">
            <label for="matrix_size">Введіть розмір матриці:</label>
            <input required id="matrix_size" min="2" name="size" type="number" placeholder="Розмір матриці">
            <input type="submit" name="anr_btn" value="Створити матрицю">
        </form>
        <div class="table_block">
            <form class="anr_form2" action="" method="post">
                <?php createTableANR(); ?>
            </form>
        </div>
        <?php anr(); ?>
    </div>
</body>
</html>