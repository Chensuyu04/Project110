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
    <title>個人資料</title>
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
    <br><br>
    <div class="container pt-3">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
            <li class="breadcrumb-item active">個人資料</li>
        </ul>
    </div>
    <span class="border border-white">
        <div class=" container border w-50" align="center">
            <?php
            $query = "SELECT * FROM `users` where `u_account`='" . $_SESSION["account"] . "'";
            $result = mysqli_query($db_link, $query);
            $rows = mysqli_fetch_assoc($result);
            echo <<<_END
            <form method="POST">
                <div class="form-floating mb-3">
                    <input type="text" placeholder="姓名" name="name" class="form-control" id="floatingname" required="" value=$rows[u_name]>
                    <label for="floatingInput">姓名</label>    
                </div>
                <div class="form-floating mb-3">
                <input type="text" placeholder="身分證字號" name="iden" class="form-control" id="floatingiden" disabled="disabled" value=$rows[u_iden]>
                <label for="floatingInput">身分證字號</label>    
                </div>
                <div class="form-floating mb-3">
                    <input type="date" placeholder="生日" name="birth" class="form-control" disabled="disabled" id="floatingbirth" value=$rows[u_birth] required="">
                    <label for="floatingInput">生日</label>    
                </div>
                <div class="form-floating mb-3">
                    <input type="text" placeholder="電話" name="phone" id="phone" pattern="09\d{8}" class="form-control" value=$rows[u_phone]>
                    <label for="floatingInput">電話</label>   
                </div>
                <div class="form-floating mb-3">
                    <input type="email" placeholder="郵件" name="email" id="email" class="form-control" value=$rows[u_email]>
                    <label for="floatingInput">郵件</label>   
                </div>
                    <input type="submit" name="updata" value="更改" class="btn btn-secondary">
            </form>    
        _END;
            ?>
            <?php
            if (isset($_POST["updata"])) {
                $update = "UPDATE `users` SET `u_name`='" . $_POST["name"] . "' , `u_phone` = '" . $_POST["phone"] . "', `u_email` = '" . $_POST["email"] . "'WHERE `u_account`='" . $_SESSION["account"] . "'";
                $result = mysqli_query($db_link, $update);
                echo "<script>alert('更新成功');location.href='u_data.php'</script>";
            }
            ?>
        </div>
        <?php
        include('footer.php');
        ?>
    </span>
    <SCRIPT Language="JavaScript">
        var user = document.getElementById("phone");
        user.onblur = function() {
            if (user.value) {
                user.setCustomValidity(""); //現將有輸入時的提示設置爲空
            } else if (user.validity.valueMissing) {
                user.setCustomValidity("不能爲空");
            };
            if (user.validity.patternMismatch) {
                user.setCustomValidity("格式：09xx-xxx-xxx");
            }
        };
    </SCRIPT>
</body>

</html>
<style>
    i.fa-shopping-cart {
        color: black;
    }
</style>