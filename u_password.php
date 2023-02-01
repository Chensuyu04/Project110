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
    <title>修改密碼</title>
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
    <?php
    if ($_SESSION['account'] == "") {
    ?>
        <input type='button' class="btn btn-light" onclick="javascript:location.href='login.php'" value='登入/註冊'></input>

    <?php
    } else {

    ?>
        <a class="nav-link" href="u_shop.php"><i class="fas fa-shopping-cart"></i></a>
        <?php
        $query_shop = "SELECT * FROM `shop` where `s_account`='" . $_SESSION["account"] . "'";
        $result_shop = mysqli_query($db_link, $query_shop);
        $rowscart = $result_shop->num_rows;
        echo '<sup>' . $rowscart . '</sup>';
        ?>
        <input type='button' class="btn btn-light" onclick="javascript:location.href='login.php?login_out=1'" value='登出'></input>

    <?php
    }
    ?>
    </div>
    </div>
    </nav>
    <div class="container pt-3">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
            <li class="breadcrumb-item active">修改密碼</li>
        </ul>
    </div>
    <span class="border border-white">
        <div class=" container border w-50" align="center">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link action" href="u_password.php">修改密碼</a>
                </li>
            </ul>
            <?php
            ?>
            <form method="POST">
                <div class="form-floating mb-3">
                    <input type="text" placeholder="pwd" name="pwd" class="form-control" id="floatingInput" required="">
                    <label for="floatingInput">舊密碼</label>
                </div>
                <div class="form-floating">
                    <input type="password" placeholder="newpwd" name="newpwd" class="form-control" id="floatingPassword"><br>
                    <label for="floatingPassword">新密碼</label>
                </div>
                <div class="form-floating">
                    <input type="password" placeholder="r_newpwd" name="r_newpwd" class="form-control" id="floatingPassword"><br>
                    <label for="floatingPassword">確認新密碼</label>
                </div>
                <input type="submit" name="uppass" value="修改" class="btn btn-secondary">
            </form>
            <?php
            if (isset($_POST["uppass"])) {
                $query = "SELECT * FROM `users` where `u_account`='" . $_SESSION["account"] . "'";
                $result = mysqli_query($db_link, $query);
                $rows = mysqli_fetch_assoc($result);
                if ($_POST["newpwd"] != $_POST["r_newpwd"]) {
                    echo "<script>alert('輸入不一致');location.href='u_password.php'</script>";
                }
                if ($rows["u_pwd"] == $_POST["pwd"] && $_POST["newpwd"] == $_POST["r_newpwd"]) {
                    $update = "UPDATE `users` SET `u_pwd`='" . $_POST["newpwd"] . "' WHERE `u_id` ='" . $rows["u_id"] . "'";
                    $result = mysqli_query($db_link, $update);
                    echo "<script>alert('密碼更改成功');location.href='u_index.php'</script>";
                }
            }
            ?>
        </div>
        <?php
        include('footer.php');
        ?>
    </span>
</body>

</html>
<style>
    i.fa-shopping-cart {
        color: black;
    }
</style>