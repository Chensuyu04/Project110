<link rel="stylesheet" type="text/css" href="talk.scss">
<?php
include('function.php');
date_default_timezone_set('Asia/Shanghai'); //設定時間
require_once('config.php'); //載入設定檔
if (!isset($_SESSION)) {
	session_start();
} //開啟 SESSION
db_connect();	//連建
/*db_connect 資料庫連接 */
function db_connect()
{
	global $connect, $db_hostname, $db_database_connect, $db_username_connect, $db_password_connect;	//用 global 載入 config.php 的資料
	/*連線資料庫伺服器*/
	$connect = mysqli_connect($db_hostname, $db_username_connect, $db_password_connect, $db_database_connect);
	if (empty($connect)) {
		print mysqli_error($connect);	//輸出錯誤
		die('無法連結資料庫');
		exit;
	}
	mysqli_query($connect, "SET NAMES 'utf8'");	//設定連線的文字集與校對為 UTF8 編碼
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
	$sql = "SELECT * FROM `message` where `account`='" . $_SESSION["account"] . "' ORDER BY `datetime` DESC LIMIT 1";
	$result = mysqli_query($connect, $sql);
	$row = mysqli_fetch_assoc($result);
	$ans_num = $row["answer"] + 1;
	$insertSQL = "INSERT INTO message (message, datetime, ip , account, answer) VALUES ('$msg', '$nowtime','$userip','" . $_SESSION["account"] . "','$ans_num')";
	$Result = mysqli_query($connect, $insertSQL) or die(mysqli_error($connect));
	echo $sql;
}

//======送出POST動作======
if (isset($_POST['chat'])) {
	$msg = $_POST['chat'];
	SendMessage($msg);
}

//======讀取聊天內容======
$NAME = "root" . $_SESSION["account"];
$message_query = "SELECT * FROM message where account='" . $_SESSION["account"] . "' or account='" . $NAME . "' ORDER BY CAST(`id` AS UNSIGNED) DESC";
$message = mysqli_query($connect, $message_query) or die(mysqli_error($connect));
$row_message = mysqli_fetch_assoc($message);
$total_message = mysqli_num_rows($message);



?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>客服中心</title>
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
<div class="container mt-3">
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
		<li class="breadcrumb-item active">聊天室</li>
	</ul>
</div>

<body>
	<div class="container w-75">
		<h3>詢問問題:</h3>

		<form action="" id="reg_form" method="POST">
			<p>輸入訊息:<span class="chat_hint"></span><br>
				<input type="text" class="reg_chat" name="chat" class="form-control form-control-user reg_vcode" id="reg_chat" required>
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
							echo '<div align="left" class="speech-bubble">來自管理者傳送的訊息<br>';
						} else {
							echo '<div align="right" class="speech-bubblee">來自我傳送的訊息<br>';
						}
						echo '<font size="2">#' . $row_message['id'] . ' ' . $row_message['datetime'] . ' From ' . $row_message['ip'] . '</font>';
						echo '<div style="width:100%;overflow:auto">' . htmlentities($row_message['message']) . '</div>';
						echo '</div><br>';
					} while ($row_message = mysqli_fetch_assoc($message));
				}
				?>
			</div>
			<?php
			include('footer.php');
			?>
</body>

</html>
<style>
	i.fa-shopping-cart {
		color: black;
	}

	.size {
		width: 300px;
	}
</style>