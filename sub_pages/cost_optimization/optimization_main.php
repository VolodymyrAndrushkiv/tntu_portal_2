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
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <div id="sub_counter" class="grey">
        Вибрано предметів: 0/9
    </div>
    <p class="msg_notification">Оптимізація вартості навчання</p>
    <div class="edit_panel">
        <form action="" method="post" id="optimization_form_select">
            <?php showSubjectsToSelect(); ?>
            <input disabled type="submit" class="enter_opt" name="opt_form_done" value="Вибрати">
        </form>
    </div>
    <?php moveSubjects(); ?>
    
    <script src="optimization_script.js"></script>
</body>
</html>