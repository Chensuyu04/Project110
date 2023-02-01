<?php
date_default_timezone_set('Asia/Shanghai'); //設定時間
require_once('config.php'); //載入設定檔
if (!isset($_SESSION)) {
  session_start();
} //開啟 SESSION
db_connect();  //連建
/*db_connect 資料庫連接 */
function db_connect()
{
  global $connect, $db_hostname, $db_database_connect, $db_username_connect, $db_password_connect;  //用 global 載入 config.php 的資料
  /*連線資料庫伺服器*/
  $connect = mysqli_connect($db_hostname, $db_username_connect, $db_password_connect, $db_database_connect);
  if (empty($connect)) {
    print mysqli_error($connect);  //輸出錯誤
    die('無法連結資料庫');
    exit;
  }
  mysqli_query($connect, "SET NAMES 'utf8'");  //設定連線的文字集與校對為 UTF8 編碼
}
/*GetIP 取得使用者IP*/
function GetIP()
{
  if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { //CloudFlare
    $userip = '(' . $_SERVER["HTTP_CF_IPCOUNTRY"] . ')' . $_SERVER['HTTP_CF_CONNECTING_IP'];
  } elseif (isset($_SERVER['REMOTE_ADDR'])) {
    $userip = $_SERVER['REMOTE_ADDR'];
  } else {
    $userip = "error";
  }
  return $userip;
}
/*GetTime 取得目前時間*/
function GetTime()
{
  $GetTime = date('Y-m-d H:i:s');
  return $GetTime;
}
/*SendMessage 送出聊天訊息*/
function SendMessage($msg)
{
  global $connect; //MySql連線
  $nowtime = GetTime(); //取得目前時間
  $userip = GetIP(); //取得使用者IP
  $msg = mysqli_real_escape_string($connect, $msg); //轉碼成可存入sql
  $insertSQL = "INSERT INTO message (message, datetime, ip , account, answer) VALUES ('$msg', '$nowtime','$userip','" . $_SESSION["account"] . $_GET["u_account"] . "','0')";
  $Result = mysqli_query($connect, $insertSQL) or die(mysqli_error($connect));
  $updataSQL = "UPDATE `message` SET `answer`='0' WHERE `account`='" . $_GET["u_account"] . "' ORDER BY `datetime` DESC LIMIT 1";
  $Result = mysqli_query($connect, $updataSQL) or die(mysqli_error($connect));
}

//======送出POST動作======
if (isset($_POST['chat'])) {
  $msg = $_POST['chat'];
  SendMessage($msg);
}

//======讀取聊天內容======
$NAME = "root" . $_GET["u_account"];
$message_query = "SELECT * FROM message where account='" . $_GET["u_account"] . "' or account='" . $NAME . "' ORDER BY CAST(`id` AS UNSIGNED) DESC";
$message = mysqli_query($connect, $message_query) or die(mysqli_error($connect));
$row_message = mysqli_fetch_assoc($message);
$total_message = mysqli_num_rows($message);



?>
<!DOCTYPE html>
<html>

<head>
<title>客服中心</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      min-height: 100vh;
      min-height: -webkit-fill-available
    }

    html {
      height: -webkit-fill-available
    }

    main {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
    }

    .b-example-divider {
      flex-shrink: 0;
      width: 1.5rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15)
    }

    .bi {
      vertical-align: -.125em;
      pointer-events: none;
      fill: currentColor
    }

    .dropdown-toggle {
      outline: 0
    }

    .nav-flush .nav-link {
      border-radius: 0
    }

    .btn-toggle {
      display: inline-flex;
      align-items: center;
      padding: .25rem .5rem;
      font-weight: 600;
      color: rgba(0, 0, 0, .65);
      background-color: transparent;
      border: 0
    }

    .btn-toggle:hover,
    .btn-toggle:focus {
      color: rgba(0, 0, 0, .85);
      background-color: #d2f4ea
    }

    .btn-toggle::before {
      width: 1.25em;
      line-height: 0;
      content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
      transition: transform .35s ease;
      transform-origin: .5em 50%
    }

    .btn-toggle[aria-expanded="true"] {
      color: rgba(0, 0, 0, .85)
    }

    .btn-toggle[aria-expanded="true"]::before {
      transform: rotate(90deg)
    }

    .btn-toggle-nav a {
      display: inline-flex;
      padding: .1875rem .5rem;
      margin-top: .125rem;
      margin-left: 1.25rem;
      text-decoration: none
    }

    .btn-toggle-nav a:hover,
    .btn-toggle-nav a:focus {
      background-color: #d2f4ea
    }

    .scrollarea {
      overflow-y: auto
    }

    .fw-semibold {
      font-weight: 600
    }

    .lh-tight {
      line-height: 1.25
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none
    }

    @media (min-width:768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem
      }
    }
  </style>
  <!-- 新 Bootstrap5 核心 CSS 文件 -->
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
  <!--  popper.min.js 用于弹窗、提示、下拉菜单 -->
  <script src="https://cdn.staticfile.org/popper.js/2.9.3/umd/popper.min.js"></script>
  <!-- 最新的 Bootstrap5 核心 JavaScript 文件 -->
  <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.min.js"></script>
  <!--icon連結-->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<?php
