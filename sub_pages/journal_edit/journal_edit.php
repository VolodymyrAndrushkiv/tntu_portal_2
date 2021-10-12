<?php 
ob_start();
include "../../functions.php";
ob_clean();
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
    <p class="msg_notification">Оберіть предмет</p>
    <div class="edit_panel">
        <div class="edit_journal_select_item">
            <p>Додати предмет</p>
            <a href="" id="add_btn">Додати</a>
        </div>
        <form action="" method="post" id="add_form" class="hidden">
                <input required type="text" class="enter_journal" placeholder="Введіть назву предмету" name="subject_name">
                <input type="submit" id="subm_journal" name="subm_journal">
        </form>
        <!-- <div class="edit_journal_select_item">
            <p>Штучний інтелект</p>
            <a href="">Переглянути</a>
        </div>
        <div class="edit_journal_select_item">
            <p>Криптологія</p>
            <a href="">Переглянути</a>
        </div>
        <div class="edit_journal_select_item">
            <p>Програмування</p>
            <a href="">Переглянути</a>
        </div> -->
        <?php showAllSubjects($connection); ?>
    </div>
    <?php addSubject($connection); ?>
    <script src="script.js"></script>
</body>
</html>