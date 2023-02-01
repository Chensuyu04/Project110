<?php
include('function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>忘記密碼</title>
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
        <input type='button' class="btn btn-light" onclick="javascript:location.href='login.php?login_out=1'" value='登出'></input>

    <?php
    }
    ?>
    </div>
    </div>
    </nav>
    <br><br>
    <div class="container mt-3">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
            <li class="breadcrumb-item active">忘記密碼</li>
        </ul>
    </div>
    <span class='border border-white'>
        <div class=' container border w-50' align='center'>
            <ul class='nav nav-tabs'>
                <li class='nav-item action'>
                    <a class='nav-link action' href='forget.php'>忘記密碼</a>
                </li>
            </ul>
                <form method='POST'>
                    <div class='form-floating mb-3'>
                        <input type='text' name='nid' class='form-control' id='floatingInput' required=''>
                        <label for='floatingInput'>身分證</label>
                    </div>
                    <div class='form-floating'>
                        <input type='text' name='email' class='form-control' id='floatingPassword'><br>
                        <label for='floatingPassword'> 郵件</label>
                    </div>
                    <div class="u-align-left u-form-group u-form-submit u-form-group-5">
                        <input type="submit" value="送出" value="登入" class="btn btn-secondary">
                    </div>
                </form>
        </div>
    </span>
    <?php
    $query = "SELECT * FROM `users` where `u_email`='" . $_POST['email'] . "'";
    $result = mysqli_query($db_link, $query);
    $rows = mysqli_fetch_assoc($result);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    //設定檔案路徑
    require 'C:\Program Files\Ampps\www\project110\PHPMailer\src\Exception.php';
    require 'C:\Program Files\Ampps\www\project110\PHPMailer\src\PHPMailer.php';
    require 'C:\Program Files\Ampps\www\project110\PHPMailer\src\SMTP.php';

    //建立物件                                                                
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable verbose debug output
        $mail->SMTPDebug = 0; // DEBUG訊息
        $mail->isSMTP(); // 使用SMTP
        $mail->Host = 'smtp.gmail.com'; // SMTP server 位址
        $mail->SMTPAuth = true;  // 開啟SMTP驗證
        $mail->Username = 'a0932171295@gmail.com'; // SMTP 帳號
        $mail->Password = 'lxchumgezmdoqbbm'; // SMTP 密碼
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->SMTPSecure = "ssl"; // Gmail要透過SSL連線
        $mail->Port       = 465; // SMTP TCP port 

        //設定收件人資料
        $mail->setFrom('a0932171295@gmail.com', 'Mailer'); // 寄件人(透過Gmail發送會顯示Gmail帳號為寄件者)
        $email = $_POST["email"];
        $mail->addAddress($email, 'Apple User'); // 收件人會顯示 Apple User<apple@example.com>(*註2)
        // $mail->addAddress('banana@example.com'); // 名字非必填
        $mail->addReplyTo('a0932171295@gmail.com', 'Information'); //回信的收件人
        // $mail->addCC('cc@example.com'); //副本
        // $mail->addBCC('bcc@example.com'); //密件副本

        // 附件
        // $mail->addAttachment('/var/tmp/file.tar.gz'); // 附件 (*註3) 
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // 插入附件可更改檔名
        $pwd = rand(0000, 9999);
        // 信件內容
        $mail->isHTML(true); // 設定為HTML格式
        $mail->Subject = mb_encode_mimeheader('你的密碼', 'UTF-8'); // 信件標題
        $mail->Body    = $rows["u_pwd"]; // 信件內容
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; // 對方若不支援HTML的信件內容
        $mail->send();
        echo '<script>alert("已寄出");</script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    ?>
    <!-- Copyright -->
    <?php
    include('footer.php');
    ?>
</body>

</html>
<style>
    i.fa-shopping-cart {
        color: black;
    }

    .submit {
        border: 0;
        background-color: #808080;
        color: #fff;
        border-radius: 5px;
        width: 100px;
        height: 30px;
        font-size: 15;
    }

    .resize {
        width: auto;
        width: 225px;
    }

    .resize {
        height: auto;
        height: 150px;
    }

    .resize1 {
        width: auto;
        width: 350px;
    }

    .resize1 {
        height: auto;
        height: 200px;
    }

    .modal-backdrop {
        background-color: #fff;
    }

    .card-modal~.modal-backdrop {
        background-color: #000;
    }

    .search {
        width: 200px;
    }

    .number {
        width: 80px;
        height: 30px;
        border-radius: 5px;
    }

    .a.page-link {
        color: #ffffff;
    }
</style>