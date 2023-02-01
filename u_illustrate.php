<?php
include('function.php');
session_start();

$sql = "SELECT * FROM `products` WHERE `p_status`= 1";
if ($_GET["selectAD"] != "") {
  if ($_GET["selectAD"] == "ASC")
    $sql = "SELECT * FROM `products` where `p_status`= 1 order by `p_price` ASC";
  if ($_GET["selectAD"] == "DESC")
    $sql = "SELECT * FROM `products` where `p_status`= 1 order by `p_price` DESC";
}
if ($_GET["class"] != "") {
  $sql = "SELECT * FROM `products` WHERE  `p_class`='" . $_GET["class"] . "' and `p_status`= 1";
}
if ($_GET["p_search"] != "") {
  $sql = "SELECT * FROM `products` WHERE `p_name` LIKE '%" . $_GET['p_search'] . "%' and `p_status`= 1";
  if ($_GET["class"] != "") {
    $sql = "SELECT * FROM `products` WHERE `p_name` LIKE '%" . $_GET['p_search'] . "%' and `p_class`='" . $_GET["class"] . "' and `p_status`= 1";
  }
}
$result = mysqli_query($db_link, $sql) or die($sql);
//分頁設定
$per_total = mysqli_num_rows($result);  //計算總筆數

if ($_GET['selectpage'] == NULL) { //每頁筆數; 初始值設10
  $per = 10;
} else {
  $per = $_GET['selectpage'];
}

$pages = ceil($per_total / $per);  //計算總頁數;ceil(x)取>=x的整數,也就是小數無條件進1法

if (!isset($_GET['page'])) {  // !isset 判斷有沒有設置 $_GET['page'] 這個變數
  $page = 1;
} elseif ($_GET['page'] > $pages) {  //判斷傳來的$_GET['page']值,超過就為最後一頁
  $page = $pages;
} else {
  $page = $_GET['page'];
}

$start = ($page - 1) * $per;  //每一頁開始的資料序號(資料庫序號是從0開始)
$result = mysqli_query($db_link, $sql . ' LIMIT ' . $start . ', ' . $per) or die('MySQL query error'); //讀取選取頁的資料

$page_start = $start + 1;  //選取頁的起始筆數
$page_end = $start + $per;  //選取頁的最後筆數
if ($page_end > $per_total) {  //最後頁的最後筆數=總筆數
  $page_end = $per_total;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>挑選說明</title>
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
  <div class="container mt-3">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
      <li class="breadcrumb-item active">常見問題</li>
    </ul>
  </div>

  <div class="text-center">
    <img src="images/original.jpg" class="img-fluid" alt="...">
  </div>
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