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
    <p class="msg_notification">Оптимізація вартості навчання</p>
    <div class="edit_panel">
        <h3>Вибрані компетенції:</h1>
        <?php showStudentComp($connection); ?>
        <br><br>
        
        <div class="studentCompsBtns">
            <button id="comp_add" class="editStudentComps">Додати компетенцію</button>
            <button id="comp_remove" class="editStudentComps">Видалити компетенцію</button>
        </div>
        <br><br>
        <form action="" method="post" id="add_comp_select" class="hidden">
            <?php showSubjectsToSelect(); ?>
            <input type="submit" class="enter_comp" name="add_comp_done" value="Вибрати">
        </form>
        <form action="" method="post" id="remove_comp_select" class="hidden">
            <?php displayRemoveCompForm($connection) ?>
            
        </form>
        <?php addStudentComp($connection); removeStudentComp($connection); ?>
    </div>
    
    <script src="student_comp_script.js"></script>
</body>
</html>