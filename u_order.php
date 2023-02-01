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
  <title>查看訂單</title>
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
      <li class="breadcrumb-item active">訂單查詢</li>
    </ul>
  </div>

  <span class="border border-white w-auto">
    <div class=" container w-auto " align="center">
      <?php
      $sql = "SELECT * FROM `orders` where `o_account`='" . $_SESSION["account"] . "'";
      $result = mysqli_query($db_link, $sql) or die($sql);
      //判斷有無搜尋到資料(start) 
      echo <<<_END
    <table class="table table-striped table-bordered ">
    <thead>
    <tr>
    <td>訂單編號</td>
    <td>總金額</td>
    <td>下單時間</td>
    <td>到貨日期</td>
    <td>簽收日期</td>
    <td>付款方式</td>
    <td>訂單狀況</td>
    </tr>
    </thead>
    _END;
      echo "<tbody>";

      while ($row = $result->fetch_assoc()) {
        echo '<form method="POST""><tr>';
        echo "";
        echo <<<_END
            <td><a href=u_order.php data-bs-toggle="modal" data-bs-target="#exampleModal$row[o_id]">$row[o_id]</a>
            _END;


        echo <<<_END
            <div class="modal fade" id="exampleModal$row[o_id]" tabindex="-1" aria-labelledby="exampleModalLabel$row[o_id]" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel$row[o_id]">$row[o_id]的訂單明細</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
            _END;
        $sql_od = "SELECT * FROM `orderdetails` where `o_id`='" . $row["o_id"] . "'";
        $result_od = mysqli_query($db_link, $sql_od) or die($sql_od);
        while ($rows = $result_od->fetch_array()) {
          $query = "select * from `products` where `p_id`='" . $rows["od_pid"] . "'";
          $result_g = mysqli_query($db_link, $query);
          $rowss = $result_g->fetch_array();
          echo <<<_END
                    <img src=$rowss[p_img] class=resize><br>
                    名稱：$rowss[p_name]<br>
                    單價：$rowss[p_price]<br>
                    數量：$rows[od_num]<br>
                    <hr>
            _END;
        }
        echo <<<_END
                  </div>
                </div>
              </div>
            </div>
            </td>
          _END;
        echo "<td>" . $row["o_total"] . "</td>";
        echo "<td>" . $row["o_time"] . "</td>";
        if ($row["o_arrtime"] == "0") {
          echo "<td>待確認時間</td>";
        } else {
          echo "<td>" . $row["o_arrtime"] . "</td>";
        }
        if ($row["o_finishtime"] == "0") {
          echo "<td>待確認時間</td>";
        } else {
          echo "<td>" . $row["o_finishtime"] . "</td>";
        }

        echo "<td>" . $row["o_payby"] . "</td>";
        if ($row["o_settle"] == "0") {
          echo "<td>待處理</td>";
          echo '<td><button name="cancel"  onclick=\'return confirm("確認是否要取消訂單")\'>取消訂單</button></td>';
        } else if ($row["o_settle"] == "1") {
          echo "<td>訂單已確認待出貨</td>";
          echo '<td><button name="cancel"  onclick=\'return confirm("確認是否要取消訂單")\'>取消訂單</button></td>';
        } else if ($row["o_settle"] == "2") {
          echo "<td>已出貨</td>";
          echo '<td><button name="return"  onclick=\'return confirm("確認是否要申請退貨")\'>申請退貨</button></td>';
        } else if ($row["o_settle"] == "3") {
          echo "<td>已完成</td>";
        } else if ($row["o_settle"] == "4") {
          echo "<td>待取消</td>";
        } else if ($row["o_settle"] == "5") {
          echo "<td>已取消訂單</td>";
        } else if ($row["o_settle"] == "6") {
          echo "<td>待退貨</td>";
        } else if ($row["o_settle"] == "7") {
          echo "<td>查驗商品中</td>";
        } else if ($row["o_settle"] == "8") {
          echo "<td>已退貨</td>";
        }
        echo "<input type='hidden' name='n' value='" . $row["o_id"] . "'>";
        echo "</form>";
      }
      echo "</tbody>";
      echo "</table>";
      if (isset($_POST["cancel"])) {
        $update = "UPDATE `orders` SET `o_settle`='4' WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('已送出');location.href='u_order.php';</script>";
      }
      if (isset($_POST["return"])) {
        $update = "UPDATE `orders` SET `o_settle`='6' WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('已送出退貨申請');location.href='u_order.php';</script>";
      }
      if ($_GET["o_id"] != "") {
        $sql = "SELECT * FROM `orderdetails` where `o_id`='" . $_GET["o_id"] . "'";
        $result = mysqli_query($db_link, $sql) or die($sql);
        $rows = mysqli_fetch_assoc($result);
        $query = "select * from `products` where `p_id`='" . $rows["od_pid"] . "'";
        $result_g = mysqli_query($db_link, $query);
        $row = $result_g->fetch_array();
      }
      ?>
    </div>
  </span>
  <?php
  include('footer.php');
  ?>
</body>

</html>
<style>
  i.fa-shopping-cart {
    color: black;
  }

  .resize {
    width: auto;
    width: 225px;
  }

  .resize {
    height: auto;
    height: 150px;
  }
</style>