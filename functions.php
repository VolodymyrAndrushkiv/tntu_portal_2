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
            // echo "<p class='msg_success'>".$query."</p>";
            $query_result = mysqli_query($conn, $query);

            $data = mysqli_fetch_assoc($query_result);
            // print_r($data);

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
                    // echo "<p class='msg_success'>Instructor</p>";
                    header("Location: main_pages/instructor.php");
                    exit;
                }
                // header("Location:main_pages/".$header.".php");
            }
            else {
                echo "<p class='msg_error'>Неправильний логін або пароль</p>";
                session_abort();
            }

        }
    }

    function addSubject($conn) {
        if (isset($_POST["subm_journal"])){
            $subject_name = $_POST["subject_name"];
            if (strlen($subject_name) < 2 ) {
                echo "<p class='msg_error'>Назва предмету має бути 3+ символів</p>";
            }
            else {
                $query = "INSERT INTO subjects (subject) VALUES ('$subject_name')";
                mysqli_query($conn, $query);

                $data = array('Subject' => $subject_name);
                $f = fopen("../journal_data/".$subject_name.".json", "w");
                fwrite($f, json_encode($data, JSON_UNESCAPED_UNICODE));
                fclose($f);

                header("Location: journal_edit.php");
            }
        }
    }

    function showAllSubjects($conn){
        $query = "SELECT * FROM subjects";
        $query_result = mysqli_query($conn, $query);
        $subject_arr = array();
        while($row = mysqli_fetch_assoc($query_result)){
            array_push($subject_arr, $row);
        }
        // print_r($subject_arr);
        for ($i = 0; $i < count($subject_arr); $i++){
            echo "<div class='edit_journal_select_item'>
            <p>".$subject_arr[$i]["subject"]."</p>
            <a href='edit_item.php?sub=".$subject_arr[$i]["subject"]."'>Редагувати</a>
            </div>";
        }
    }

    // function displayEditPage(){
    //     if ($_SESSION["role"] == 'student'){

    //     }
    //     elseif ($_SESSION["role"] == 'instructor'){

    //     }
    // }

    function editJournal(){
        // Додати завдання
        if (isset($_POST["subm_edit"])){
            $reviewer = $_POST["reviewer_edit"];
            $student = $_POST["student_edit"];
            $task_name = $_POST["task_name_edit"];
            $task = $_POST["task_edit"];

            $f = fopen("../journal_data/".$_GET['sub'].".json", "r+");
            $data_arr = json_decode(file_get_contents("../journal_data/".$_GET['sub'].".json"), true);


            $data_arr["Full_task_".count($data_arr)] = array("Reviewer" => $reviewer, "Student" => $student, "Task_name" => $task_name, "Task" => $task);

            // echo $task;
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

?>