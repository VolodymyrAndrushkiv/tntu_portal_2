<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor main page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<p class="msg_notification">Welcome <?php ob_start(); session_start(); ob_clean(); echo $_SESSION["first_name"]." ".$_SESSION["last_name"] ?> (Інструктор)</p>
    <div class="main_panel">
        <div class="panel_container">
            <a href="" class="panel_btn orange">Перегляд журналу</a>
            <a href="" class="panel_btn green">Редагування журналу</a>
            <a href="" class="panel_btn asphalt">Перегляд силабусів дисциплін</a>
            <a href="" class="panel_btn grey">Розрахунок вартості навчання</a>
        </div>
        <div class="panel_container">
            <a href="" class="panel_btn blue">Розрахунок обрання предмету за вибором</a>
            <a href="" class="panel_btn violet">Перегляд програми спеціальності</a>
            <a href="../index.php" class="panel_btn red">Вихід</a>
        </div>
    </div>
</body>
</html>