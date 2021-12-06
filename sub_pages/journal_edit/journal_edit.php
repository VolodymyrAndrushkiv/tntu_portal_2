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
    <title>Редагування журналу</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="back">Назад</a>
    <a href="../../main_pages/<?php echo $_SESSION["role"] ?>.php" class="to_main">На головну</a>
    <p class="msg_notification">Оберіть предмет</p>
    <div class="edit_panel">
        <div class="edit_journal_select_item">
            <p>Додати предмет</p>
            <a href="" id="add_btn">Додати</a>
        </div>
        <form action="" method="post" id="add_form" class="hidden">
                <input required type="text" class="enter_journal" placeholder="Введіть назву предмету" name="subject_name">
                <button id="chooseComp">Вибрати компетенції</button>
                <select class='compSelect hidden' multiple size="10" name="subject_comp[]" id="">
                    <?php showCompOptions(); ?>
                </select>
                <input type="submit" value="Додати" id="subm_journal" name="subm_journal">
        </form>

        <div class="edit_journal_delete_item">
            <p>Видалити предмет</p>
            <a href="" id="add_btn_delete">Видалити</a>
        </div>
        <form action="" method="post" id="add_form_delete" class="hidden">
                <select name="subject_delete">
                    <?php displayOptionsDel($connection); ?>
                </select>
                <input type="submit" id="subm_journal" name="subm_journal_del">
        </form>
        <?php showAllSubjects($connection); ?>
    </div>
    <?php addSubject($connection); delSubject($connection); ?>
    <script src="script.js"></script>
</body>
</html>