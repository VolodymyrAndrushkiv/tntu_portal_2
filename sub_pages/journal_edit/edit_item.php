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
    <p class="msg_notification"><?php echo $_GET['sub'];?></p>
    <!-- <div class="edit_panel">
        <p>Додати завдання</p>
        <form action="" method="post">
            <input type="text" placeholder="Перевіряючий" class="enter" name="reviewer_edit">
            <input type="text" placeholder="Студент" class="enter" name="student_edit">
            <input type="text" placeholder="Тема завдання" class="enter" name="task_name_edit">
            <input type="text" placeholder="Завдання" class="enter" name="task_edit">
            <input type="submit" name="subm_edit">
        </form>
    </div> -->

    <div class="edit_panel">
        <div class="edit_journal_select_item">
            <p>Додати завдання</p>
            <a href="" id="add_btn_add_ask">Додати</a>
        </div>
        <form action="" method="post" id="add_form_add_task" class="hidden">
            <p>Додати завдання</p>
            <input type="text" placeholder="Перевіряючий" class="enter" name="reviewer_edit">
            <input type="text" placeholder="Студент" class="enter" name="student_edit">
            <input type="text" placeholder="Назва завдання" class="enter" name="task_name_edit">
            <input type="text" placeholder="Завдання" class="enter" name="task_edit">
            <input type="submit" name="subm_edit">
        </form>

        <div class="edit_journal_select_item">
            <p>Редагувати завдання</p>
            <a href="" id="add_btn_edit_task">Редагувати</a>
        </div>
        <form action="" method="post" id="add_form_edit_task" class="hidden">
            <p>Виберіть завдання яке потрібно редагувати:</p>
            <select name="select_edit_task" id="">
                <?php displayOptions(); ?>
            </select>
            <input type="text" placeholder="Перевіряючий" class="enter" name="reviewer_edit_task">
            <input type="text" placeholder="Студент" class="enter" name="student_edit_task">
            <input type="text" placeholder="Назва завдання" class="enter" name="task_name_edit_task">
            <input type="text" placeholder="Завдання" class="enter" name="task_edit_task">
            <input type="submit" name="subm_edit_task">
        </form>
        <?php showTasks(); ?>
    </div>


    <?php editJournal(); editTask();?>
    
    <script src="edit_script.js"></script>
</body>
</html>