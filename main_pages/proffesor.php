<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proffesor main page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<p class="msg_notification">Welcome <?php ob_start(); session_start(); ob_clean(); echo $_SESSION["first_name"]." ".$_SESSION["last_name"] ?> (Викладач)</p>
    <div class="main_panel">
        <div class="panel_container">
            <a href="../sub_pages/journal_view/select_subject.php" class="panel_btn orange">Перегляд журналу</a>
            <a href="../sub_pages/ANR/anr.php" class="panel_btn asphalt">АНР</a>
            <a href="../sub_pages/accounting_subject/accounting.php" class="panel_btn blue">Розрахунок обрання предмету за вибором</a>
            <a href="" class="panel_btn turq">Перегляд силабусів дисциплін</a>
        </div>
        <div class="panel_container">
            <a href="" class="panel_btn violet">Перегляд програми спеціальності</a>
            <a href="https://dl.tntu.edu.ua/login.php?lang=uk" class="panel_btn yellow">Перехід у Atutor</a>
            <a href="../index.php" class="panel_btn red">Вихід</a>
        </div>
    </div>
</body>
</html>