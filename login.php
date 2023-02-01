<?php
include('function.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入/註冊</title>
    <!-- 新 Bootstrap5 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    <!--  popper.min.js 用于弹窗、提示、下拉菜单 -->
    <script src="https://cdn.staticfile.org/popper.js/2.9.3/umd/popper.min.js"></script>
    <!-- 最新的 Bootstrap5 核心 JavaScript 文件 -->
    <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.min.js"></script>
    <!--icon連結-->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
    <?php
    include('header.php');
    ?>
    <input type='button' class='btn btn-light' onclick="javascript:location.href='login.php'" value='登入/註冊'></input>
    <a class='nav-link' href='u_order.php'><i class='fas fa-shopping-cart'></i></a>
    </nav>
    <br><br>
    <div class='container pt-3'>
        <ul class='breadcrumb'>
            <li class='breadcrumb-item'><a href='u_index.php'>首頁</a></li>
            <li class='breadcrumb-item active'>登入/註冊</li>
        </ul>
    </div>
    <span class='border border-white'>
        <div class=' container border w-50' align='center'>
            <ul class='nav nav-tabs'>
                <li class='nav-item'>
                    <a class='nav-link' href='login.php?action=login'>登入</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='login.php?action=regis'>註冊</a>
                </li>
            </ul>
            <?php
            if ($_GET['action'] == 'login') {
            ?>
                <form method='POST'>
                    <div class='form-floating mb-3'>
                        <input type='text' placeholder='account' name='account' class='form-control' id='floatingInput' required=''>
                        <label for='floatingInput'>帳號</label>
                    </div>
                    <div class='form-floating'>
                        <input type='password' placeholder='pwd' name='pwd' class='form-control' id='floatingPassword'><br>
                        <label for='floatingPassword'>密碼</label>
                    </div>
                    <input type='submit' name='login_in' value='登入' class='btn btn-secondary'>
                    <input type='button' onclick="location.href='forget.php'" name='forget' value='忘記密碼' class='btn btn-secondary'>
                </form>
            <?php
            } else if ($_GET['action'] == 'regis') {
            ?>
                <form method='POST'>
                    <div class='form-floating mb-3'>
                        <input type='text' placeholder='姓名' name='name' class='form-control' id='floatingname' required=''>
                        <label for='floatingInput'>姓名</label>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='text' placeholder='身分證字號' name='iden' class='form-control' id='floatingiden' onchange='CheckInput(this.id)'>
                        <label for='floatingInput'>身分證字號</label>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='date' placeholder='生日' name='birth' class='form-control' id='floatingbirth' required=''>
                        <label for='floatingInput'>生日</label>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='text' placeholder='電話' name='phone' id='phone' pattern='09\d{8}' class='form-control'>
                        <label for='floatingInput'>電話</label>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='email' placeholder='郵件' name='email' id='email' class='form-control'>
                        <label for='floatingInput'>郵件</label>
                    </div>
                    <div class='form-floating mb-3'>
                        <input type='text' placeholder='帳號' name='account' class='form-control' id='floatingaccount' required='' onchange='checkUsername()'>
                        <label for='floatingInput'>帳號</label>
                    </div>
                    <div class='form-floating mb-3'>
                        <select name='address' placeholder='地區' size='1' class='form-control'>
                            <option value='台北'>台北</option>
                            <option value='桃園'>桃園</option>
                            <option value='新竹'>新竹</option>
                            <option value='苗栗'>苗栗</option>
                            <option value='台中'>台中</option>
                        </select>
                        <label for='floatingInput'>地區</label>
                    </div>
                    <div class='form-floating '>
                        <input type='password' placeholder='密碼' name='pwd' class='form-control' id='floatingPassword' pattern='[a-zA-Z0-9]{8,}'><br>
                        <label for='floatingPassword'>密碼</label>
                    </div>
                    <div class='form-floating'>
                        <input type='password' placeholder='確認密碼' name='repwd' class='form-control' id='floatingrepassword' onchange='Checkpwd(this.id)'><br>
                        <label for='floatingrepassword'>確認密碼</label>
                    </div>
                    <input type='submit' name='regis' value='註冊' class='btn btn-secondary'>
                </form>
            <?php
            }
            if ($_GET['login_out'] == '1') {
                echo "<script>alert('登出成功');location.href='u_index.php';</script>";
                session_unset();
            }
            if (isset($_POST['login_in'])) {
                $query = "SELECT * FROM `users` where `u_account`='" . $_POST['account'] . "'";
                $result = mysqli_query($db_link, $query);
                $rows = mysqli_fetch_assoc($result);
                $today = date('Y-m-d H:i:s');
                if ($rows['u_stop'] > $today) {
                    echo '<div class="alert alert-danger" role="alert">
                    您被停權需' . $rows['u_stop'] . '後才可以登入
                  </div>';
                } elseif (isset($_POST['login_in']) && $rows['u_pwd'] == '') {
                    echo '<div class="alert alert-danger" role="alert">
                    沒有此使用者
                  </div>';
                } elseif (isset($_POST['login_in']) && $_POST['pwd'] != $rows['u_pwd']) {
                    echo '<div class="alert alert-danger" role="alert">
                    密碼錯誤
                  </div>';
                } else {
                    $query = "UPDATE `users` SET `u_stop`='0000-00-00 00:00:00' WHERE `u_account`='" . $_POST['account'] . "'";
                    $result = mysqli_query($db_link, $query);
                    $query = "SELECT * FROM `users` where `u_account`='" . $_POST['account'] . "'";
                    $result = mysqli_query($db_link, $query);
                    $rows = mysqli_fetch_assoc($result);
                    if ($rows['u_authority'] == '1') {
                        $_SESSION['account'] = $_POST['account'];
                        echo "<script>alert('登入成功');location.href='a_manuser.php';</script>";
                    } else if ($rows['u_authority'] == '2') {
                        $_SESSION['account'] = $_POST['account'];
                        echo "<script>alert('登入成功');location.href='u_index.php';</script>";
                    }
                }
            }
            if (isset($_POST['regis'])) {
                $query = "SELECT * FROM `users` where `u_account`='" . $_POST['account'] . "'";
                $result = mysqli_query($db_link, $query);
                $rows = mysqli_fetch_assoc($result);
                if ($_POST["pwd"] == $_POST["repwd"]) {
                    if ($rows['u_account'] == null) {
                        $ins = "INSERT INTO `users` (`u_name`,`u_iden`,`u_birth`,`u_account`,`u_pwd`,`u_phone`,`u_email`,`u_address`,`u_authority`,`u_stop`,`u_rnd`) 
            VALUES ('" . $_POST['name'] . "','" . $_POST['iden'] . "','" . $_POST['birth'] . "','" . $_POST['account'] . "'
            ,'" . $_POST['pwd'] . "','" . $_POST['phone'] . "','" . $_POST['email'] . "','" . $_POST['address'] . "','2','0000-00-00 00:00:00','0')";
                        $result = mysqli_query($db_link, $ins);
                        echo "<script>alert('註冊成功');u_index.php;</script>";
                    } else {
                        echo "<script>alert('帳號已被使用');history.back();</script>";
                    }
                } else
                    echo "<script>alert('兩次密碼輸入不一致');login.php;</script>";
            }
            ?>
        </div>
    </span>
    <SCRIPT Language='JavaScript'>
        function CheckInput(x) {
            if (!checkID(document.getElementById(x).value)) {
                document.getElementById(x).value = " ";
                window.alert('身份證字號錯誤!');
            }

        }


        function checkID(id) {
            tab = 'ABCDEFGHJKLMNPQRSTUVWXYZIO'
            A1 = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3);
            A2 = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5);
            Mx = new Array(9, 8, 7, 6, 5, 4, 3, 2, 1, 1);
            if (id.length != 10) return false;
            i = tab.indexOf(id.charAt(0));
            if (i == -1) return false;
            sum = A1[i] + A2[i] * 9;
            for (i = 1; i < 10; i++) {
                v = parseInt(id.charAt(i));
                if (isNaN(v)) return false;
                sum = sum + v * Mx[i];
            }
            if (sum % 10 != 0) return false;
            return true;
        }
        var pwd = document.getElementById('floatingPassword');
        pwd.onblur = function() {
            if (pwd.value) {
                pwd.setCustomValidity('');
                //現將有輸入時的提示設置爲空
            } else if (pwd.validity.valueMissing) {
                pwd.setCustomValidity('不能爲空');

            };
            if (pwd.validity.patternMismatch) {

                pwd.setCustomValidity('格式：8碼含英文與數字');
            }
        };

        function Checkpwd(x) {
            if (!checkp(document.getElementById(x).value))
                window.alert('輸入不一致');
        }

        function checkp(id) {
            if (id == document.getElementById('floatingPassword').value) {
                return true;
            } else {
                return false;
            }
        }
        var user = document.getElementById('phone');
        user.onblur = function() {
            if (user.value) {
                user.setCustomValidity('');
                //現將有輸入時的提示設置爲空
            } else if (user.validity.valueMissing) {
                user.setCustomValidity('不能爲空');

            };
            if (user.validity.patternMismatch) {

                user.setCustomValidity('格式：09xx-xxx-xxx');
            }
        };
    </SCRIPT>
    <?php
    include('footer.php');
    ?>
</body>

</html>
<style>
    i.fa-shopping-cart {
        color: white;
    }
</style>