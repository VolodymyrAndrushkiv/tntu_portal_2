<?
ob_start();
include "functions.php";
ob_clean();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
    <div class="main_block">
        <div class="sub_block">
            <img src="images/logo.png" alt="logo" id="logo">
        </div>
        <div class="sub_block">
            <h1>Sign in</h1>
            <form action="" method="post" class="login_form">
                <div>
                    <i class="fas fa-user form_icon"></i>
                    <input required type="text" id="login" class="enter" name="login_log" placeholder="Login">
                </div>
                <div>
                    <i class="fas fa-unlock-alt form_icon"></i>
                    <input required type="password" id="pass" class="enter" name="password_log" placeholder="Password">
                </div>
                <input type="submit" id="subm" name="subm_log" value="Login">
            </form>
            <p id="registration_tip">Create your account <i class="fas fa-long-arrow-alt-right" id="tip_icon"></i></p>
        </div>
        <div class="sub_block hidden">
            <h1 id="reg_header">Sign up</h1>
            <form action="" method="post" class="login_form">
                <div>
                    <i class="fas fa-user form_icon"></i>
                    <input required type="text" id="login_reg" class="enter enter_reg" placeholder="Login" name="login">
                </div>
                <div>
                    <i class="fas fa-file-signature"></i>
                    <input required type="text" id="first_name" class="enter enter_reg" placeholder="First name" name="first_name">
                </div>
                <div>
                    <i class="fas fa-file-signature"></i>
                    <input required type="text" id="last_name" class="enter enter_reg" placeholder="Last name" name="last_name">
                </div>
                <!-- <div>
                    <i class="fas fa-envelope"></i>
                    <input required type="email" id="email" class="enter enter_reg" placeholder="Email">
                </div> -->
                <div>
                    <i class="fas fa-unlock-alt form_icon"></i>
                    <input required type="password" id="pass_reg" class="enter enter_reg" placeholder="Password" name="pass">
                </div>
                <div>
                    <i class="fas fa-user-tag"></i>
                    <select id="enter_role" name="role">
                        <option value="student">Student</option>
                        <option value="proffesor">Proffesor</option>
                        <option value="instructor">Instructor</option>
                    </select>
                </div>
                <input type="submit" class="subm_reg" value="Sign up" name="reg_subm">
            </form>

            

            <p id="login_tip">Go to login <i class="fas fa-long-arrow-alt-right" id="tip_icon"></i></p>
        </div>
    </div>

    <?php

    registration($connection);
    login($connection)
    ?>

    
    <!-- <script src="js/formajax.js"></script> -->
    <script src="js/script.js"></script>
</body>
</html>