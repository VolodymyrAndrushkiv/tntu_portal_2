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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оптимізація вартості навчання</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <a href="optimization_main.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <p class="msg_notification">Оптимізація вартості навчання</p>
    <div class="opt_main_block">
        <form action="" method="post">
            
            <?php 
                showTable($_SESSION["selected_sub"]);
                showFormTable($_SESSION["selected_sub"]);
            ?>

            <br><br>
            <input type="submit" class="enter_opt_table" name="opt_form_table_done" value="Готово">


            



        </form>

        <?php getElementsFromTable($_SESSION["selected_sub"]); ?>
        
    </div>
    <script src="optimization_table_script.js"></script>
</body>
</html>