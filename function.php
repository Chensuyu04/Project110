<html>
<header>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
</header>

<body>

</body>

</html>

<?php
header("content-type:text/html;charset=utf-8");
//登入資料庫
$ac = "root";
$pw = "mysql";
$db = "project110";
$db_link = @mysqli_connect("localhost", $ac, $pw, $db) //伺服器,帳號,密碼,資料庫
	or die("mysql伺服器連結失敗");
//資料庫語言編碼
mysqli_query($db_link, "SET NAME 'utf8'");
?>
<br>
<style>
	.navbar-brand {
		width: 100px;
	}

	.square {
		animation-duration: 3s;
		animation-name: slidein;
	}

	@keyframes slidein {
		from {
			padding-top: 100%;
			width: 100%;
		}

		to {
			padding-bottom: 0%;
			width: 100%;
		}
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
</style>