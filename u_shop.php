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
  <title>購物車</title>
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
  <div class="container pt-3 w-auto">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
      <li class="breadcrumb-item active">購物車</li>
    </ul>
  </div>
  <span class="border border-white w-auto">
    <div class=" container w-auto">
      <div class="container w-auto">
        <?php
        $query = "SELECT * FROM `shop` where `s_account`='" . $_SESSION["account"] . "'";
        $result = mysqli_query($db_link, $query);
        $num_rows = mysqli_num_rows($result);
        $num = 0;
        while ($rows = $result->fetch_array()) {
          $search_product = "SELECT * FROM `products` where `p_id`='" . $rows["s_pid"] . "'";
          $search_result = mysqli_query($db_link, $search_product);
          $row = $search_result->fetch_assoc();
          echo '<form method="POST">';
          echo '<div class="row">';
          echo '<div class="col-md-5 bg-light p-3">';
          //echo '<input type="checkbox" name="products[]" value="'.$rows['s_pid'].'">';
          echo '<img src="' . $row['p_img'] . '" class=resize>';
          echo '</div>';
          echo '<div class="col-sm-7 bg-light p-3">';
          echo <<<_END
        名稱：$row[p_name]<br>
        單價：$row[p_price]<br>
        數量：
        <input type="number" name="num"  min="1" max=$row[p_num] value=$rows[3] class="border" id="num">
        <input type="hidden" name="s_id" value=$rows[s_pid]>
        <input type="submit" name="up" value="更改" class=submit>
        <input type="submit" name="del" value="刪除" class=submit>
        _END;
          $num++;
          echo '</div>';
          echo '</div>';
          echo '</form>';
        }

        if (isset($_POST["up"])) {
          $update = "UPDATE `shop` SET `s_num`='" . $_POST["num"] . "' where `s_account`='" . $_SESSION["account"] . "'and `s_pid`='" . $_POST["s_id"] . "'";
          $result = mysqli_query($db_link, $update);
          echo "<script>alert('更改成功');location.href='u_shop.php';</script>";
        }
        if (isset($_POST["del"])) {
          $del = "DELETE FROM `shop` WHERE `s_account`='" . $_SESSION["account"] . "'and `s_pid`='" . $_POST["s_id"] . "'";
          $result = mysqli_query($db_link, $del);
          echo "<script>alert('刪除成功');location.href='u_shop.php';</script>";
        }
        ?>
        <div align="right"><input type='button' class="submit" onclick="javascript:location.href='u_checkout.php'" value='結帳'></input></div>
      </div>
    </div>
  </span>
</body>

</html>
<style>
  i.fa-shopping-cart {
    color: black;
  }

  .resize {
    width: auto;
    width: 180px;
  }

  .resize {
    height: auto;
    height: 180px;
  }

  .submit {
    border: 0;
    background-color: #808080;
    color: #fff;
    border-radius: 5px;
    width: 100px;
    height: 30px;
    font-size: 20;
  }
</style>