include('svg.php');
?>

<main>


  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-auto w-auto" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="10" height="8">
          <img src="images/Logo.png" class="navbar-brand resize" >
        </svg>
        <span class="fs-4">後台管理</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="a_index.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#calendar3" />
          </svg>
          首頁
        </a>
      </li>
      <li>
        <a href="a_manuser.php" class="nav-link text-white" aria-current="page">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#people-circle" />
          </svg>
          會員管理
        </a>
      </li>
      <li>
        <a href="a_manproduct.php" class="nav-link text-white ">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#calendar3" />
          </svg>
          商品管理
        </a>
      </li>
      <li>
        <a href="a_mansupplier.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#calendar3" />
          </svg>
          供應商管理
        </a>
      </li>
      <li>
        <a href="a_manpurchase.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#calendar3" />
          </svg>
          進貨管理
        </a>
      </li>
      <li>
        <a href="a_manorder.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#collection" />
          </svg>
          訂單管理
        </a>
      </li>
      <li>
        <a href="a_reorder.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#collection" />
          </svg>
          退貨管理
        </a>
      </li>
      <li>
        <a href="a_manbulletin.php" class="nav-link text-white  ">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#table" />
          </svg>
          公告欄管理
        </a>
      </li>
      <li>
        <a href="a_manchat.php" class="nav-link text-white active">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#chat-quote-fill" />
          </svg>
          客服中心
        </a>
      </li>
      <li>
        <a href="a_setting.php" class="nav-link text-white ">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#tools" />
          </svg>
          設定
        </a>
      </li>
      <li>
        <a href="" class="nav-link text-white ">
        </a>
      </li>
      <li>
        <a href="" class="nav-link text-white ">
        </a>
      </li>
      <li>
        <a href="" class="nav-link text-white ">
        </a>
      </li>
      <li>
        <a href="" class="nav-link text-white ">
        </a>
      </li>
      <li>
        <a href="" class="nav-link text-white ">
        </a>
      </li>
      <li>
        <a href="" class="nav-link text-white ">
        </a>
      </li>
    </ul>
    <hr>
  </div>
  <div class="b-example-divider"></div>

  <body>
    <div class="container w-50">
      <h3>客服中心:</h3>

      <form action="" id="reg_form" method="POST">
        <p>輸入訊息:<span class="chat_hint"></span><br>
          <input type="text" class="reg_chat" name="chat" id="reg_chat" required>
          <button type="button" class="submit">送出</button>
        </p>
      </form>
      <div>

        <script type="text/javascript">
          //javascript 
          var chat_Boolean = false;
          $('.reg_chat').blur(function() {
            if ($(".reg_chat").val() != '') {
              $('.chat_hint').html(" ✔ ").css("color", "green");
              $('.reg_chat').css("border", "1px solid green");
              chat_Boolean = true;
            } else {
              $('.chat_hint').html(" × 不能空白").css("color", "red");
              $('.reg_chat').css("border", "1px solid red");
              chat_Boolean = false;
            }
          });
          // click
          $('.red_button').click(function() {
            if (chat_Boolean == true) {
              document.getElementById("reg_form").submit();
            } else {
              alert("請確認資料輸入正確");
            }
          });
        </script>
        <hr>
        <div class="container">
          <?php

          if ($total_message != 0) {

            do {
              if ($NAME == $row_message["account"]) {
                echo '<div align="left" class="speech-bubble">來自帳號root<br>';
              } else {
                echo '<div align="right" class="speech-bubblee">來自帳號' . $row_message["account"] . '<br>';
              }

              echo '<font size="2">#' . $row_message['id'] . ' ' . $row_message['datetime'] . ' From ' . $row_message['ip'] . '</font>';
              echo '<div style="width:100%;overflow:auto">' . htmlentities($row_message['message']) . '</div>';
              echo '</div>';
              echo '<hr>';
            } while ($row_message = mysqli_fetch_assoc($message));
          }
          ?>
        </div>
</main>
</body>

</html>
<style>
  i.fa-shopping-cart {
    color: white;
  }

  .size {
    width: 300px;
  }

  .speech-bubble {
    position: relative;
    background: #e69e9e;
    border-radius: .4em;
  }

  .speech-bubble:after {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 0;
    height: 0;
    border: 45px solid transparent;
    border-right-color: #e69e9e;
    border-left: 0;
    border-bottom: 0;
    margin-top: -22.5px;
    margin-left: -45px;
  }

  .speech-bubblee {
    position: relative;
    background: #d6d6d6;
    border-radius: .4em;
  }

  .speech-bubblee:after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    width: 0;
    height: 0;
    border: 45px solid transparent;
    border-left-color: #d6d6d6;
    border-right: 0;
    border-bottom: 0;
    margin-top: -22.5px;
    margin-right: -45px;
  }
  .resize {
    width: auto;
    width: 150px;
  }

  .resize {
    height: auto;
    height: 75px;
  }
</style>