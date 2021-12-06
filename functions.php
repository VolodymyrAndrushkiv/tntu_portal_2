<?php

    // Connection to DB
    $servername = "localhost";
    $username = "root";
    $password = "";

    $connection = mysqli_connect($servername, $username, $password, "tntu_site");

    if (!$connection){
        die("Connection failed: ".mysqli_connect_error());
    }

    // All functions:

    function registration($conn) {
        if (isset($_POST["reg_subm"])){
            $login = $_POST["login"];
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $pass = $_POST["pass"];
            $role = $_POST["role"];

            if (strlen($login) < 4){
                echo "<p class='msg_error'>Логін має бути 4+ букви</p>";
            }
            elseif (strlen($first_name) < 2){
                echo "<p class='msg_error'>Занадто коротке ім'я</p>";
            }
            elseif (strlen($last_name) < 2){
                echo "<p class='msg_error'>Занадто коротке прізвище</p>";
            }
            elseif (strlen($pass) < 8){
                echo "<p class='msg_error'>Пароль має бути не менше 8 символів</p>";
            }
            else {
                $query = "SELECT login FROM users_data WHERE login = '$login'";
                $test_login = mysqli_query($conn, $query);
                $login_exist = mysqli_fetch_array($test_login);
                if (!$login_exist){
                        $query = "INSERT INTO users_data (login, first_name, last_name, password, role) VALUES ('$login', '$first_name', '$last_name', '$pass', '$role')";
                        mysqli_query($conn, $query);
                        echo "<p class='msg_success'>Реєстрація успішна</p>";
                }
                else {
                    echo "<p class='msg_error'>Такий логін існує</p>";
                }
            }
        }
    }

    function login($conn) {
        if (isset($_POST["subm_log"])){
            // ob_start();
            session_start();
            // ob_clean();
            $login = $_POST["login_log"];
            $pass = $_POST["password_log"];

            $query = "SELECT * FROM users_data WHERE login = '$login'";
            $query_result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($query_result);

            if ($login == $data['login'] && $pass == $data['password']){
                if ($data['role'] == 'student'){
                    $_SESSION["login"] = $login;
                    $_SESSION["role"] = $data['role'];
                    $_SESSION["first_name"] = $data['first_name'];
                    $_SESSION["last_name"] = $data['last_name'];
                    // echo "<p class='msg_success'>Student</p>";
                    header("Location: main_pages/student.php");
                    exit;
                }
                elseif ($data['role'] == 'proffesor'){
                    $_SESSION["login"] = $login;
                    $_SESSION["role"] = $data['role'];
                    $_SESSION["first_name"] = $data['first_name'];
                    $_SESSION["last_name"] = $data['last_name'];
                    // echo "<p class='msg_success'>Proffesor</p>";
                    header("Location: main_pages/proffesor.php");
                    exit;
                }
                elseif ($data['role'] == 'instructor'){
                    $_SESSION["login"] = $login;
                    $_SESSION["role"] = $data['role'];
                    $_SESSION["first_name"] = $data['first_name'];
                    $_SESSION["last_name"] = $data['last_name'];
                    header("Location: main_pages/instructor.php");
                    exit;
                }
            }
            else {
                echo "<p class='msg_error'>Неправильний логін або пароль</p>";
                session_abort();
            }

        }
    }

    function displayAddCompBtn() {
        echo "<a href='student_comp/add_student_comp.php' class='add_comp_btn'>Додати компетенції</a>";
    }

    function showStudentComp($conn) {
        $login = $_SESSION["login"];
        $query = "SELECT comp from users_data WHERE login = '$login'";
        $mysqli_result = mysqli_query($conn, $query);

        $comps = explode("|", mysqli_fetch_assoc($mysqli_result)["comp"]);
        if ($comps[0] != ""){
            foreach($comps as $i){
                echo $i."<br><br>";
            }
        }
        else {
            echo "Не вибрано жодної компетенції";
        }
        
        
    }

    function displayRemoveCompForm($conn) {
        $login = $_SESSION["login"];
        $query = "SELECT comp from users_data WHERE login = '$login'";
        $mysqli_result = mysqli_query($conn, $query);

        $comps = explode("|", mysqli_fetch_assoc($mysqli_result)["comp"]);
        for($i = 0; $i < count($comps); $i++){
            $comps[$i] .= "_1";
        }

        if ($comps[0] != "_1"){
            for ($i = 0; $i < count($comps); $i++){
                echo '<div class="optimization_select_item">';
                echo '<label class="label_select" for="'.$comps[$i].'">'.substr($comps[$i], 0, -2).'</label>';
                echo '<input type="checkbox" name="'.$comps[$i].'" value="'.$comps[$i].'" id="'.$comps[$i].'">';
                echo '</div>';
            }
            echo '<input type="submit" class="enter_comp" name="remove_comp_done" value="Вибрати">';
        }
    }

    function addStudentComp($conn){
        if (isset($_POST["add_comp_done"])){
            $compToAdd = array();
            foreach ($_POST as $key => $value){
                array_push($compToAdd, $value);
            }
            array_pop($compToAdd);

            $login = $_SESSION["login"];
            $query = "SELECT comp from users_data WHERE login = '$login'";
            $mysqli_result = mysqli_query($conn, $query);
            $comps = explode("|", mysqli_fetch_assoc($mysqli_result)["comp"]);

            // echo "<br>";
            // print_r($comps);
            $comps_new = array();
            for ($i = 0; $i < count($compToAdd); $i++){
                if (in_array($compToAdd[$i], $comps)){
                    continue;
                }
                else {
                    array_push($comps, $compToAdd[$i]);
                }
            }
            // echo "<br>";
            // print_r($comps);
            if ($comps[0] == "") {
                array_shift($comps);
            }
            
            sort($comps);
            $new_comp = implode("|", $comps);
            // echo "<br>";
            // echo $new_comp;
            $query = "UPDATE users_data SET comp = '$new_comp' WHERE login = '$login';";
            mysqli_query($conn, $query);
            header("Location: add_student_comp.php");
        }
    }

    function removeStudentComp($conn){
        if (isset($_POST["remove_comp_done"])){
            $compToRemove = array();
            foreach ($_POST as $key => $value){
                array_push($compToRemove, $value);
            }
            array_pop($compToRemove);
            
            for ($i = 0; $i < count($compToRemove); $i++){
                $compToRemove[$i] = substr($compToRemove[$i], 0, -2);
            }
            print_r($compToRemove);

            $login = $_SESSION["login"];
            $query = "SELECT comp from users_data WHERE login = '$login'";
            $mysqli_result = mysqli_query($conn, $query);
            $comps = explode("|", mysqli_fetch_assoc($mysqli_result)["comp"]);

            echo "<br>";
            print_r($comps);
            $comps_new = array();
            for ($i = 0; $i < count($compToRemove); $i++){
                if (in_array($compToRemove[$i], $comps)){
                    $ind = array_search($compToRemove[$i], $comps);
                    unset($comps[$ind]);
                }
            }

            sort($comps);

            echo "<br><br>";
            print_r($comps);
            $new_comp = implode("|", $comps);
            echo "<br>";
            echo $new_comp;

            $query = "UPDATE users_data SET comp = '$new_comp' WHERE login = '$login';";
            mysqli_query($conn, $query);
            header("Location: add_student_comp.php");
        }
    }

    function addSubject($conn) {
        if (isset($_POST["subm_journal"])){
            $subject_name = $_POST["subject_name"];
            $comp = $_POST["subject_comp"];
            $new_comp = implode("|", $comp);
            $query = "SELECT subject from subjects WHERE subject = '$subject_name'";
            $mysqli_result = mysqli_query($conn, $query);
            if (count(mysqli_fetch_assoc($mysqli_result)) > 0) {
                echo "<p class='msg_error'>Такий предмет вже існує</p>";
            }
            else {
                if (strlen($subject_name) < 2 ) {
                    echo "<p class='msg_error'>Назва предмету має бути 3+ символів</p>";
                }
                else {
                    $query = "INSERT INTO subjects (subject, comp) VALUES ('$subject_name', '$new_comp')";
                    mysqli_query($conn, $query);

                    $data = array('Subject' => $subject_name);
                    $f = fopen("../journal_data/".$subject_name.".json", "w");
                    fwrite($f, json_encode($data, JSON_UNESCAPED_UNICODE));
                    fclose($f);

                    header("Location: journal_edit.php");
                }
            }
        }
    }

    function showCompOptions(){
        $arr = array("ЗК 1. Здатність застосовувати знання у практичних ситуаціях.", 
        "ЗК 2. Знання та розуміння предметної області та розуміння професії.", 
        "ЗК 3. Здатність професійно спілкуватися державною та іноземною мовами як усно, так і письмово", 
        "ЗК 4. Вміння виявляти, ставити та вирішувати проблеми за професійним спрямуванням.", 
        "ЗК 5. Здатність до пошуку, оброблення та аналізу інформації", 
        "ЗК 6. Здатність реалізувати свої права і обов’язки як члена суспільства, усвідомлювати цінності громадянського (вільного демократичного) суспільства та необхідність його сталого розвитку, верховенства права, прав і свобод людини і громадянина в Україні.", 
        "ЗК 7. Здатність зберігати та примножувати моральні, культурні, наукові цінності і досягнення суспільства на основі розуміння історії та закономірностей розвитку предметної області, її місця у загальній системі знань про природу і суспільство та у розвитку суспільства, техніки і технологій, використовувати різні види та форми рухової активності для активного відпочинку та ведення здорового способу життя", 
        "ФК 1. Здатність застосовувати законодавчу та нормативноправову базу, а також державні та міжнародні вимоги, практики і стандарти з метою здійснення професійної діяльності в галузі інформаційної та/або кібербезпеки.", "ФК 2. Здатність до використання інформаційно-комунікаційних технологій, сучасних методів і моделей інформаційної безпеки та/або кібербезпеки.", 
        "ФК 3. Здатність до використання програмних та програмноапаратних комплексів засобів захисту інформації в інформаційнотелекомунікаційних (автоматизованих) системах.", "ФК 4. Здатність забезпечувати неперервність бізнесу згідно встановленої політики інфоормаційної та/або кібербезпеки.", 
        "ФК 5. Здатність забезпечувати захист інформації, що обробляється в інформаційно-телекомунікаційних (автоматизованих) системах з метою реалізації встановленої політики інформаційної та/або кібербезпеки", 
        "ФК 6. Здатність відновлювати штатне функціонування інформаційних, інформаційно-телекомунікаційних (автоматизованих) систем після реалізації загроз, здійснення кібератак, збоїв та відмов різних класів та походження.", 
        "ФК 7. Здатність впроваджувати та забезпечувати функціонування комплексних систем захисту інформації (комплекси нормативноправових, організаційних та технічних засобів і методів, процедур, практичних прийомів та ін.).", 
        "ФК 8. Здатність здійснювати процедури управління інцидентами, проводити розслідування, надавати їм оцінку", 
        "ФК 9. Здатність здійснювати професійну діяльність на основі впровадженої системи управління інформаційною та/або кібербезпекою.", 
        "ФК 10. Здатність застосовувати методи та засоби криптографічного та технічного захисту інформації на об’єктах інформаційної діяльності.", 
        "ФК 11. Здатність виконувати моніторинг процесів функціонування інформаційних, інформаційнотелекомунікаційних (автоматизованих) систем згідно встановленої політики інформаційної та/або кібербезпеки.", 
        "ФК 12. Здатність аналізувати, виявляти та оцінювати можливі загрози, уразливості та дестабілізуючі чинники інформаційному простору та інформаційним ресурсам згідно з встановленою політикою інформаційної та/або кібербезпеки.");
        
        for ($i = 0; $i < count($arr); $i++){
            echo "<option class='compOptions' value='".$arr[$i]."'>".$arr[$i]."</option>";
        }
    }

    function delSubject($conn){
        if (isset($_POST["subm_journal_del"])){
            $to_delete = $_POST["subject_delete"];
            $query = "DELETE FROM subjects WHERE subject = '$to_delete'";
            // echo $query;
            mysqli_query($conn, $query);
            unlink("../journal_data/".$to_delete.".json");
            header("Location: journal_edit.php");
        }
    }

    function displayOptionsDel($conn){
        $query = "SELECT subject FROM subjects";
        $query_result = mysqli_query($conn, $query);
        $subjects_arr = array();
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($subjects_arr, $row);
        }
        // print_r($subjects_arr);
        for ($i = 0; $i < count($subjects_arr); $i++){
            echo "<option value='".$subjects_arr[$i]["subject"]."'>".$subjects_arr[$i]["subject"]."</option>";
        }
    }

    function displayBtnsJounalEdit() {

    }

    function showAllSubjects($conn){
        $query = "SELECT * FROM subjects";
        $query_result = mysqli_query($conn, $query);
        $subject_arr = array();
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($subject_arr, $row);
        }
        for ($i = 0; $i < count($subject_arr); $i++){
            $comp = explode("|", $subject_arr[$i]["comp"]);
            // print_r($comp);
            echo "<div class='edit_journal_select_item'>
            <p style='width: 200px'>".$subject_arr[$i]["subject"]."</p>";

            echo "<div>";
            echo "Компетенції: ";
            for ($j = 0; $j < count($comp); $j++){
                echo "<span style='cursor: pointer;' class='comp_item'>".$comp[$j]."</span>";
            }
            echo "</div>";

            echo "<a href='edit_item.php?sub=".$subject_arr[$i]["subject"]."'>Редагувати</a>
            </div>";
        }
    }

    function showAllSubjectsView($conn){
        $query = "SELECT * FROM subjects";
        $query_result = mysqli_query($conn, $query);
        $subject_arr = array();
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($subject_arr, $row);
        }
        // print_r($subject_arr);
        for ($i = 0; $i < count($subject_arr); $i++){
            $comp = explode("|", $subject_arr[$i]["comp"]);
            echo "<div class='edit_journal_select_item'>
            <p style='width: 200px'>".$subject_arr[$i]["subject"]."</p>";
            echo "<div>";
            echo "Компетенції: ";
            for ($j = 0; $j < count($comp); $j++){
                echo "<span style='cursor: pointer;' class='comp_item'>".$comp[$j]."</span>";
            }
            echo "</div>";
            echo "<a href='view_subject.php?sub=".$subject_arr[$i]["subject"]."'>Переглянути</a>
            </div>";
        }
    }

    function displayEditItem($conn){
        if ($_SESSION["role"] == 'student'){
            echo '
                    <div class="edit_journal_select_item">
                        <p>Додати розв\'язок завдання</p>
                        <a href="" id="add_btn_edit_task">Додати</a>
                    </div>
                    <form action="" method="post" id="add_form_edit_task" class="hidden" enctype="multipart/form-data">
                        <p>Виберіть завдання:</p>
                        <select name="select_done_task" id="">';
            displayOptions();
            echo '      </select>
                        <textarea rows="10" cols="90" name="done_task" class="task_area"></textarea>
                        <input type="file" name="filename">
                        <input type="submit" name="subm_done_task" value="Додати">
                    </form>';
            echo '
                    <div class="edit_journal_select_item">
                        <p>Видалити розв\'язок завдання</p>
                        <a href="" id="add_btn_del_task">Видалити</a>
                    </div>
                    <form action="" method="post" id="add_form_del_task" class="hidden">
                        <p>Виберіть завдання:</p>
                        <select name="select_del_done_task" id="">';
            displayOptions();
            echo '      </select>
                        <input type="submit" name="subm_del_done_task" value="Видалити">
                    </form>';
        }
        elseif ($_SESSION["role"] == 'instructor'){
            echo '<div class="edit_journal_select_item">
                        <p>Додати завдання</p>
                        <a href="" id="add_btn_add_ask">Додати</a>
                    </div>
                    <form action="" method="post" id="add_form_add_task" class="hidden">
                        <p>Додати завдання</p>
                        <input type="text" placeholder="Перевіряючий" class="enter" name="reviewer_edit">
                        <select name="student_edit" id="">
                        ';
            displayOptionsStudents($conn);
            echo '      </select>
                        <input type="text" placeholder="Назва завдання" class="enter" name="task_name_edit">
                        <input type="text" placeholder="Завдання" class="enter" name="task_edit">
                        <input type="submit" name="subm_edit" value="Додати">
                    </form>

                    <div class="edit_journal_select_item">
                        <p>Редагувати завдання</p>
                        <a href="" id="add_btn_edit_task">Редагувати</a>
                    </div>
                    <form action="" method="post" id="add_form_edit_task" class="hidden">
                        <p>Виберіть завдання яке потрібно редагувати:</p>
                        <select name="select_edit_task" id="">';
            displayOptions();
            echo '      </select>
                        <input type="text" placeholder="Перевіряючий" class="enter" name="reviewer_edit_task">
                        <select name="student_edit_task" id="">
                        ';
            displayOptionsStudents($conn);
                        
            echo '      </select>
                        <input type="text" placeholder="Назва завдання" class="enter" name="task_name_edit_task">
                        <input type="text" placeholder="Завдання" class="enter" name="task_edit_task">
                        <input type="submit" name="subm_edit_task" value="Редагувати">
                    </form>

                    <div class="edit_journal_select_item">
                        <p>Видалити завдання</p>
                        <a href="" id="add_btn_delete_task">Видалити</a>
                    </div>
                    <form action="" method="post" id="add_form_delete_task" class="hidden">
                        <p>Виберіть завдання яке потрібно видалити:</p>
                        <select name="select_delete_task" id="">';
            displayOptions();
            echo '      </select>
                        <input type="submit" name="subm_delete_task" value="Видалити">
                    </form>';
            echo '  <div class="edit_journal_to_mark">
                        <p>Поставити оцінку</p>
                        <a href="" id="add_btn_to_rate">Оцінити</a>
                    </div>
                    <form action="" method="post" id="add_form_to_rate" class="hidden">
                        <p>Виберіть завдання яке потрібно оцінити:</p>
                        <select name="select_edit_task" id="">';
            displayOptions();
            echo '      </select>
                        <input required type="number" placeholder="Оцінка" class="enter" name="to_mark_task" min=0 max=100>
                        <input type="submit" name="subm_to_mark" value="Оцінити">
                    </form>
                    <div class="edit_journal_del_mark">
                        <p>Видалити оцінку</p>
                        <a href="" id="add_btn_del_rate">Видалити</a>
                    </div>
                    <form action="" method="post" id="add_form_del_rate" class="hidden">
                        <p>Виберіть завдання з якого необхідно видалити оцінку:</p>
                        <select name="select_edit_task" id="">';
            displayOptions();
            echo '      </select>
                        <input type="submit" name="subm_del_mark" value="Видалити">
                    </form>';
        }
    }

    function addMark(){
        if (isset($_POST["subm_to_mark"])){
            $mark = $_POST["to_mark_task"];
            $task_name = $_POST["select_edit_task"];
            $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);

            for($i = 1; $i < count($data_arr); $i++){
                if ($data_arr["Full_task_".$i]["Task_name"] == $task_name){
                    $data_arr["Full_task_".$i]["Mark"] = $mark;
                }
            }

            fwrite($f, json_encode($data_arr, JSON_UNESCAPED_UNICODE));
            fclose($f);

            $sub = $_GET['sub'];

            header("Location: edit_item.php?sub=".$sub);
        }
    }

    function deleteMark(){
        if (isset($_POST["subm_del_mark"])){
            $task_name = $_POST["select_edit_task"];

            $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);
            // print_r($data_arr);
            for($i = 1; $i < count($data_arr); $i++){
                if ($data_arr["Full_task_".$i]["Task_name"] == $task_name){
                    unset($data_arr["Full_task_".$i]["Mark"]);
                }
            }
            // print_r($data_arr);

            ftruncate($f, 0);
            fwrite($f, json_encode($data_arr, JSON_UNESCAPED_UNICODE));
            fclose($f);
            $sub = $_GET['sub'];

            header("Location: edit_item.php?sub=".$sub);
        }
    }

    function deleteDoneTask(){
        if (isset($_POST["subm_del_done_task"])){
            $done_task = $_POST["select_del_done_task"];
            $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);
            // print_r($data_arr);
            for($i = 1; $i < count($data_arr); $i++){
                if ($data_arr["Full_task_".$i]["Task_name"] == $done_task){
                    unset($data_arr["Full_task_".$i]["Done_task"]);
                }
            }

            ftruncate($f, 0);
            fwrite($f, json_encode($data_arr, JSON_UNESCAPED_UNICODE));
            fclose($f);
            $sub = $_GET['sub'];

            // File part

            $files = scandir("../journal_data/".$sub."_files/".$done_task, 1);
            unlink("../journal_data/".$sub."_files/".$done_task."/".$files[0]);
            rmdir("../journal_data/".$sub."_files/".$done_task);

            // -------------

            header("Location: edit_item.php?sub=".$sub);
        }
    }

    function editJournal(){
        // Додати завдання
        if (isset($_POST["subm_edit"])){
            $reviewer = $_POST["reviewer_edit"];
            $student = $_POST["student_edit"];
            $task_name = $_POST["task_name_edit"];
            $task = $_POST["task_edit"];

            $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);

            for($i = 1; $i < count($data_arr); $i++){
                if ($data_arr["Full_task_".$i]["Task_name"] == $task_name){
                    echo "<p class='msg_error'>Таке завдання вже існує.</p>";
                    return false;
                }
            }

            $data_arr["Full_task_".count($data_arr)] = array("Reviewer" => $reviewer, "Student" => $student, "Task_name" => $task_name, "Task" => $task);

            fwrite($f, json_encode($data_arr, JSON_UNESCAPED_UNICODE));
            fclose($f);
            
            $sub = $_GET['sub'];

            header("Location: edit_item.php?sub=".$sub);

        }
    }

    function showTasks(){
        $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
        $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);

        for ($i = 1; $i < count($data_arr); $i++){
            // echo print_r($data_arr["Full_task_".$i]);
            echo "<div class='task_item'>";
            echo "<p><b>Назва завдання: </b>".$data_arr["Full_task_".$i]["Task_name"]."</p>";
            echo "<p><b>Інструктор: </b>".$data_arr["Full_task_".$i]["Reviewer"]."</p>";
            echo "<p><b>Студент: </b>".$data_arr["Full_task_".$i]["Student"]."</p>";
            echo "<p><b>Завдання: </b>".$data_arr["Full_task_".$i]["Task"]."</p>";
            if ($data_arr["Full_task_".$i]["Done_task"]) {
                echo "<p><b style='color: red;'>Розв'язок завдання:</b> ".$data_arr["Full_task_".$i]["Done_task"]."</p>";
            }

            // file part


            $files = array();
            if (is_dir("../journal_data/".$_GET['sub']."_files/".$data_arr["Full_task_".$i]["Task_name"])){
                $files = scandir("../journal_data/".$_GET['sub']."_files/".$data_arr["Full_task_".$i]["Task_name"], 1);
            }
            if (count($files) > 2) {
                echo "<p><b style='color: green;'>Вкладений файл:</b> ";
                
                echo " <a class='file_download' title='Скачати файл' href='../journal_data/".$_GET['sub']."_files/".$data_arr["Full_task_".$i]["Task_name"]."/".$files[0]."' download>".$files[0]."</a><br>";

                echo "</p>";
            }


            // --------------

            if ($data_arr["Full_task_".$i]["Mark"]) {
                echo "<p><b style='color: red;'>Оцінка: </b>".$data_arr["Full_task_".$i]["Mark"]."</p>";
            }
            echo "</div>";
        }
        fclose($f);

    }

    function displayOptions(){
        $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
        $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);
        // print_r($data_arr);

        for ($i = 1; $i < count($data_arr); $i++){
            echo "<option value='".$data_arr["Full_task_".$i]["Task_name"]."'>".$data_arr["Full_task_".$i]["Task_name"]."</option>";
        }
    }

    function displayOptionsStudents($conn){
        $query = "SELECT first_name, last_name FROM users_data WHERE role='student'";
        $query_result = mysqli_query($conn, $query);
        $students = array();
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($students, $row["first_name"]." ".$row["last_name"]);
        }
        // print_r($students);
        for ($i = 0; $i < count($students); $i++){
            echo '<option value="'.$students[$i].'">'.$students[$i].'</option>';
        }

    }

    function editTask(){
        if (isset($_POST["subm_edit_task"])){
            $task_to_edit = $_POST["select_edit_task"];
            $reviewer = $_POST["reviewer_edit_task"];
            $student = $_POST["student_edit_task"];
            $task_name = $_POST["task_name_edit_task"];
            $task = $_POST["task_edit_task"];

            $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);
            
            
            for ($i = 1; $i < count($data_arr); $i++){
                if ($data_arr["Full_task_".$i]["Task_name"] == $task_to_edit){
                    if (strlen($reviewer) > 0){
                        $data_arr["Full_task_".$i]["Reviewer"] = $reviewer;
                    }
                    if (strlen($student) > 0){
                        $data_arr["Full_task_".$i]["Student"] = $student;
                    }
                    if (strlen($task_name) > 0){
                        $data_arr["Full_task_".$i]["Task_name"] = $task_name;
                    }
                    if (strlen($task) > 0){
                        $data_arr["Full_task_".$i]["Task"] = $task;
                    }
                }
            }
            ftruncate($f, 0);
            fwrite($f, json_encode($data_arr, JSON_UNESCAPED_UNICODE));
            fclose($f);

            $sub = $_GET['sub'];

            header("Location: edit_item.php?sub=".$sub);
        }
    }

    function delTask(){
        if (isset($_POST["subm_delete_task"])){
            $task_to_delete = $_POST["select_delete_task"];         // назва завдання
            $sub = $_GET['sub'];                                    // назва предмету
            
            $f = fopen("../journal_data/".$sub.".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);
            $data_arr_new = array();

            $counter = 1;
            for ($i = 1; $i < count($data_arr); $i++){
                if ($i == 1) {
                    $data_arr_new["Subject"] = $sub;
                }
                if ($data_arr["Full_task_".$i]["Task_name"] == $task_to_delete){
                    continue;
                }
                $data_arr_new["Full_task_".$counter]["Reviewer"] = $data_arr["Full_task_".$i]["Reviewer"];
                $data_arr_new["Full_task_".$counter]["Student"] = $data_arr["Full_task_".$i]["Student"];
                $data_arr_new["Full_task_".$counter]["Task_name"] = $data_arr["Full_task_".$i]["Task_name"];
                $data_arr_new["Full_task_".$counter]["Task"] = $data_arr["Full_task_".$i]["Task"];
                if ($data_arr["Full_task_".$i]["Done_task"]){
                    $data_arr_new["Full_task_".$counter]["Done_task"] = $data_arr["Full_task_".$i]["Done_task"];
                }
                if ($data_arr["Full_task_".$i]["Mark"]){
                    $data_arr_new["Full_task_".$counter]["Mark"] = $data_arr["Full_task_".$i]["Mark"];
                }
                $counter++;
            }
            // print_r($data_arr_new);
            ftruncate($f, 0);
            fwrite($f, json_encode($data_arr_new, JSON_UNESCAPED_UNICODE));
            fclose($f);

            header("Location: edit_item.php?sub=".$sub);
        }
    }

    function addDoneTask(){
        if (isset($_POST["subm_done_task"])){
            $task_name = $_POST["select_done_task"];
            $done_task = $_POST["done_task"];

            $sub = $_GET['sub'];
            $f = fopen("../journal_data/".$sub.".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);

            print_r($data_arr);
            for ($i = 1; $i < count($data_arr); $i++) {
                if ($data_arr["Full_task_".$i]["Task_name"] == $task_name){
                    if (strlen($done_task) > 0){
                        $data_arr["Full_task_".$i]["Done_task"] = $done_task;
                    }
                }
            }

            ftruncate($f, 0);
            fwrite($f, json_encode($data_arr, JSON_UNESCAPED_UNICODE));
            fclose($f);

            // File part

            if (!is_dir("../journal_data/".$_GET['sub']."_files")){
                mkdir("../journal_data/".$_GET['sub']."_files");
            }

            if (!is_dir("../journal_data/".$_GET['sub']."_files/".$task_name)){
                mkdir("../journal_data/".$_GET['sub']."_files/".$task_name);
            }

            if ($_FILES['filename']['size'] > 0){
                foreach(glob("../journal_data/".$_GET['sub']."_files/".$task_name."/*") as $file){
                    if(is_file($file))
                        unlink($file);
                }
                move_uploaded_file($_FILES['filename']['tmp_name'], "../journal_data/".$_GET['sub']."_files/".$task_name."/".$_FILES['filename']['name']);
            }


            // ------------


            header("Location: edit_item.php?sub=".$sub);
        }
    }

    // Перегляд журналу

    function showJournal($conn){
        $query = "SELECT first_name, last_name FROM users_data WHERE role='student'";
        $query_result = mysqli_query($conn, $query);
        $students = array();                                                                        // масив студентів
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($students, $row["first_name"]." ".$row["last_name"]);
        }

        $sub = $_GET['sub'];
        $f = fopen("../journal_data/".$sub.".json", "r+");
        $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);  // масив зі всіма даними про завдання



        
        
        for($i = 0; $i < count($students); $i++){
            $counter = 0;
            echo "<p class='journal_st_name'>".$students[$i].":<br></p>";

            $all_tasks = array();   
            $all_marks = array();   

            for($j = 0; $j < count($data_arr); $j++){
                if ($data_arr["Full_task_".$j]["Task_name"] && $data_arr["Full_task_".$j]["Student"] == $students[$i]){
                    echo "<div class='task_item'>";
                    echo "<p><b>Назва завдання: </b>".$data_arr["Full_task_".$j]["Task_name"]."</p>";
                    echo "<p><b>Завдання: </b>".$data_arr["Full_task_".$j]["Task"]."</p>";
                    if ($data_arr["Full_task_".$j]["Mark"]) {
                        echo "<p><b style='color: red;'>Оцінка: </b>".$data_arr["Full_task_".$j]["Mark"]."</p>";
                    }
                    echo "</div>";
                    $counter++;
                    
                    array_push($all_tasks, $data_arr["Full_task_".$j]["Task_name"]);
                    if ($data_arr["Full_task_".$j]["Mark"]) {
                        array_push($all_marks, $data_arr["Full_task_".$j]["Mark"]);
                    }
                    else{
                        array_push($all_marks, "-");
                    }
                }
            }

            if ($counter == 0){
                echo "<div class='task_item'>";
                echo "<p style='text-align: center;'><b>Не має завдань</b></p>";
                echo "</div>";
            }
            else {
            echo "<div class='task_item task_item_table'>";
            echo "<table border='1' cellspacing='0'>";
            echo "<tr class='student_data_tr'>";
                for($j = 0; $j < count($all_tasks); $j++){
                    echo "<td class='student_data_td'>".$all_tasks[$j]."</td>";
                }
            echo "</tr>";
            echo "<tr class='student_data_tr'>";
                for($j = 0; $j < count($all_marks); $j++){
                    echo "<td class='student_data_td'>".$all_marks[$j]."</td>";
                }
            echo "</tr>";
            echo "</table>";
            echo "</div>";
            }
        }
        

        
    }
    

    // Оптимізація вартості навчання


    function showTable($arr){
        echo "<table border='1' cellspacing='0'>";
        for ($i = 0; $i < count($arr); $i++){
            echo "<tr>";
            for ($j = 0; $j < count($arr); $j++){
                if ($i == 0 && $j != 0) {
                    echo "<td class='tab_data' id='table_inp_".$i."-".$j."'>".str_replace("_"," ",$arr[$j-1])."</td>";
                }
                if ($j == 0 && $i != 0){
                    echo "<td class='tab_data' id='table_inp_".$i."-".$j."'>".str_replace("_"," ",$arr[$i-1])."</td>";
                }
                if ($i == 0 && $j == 0){
                    echo "<td></td>";
                }
                if ($i != 0 && $j != 0){
                    echo "<td><input required step='0.001' value='".rand(1,10)."' type='number' min='0' max='10' class='table_inp' name='table_inp_".$i."-".$j."'></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    function moveSubjects() {
        if (isset($_POST["opt_form_done"])){
            $selectedSubjects = array();
            foreach ($_POST as $key => $value){
                array_push($selectedSubjects, $key);
            }
            // print_r($selectedSubjects);
            $_SESSION["selected_sub"] = $selectedSubjects;
            header("Location: optimization.php");
        }
    }


    function showSubjectsToSelect() {

        $arr = array("ЗК 1. Здатність застосовувати знання у практичних ситуаціях.", 
        "ЗК 2. Знання та розуміння предметної області та розуміння професії.", 
        "ЗК 3. Здатність професійно спілкуватися державною та іноземною мовами як усно, так і письмово", 
        "ЗК 4. Вміння виявляти, ставити та вирішувати проблеми за професійним спрямуванням.", 
        "ЗК 5. Здатність до пошуку, оброблення та аналізу інформації", 
        "ЗК 6. Здатність реалізувати свої права і обов’язки як члена суспільства, усвідомлювати цінності громадянського (вільного демократичного) суспільства та необхідність його сталого розвитку, верховенства права, прав і свобод людини і громадянина в Україні.", 
        "ЗК 7. Здатність зберігати та примножувати моральні, культурні, наукові цінності і досягнення суспільства на основі розуміння історії та закономірностей розвитку предметної області, її місця у загальній системі знань про природу і суспільство та у розвитку суспільства, техніки і технологій, використовувати різні види та форми рухової активності для активного відпочинку та ведення здорового способу життя", 
        "ФК 1. Здатність застосовувати законодавчу та нормативноправову базу, а також державні та міжнародні вимоги, практики і стандарти з метою здійснення професійної діяльності в галузі інформаційної та/або кібербезпеки.", "ФК 2. Здатність до використання інформаційно-комунікаційних технологій, сучасних методів і моделей інформаційної безпеки та/або кібербезпеки.", 
        "ФК 3. Здатність до використання програмних та програмноапаратних комплексів засобів захисту інформації в інформаційнотелекомунікаційних (автоматизованих) системах.", "ФК 4. Здатність забезпечувати неперервність бізнесу згідно встановленої політики інфоормаційної та/або кібербезпеки.", 
        "ФК 5. Здатність забезпечувати захист інформації, що обробляється в інформаційно-телекомунікаційних (автоматизованих) системах з метою реалізації встановленої політики інформаційної та/або кібербезпеки", 
        "ФК 6. Здатність відновлювати штатне функціонування інформаційних, інформаційно-телекомунікаційних (автоматизованих) систем після реалізації загроз, здійснення кібератак, збоїв та відмов різних класів та походження.", 
        "ФК 7. Здатність впроваджувати та забезпечувати функціонування комплексних систем захисту інформації (комплекси нормативноправових, організаційних та технічних засобів і методів, процедур, практичних прийомів та ін.).", 
        "ФК 8. Здатність здійснювати процедури управління інцидентами, проводити розслідування, надавати їм оцінку", 
        "ФК 9. Здатність здійснювати професійну діяльність на основі впровадженої системи управління інформаційною та/або кібербезпекою.", 
        "ФК 10. Здатність застосовувати методи та засоби криптографічного та технічного захисту інформації на об’єктах інформаційної діяльності.", 
        "ФК 11. Здатність виконувати моніторинг процесів функціонування інформаційних, інформаційнотелекомунікаційних (автоматизованих) систем згідно встановленої політики інформаційної та/або кібербезпеки.", 
        "ФК 12. Здатність аналізувати, виявляти та оцінювати можливі загрози, уразливості та дестабілізуючі чинники інформаційному простору та інформаційним ресурсам згідно з встановленою політикою інформаційної та/або кібербезпеки.");

        for($i = 0; $i < count($arr); $i++) {
            echo '<div class="optimization_select_item">';
            echo '<label class="label_select" for="'.$arr[$i].'">'.$arr[$i].'</label>';
            echo '<input type="checkbox" value="'.$arr[$i].'" name="'.$arr[$i].'" id="'.$arr[$i].'">';
            echo '</div>';
        }
        
    }


    function showFormTable($arr){
        echo "<b><p><h2>Введіть кількість годин для кожної компетенції</h2></p></b>";
        for ($i = 0; $i < count($arr)-1; $i++){
            echo "<b><p class='tab_data'>".str_replace("_"," ",$arr[$i]).":</p></b>";
            echo "<input required type='number' class='enter' placeholder='Вартість 1 години' name='hours-".$i."'>";
            echo "<br>";
        }
        echo "<b><p>Мінімальна кількість годин на рік для підготовки вибраних компетенцій:</p></b>";
        echo "<input required type='number' name='conct1' value='450' class='enter' placeholder='Мінімальна к-сть годин'>";
        echo "<b><p>Максимальна кількість годин на рік для підготовки вибраних компетенцій:</p></b>";
        echo "<input required type='number' name='conct2' value='1080' class='enter' placeholder='Максимальна к-сть годин'>";
        echo "<b><p>Фонд грошей для навчання одного студента на рік:</p></b>";
        echo "<input required type='number' name='s_v' value='59000' class='enter' placeholder='Фонд для одного студента'>";
        echo "<b><p>Мінімальна кількість годин на рік для підготовки 1 компетенцій:</p></b>";
        echo "<input required type='number' name='meg1' value='30' class='enter' placeholder='Мінімальна к-сть годин для 1 компетенції'>";
        echo "<b><p>Максимальна кількість годин на рік для підготовки 1 компетенцій:</p></b>";
        echo "<input required type='number' name='meg2' value='270' class='enter' placeholder='Максимальна к-сть годин для 1 компетенції'>";

    }

    function getElementsFromTable($arr){
        if (isset($_POST["opt_form_table_done"])){
            $table_data = array();
            for ($i = 1; $i < count($arr); $i++){
                for ($j = 1; $j < count($arr); $j++){
                    array_push($table_data, $_POST["table_inp_".$i."-".$j]);
                }
            }
            // print_r($table_data);
            echo "<br><br>";
            
            $arr2 = array();
            $tmp = array();
            $d = count($arr) - 1;
            for ($i = 0; $i < count($table_data); $i++){
                if ($i % $d == 0){
                    $tmp = array();
                }
                array_push($tmp, $table_data[$i]);
                if (count($tmp) == $d){
                    array_push($arr2, round((pow(array_sum($tmp), 1/count($tmp)))/count($tmp),4)*100);
                }
            }


            $hoursComp = array();
            for ($i = 0; $i < count($arr)-1; $i++){
                array_push($hoursComp, $_POST["hours-".$i]);
            }

            $conct1 = $_POST["conct1"];
            $conct2 = $_POST["conct2"];
            $s_v = $_POST["s_v"];
            $meg1 = $_POST["meg1"];
            $meg2 = $_POST["meg2"];
            $n = count($arr)-1;





            echo "c - ";
            print_r($arr2);
            echo "<br>";

            echo "a - ";
            print_r($hoursComp);
            echo "<br>";

            echo "conct1 - ".$conct1."<br>";
            echo "conct2 - ".$conct2."<br>";

            echo "S_V - ".$s_v."<br>";

            echo "meg1 - ".$meg1."<br>";
            echo "meg2 - ".$meg2."<br>";

            echo "n - ".$n."<br>";

            $max_S = 0;
            $l_m = array();
            $a_2 = $hoursComp;

            foreach(range(0, $n-1) as $i){
                $a_2[$i] = $hoursComp[$i];
                // echo $i;
            }

            echo "a_2 - ";
            print_r($a_2);
            echo "<br>";
            
            // #######################################################################

            $f = fopen("formula.json", "w");
            
            ftruncate($f, 0);

            $form_data = array();
            $form_data["c"] = $arr2;
            $form_data["a"] = $hoursComp;
            $form_data["conct1"] = $conct1;
            $form_data["conct2"] = $conct2;
            $form_data["S_V"] = $s_v;
            $form_data["meg1"] = $meg1;
            $form_data["meg2"] = $meg2;
            $form_data["n"] = $n;

            fwrite($f, json_encode($form_data, JSON_UNESCAPED_UNICODE));
            fclose($f);

            $command = escapeshellcmd('py show_result.py');
            $output = shell_exec($command);
            echo "<div class='opt_result'>";
            echo $output;
            echo "<span class='close_result'>×</span>";
            echo "</div>";
            
            // phpinfo();
            
            

            // #######################################################################
        }
    }

    function createTableANR() {
        if (isset($_POST["anr_btn"])) {
            $matrix_size = $_POST["size"];
            $_SESSION["matrix_size"] = $matrix_size;

            echo "<table border='1' cellspacing='0' style='margin-bottom: 20px;'>";
            for ($i = 0; $i < $matrix_size; $i++){
                echo "<tr>";
                for ($j = 0; $j < $matrix_size; $j++){
                    echo "<td><input required step='0.001' value='".rand(1,10)."' type='number' min='1' class='table_inp' name='table_inp_".$i."-".$j."'></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo '<input type="submit" name="anr_table_btn" value="Готово">';
        }
    }

    function anr(){
        if (isset($_POST["anr_table_btn"])){
            $size = $_SESSION["matrix_size"];
            $table_data = array();
            for ($i = 0; $i < $size; $i++){
                for ($j = 0; $j < $size; $j++){
                    array_push($table_data, $_POST["table_inp_".$i."-".$j]);
                }
            }
            // print_r($table_data);

            $arr2 = array();
            $tmp = array();
            for ($i = 0; $i < count($table_data); $i++){
                if ($i % $size == 0){
                    $tmp = array();
                }
                array_push($tmp, $table_data[$i]);
                if (count($tmp) == $size){
                    // print_r($tmp);
                    // echo "<br>";
                    array_push($arr2, round((pow(array_sum($tmp), 1/count($tmp)))/count($tmp),4)*100);
                }
            }
            echo "<div class='anr_result'>";
            echo "<h3>Результати:</h3>";
            for ($i = 0; $i < count($arr2); $i++){
                echo "[".$i."] => ".$arr2[$i]."<br>";
            }
            echo "</div>";
        }
    }

    // Accounting subject

    function showTableAccounting($conn) {
        $query = "SELECT subject FROM subjects";
        $query_result = mysqli_query($conn, $query);
        $subjects_arr = array();
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($subjects_arr, $row);
        }
        // print_r($subjects_arr);
        $criterias = array("Інтерес", "Контент", "Рівень базових знань студента");


        echo "<table border='1' cellspacing='0' style='margin-bottom: 20px;'>";
        for ($i = 0; $i < 4; $i++){
            echo "<tr>";
            for ($j = 0; $j < 5; $j++){
                if ($i == 0 && $j != 0) {
                    echo "<td class='tab_data' id='table_inp_".$i."-".$j."'>";
                    echo "<select class='acc_select' name='table_inp_".$i."-".$j."'>";
                    echo "<option value='none' style='display: none;' disabled selected>Не вибрано</option>";
                    for ($s = 0; $s < count($subjects_arr); $s++){
                        echo "<option value='".$subjects_arr[$s]["subject"]."'>".$subjects_arr[$s]["subject"]."</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                }
                if ($j == 0 && $i != 0){
                    // $t = $i - 1;
                    echo "<td class='tab_data tab_data_w' id='table_inp_".$i."-".$j."'>".$criterias[$i-1]." <input required type='number' name='table_inp_".$i."-".$j."' min='0.001' step='0.001' placeholder='Вага'></td>";
                }
                if ($i == 0 && $j == 0){
                    echo "<td></td>";
                }
                if ($i != 0 && $j != 0){
                    echo "<td><input required step='1' value='".rand(1,10)."' type='number' min='0' max='10' class='table_inp' name='table_inp_".$i."-".$j."'></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        echo '<input class="accountinf_subm" type="submit" name="accounting_table_btn" value="Готово">';
    }

    function accountingResult() {
        if (isset($_POST["accounting_table_btn"])) {
            $table_data = array();
            for ($j = 1; $j < 5; $j++){
                $temp = array();
                for ($i = 1; $i < 4; $i++){
                    array_push($temp, (int)$_POST["table_inp_".$i."-".$j]);
                }
                $t = $j;
                $t--;
                $table_data["MARK".$t] = $temp;
            }
            // print_r($table_data);
            // echo "<br>";
            $hp = array();
            for ($i = 1; $i < 4; $i++){
                $t = $i;
                $t--;
                $hp["HP".$t] = (int)$_POST["table_inp_".$i."-0"];
            }
            // print_r($hp);
            // echo "<br>";
            $subjects = array();
            for ($j = 1; $j < 5; $j++){
                $t = $j;
                $t--;
                $subjects["SUB".$t] = $_POST["table_inp_0-".$j];
            }
            // print_r($subjects);

            $to_send = array("HP" => $hp, "MARK" => $table_data, "SUBJECTS" => $subjects);
            // print_r($to_send);
            

            $f = fopen("formula_student.json", "w");
            ftruncate($f, 0);
            fwrite($f, json_encode($to_send, JSON_UNESCAPED_UNICODE));
            fclose($f);

            $command = escapeshellcmd('py formula_student.py');
            $output = shell_exec($command);
            echo "<div class='opt_result'>";
            // echo $output;
            $f = fopen("formula_student_result.json", "r+");
            $data_arr = json_decode(file_get_contents("formula_student_result.json"), true);
            // print_r($data_arr);
            foreach($data_arr as $sub => $val){
                echo $sub." - ".$val;
                echo "<br>";
            }

            echo "<span class='close_result'>×</span>";
            echo "</div>";
        }
    }

?>