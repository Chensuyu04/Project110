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
  <title>結帳</title>
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
    <ul class="breadcrumb w-auto">
      <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
      <li class="breadcrumb-item"><a href="u_shop.php">購物車</a></li>
      <li class="breadcrumb-item active">結帳</li>
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
        $total_price = 0;
        while ($rows = $result->fetch_array()) {
          echo '<form method="POST">';
          //將各個產品資料存進陣列
          $c_id[] = $rows['s_id'];
          $c_pid[] = $rows['s_pid'];
          $c_num[] = $rows['s_num'];

          $search_product = "SELECT * FROM `products` where `p_id`='" . $rows["s_pid"] . "'";
          $search_result = mysqli_query($db_link, $search_product);
          $row = $search_result->fetch_assoc();
          $sum = $row['p_price'] * $rows['s_num'];

          echo '<div class="row">';
          echo '<div class="col-md-5 bg-light p-3">';
          //echo '<input type="checkbox" name="products[]" value="'.$rows['s_pid'].'">';
          echo '<img src="' . $row['p_img'] . '" class=resize>';
          echo '</div>';
          echo '<div class="col-sm-7 bg-light p-3">';
          echo <<<_END
        名稱：$row[p_name]<br>
        單價：$row[p_price]<br>
        數量：$rows[s_num]<br>
        <div align="right"><font size="1">小計:$sum</font></div>
        <input type="hidden" name="s_id" value=$rows[s_pid]>
        _END;
          $num++;
          $total_price += $sum;
          echo '</div>';
          echo '</div>';
          if ($num_rows == $num) {
            echo <<<_END
            <br>
            <p align='right'>
            <select name="select" id="select" onchange=checkField(this.value) size="1">
                <option value="no">選擇</option>
                <option value="60">貨到付款</option>
                <option value="100">配送到府</option>
            </select><br>
            _END;
            if (isset($_GET["ShopingFee"]) && $_GET["ShopingFee"] != "undefined") {
              $query = "SELECT * FROM `users` where `u_account`='" . $_SESSION["account"] . "'";
              $result = mysqli_query($db_link, $query);
              $rows = $result->fetch_assoc();
              echo <<<_END
                <div class="form-floating mb-3">
                    <input type="text" placeholder="姓名" name="name" class="form-control" id="floatingname" required="" value=$rows[u_name]>
                    <label for="floatingInput">姓名</label>    
                </div>
                <div class="form-floating mb-3">
                    <input type="text" placeholder="電話" name="phone" id="phone" pattern="09\d{8}" class="form-control" value=$rows[u_phone]>
                    <label for="floatingInput">電話</label>   
                </div>
                <div class="form-floating mb-3">
                    <input type="text" placeholder="地址" name="address" id="address" class="form-control" value=$rows[u_address]>
                    <label for="floatingInput">地址</label>   
                </div>
                _END;
              if ($_GET["ShopingFee"] == 60) {
                $sql_fre = "SELECT * FROM `setting` where `s_name`='貨到付款'";
                $result_fre = mysqli_query($db_link, $sql_fre);
                $row_fre = $result_fre->fetch_assoc();
                if ($total_price < $row_fre["s_content"]) {
                  $total_price = $total_price + $_GET["ShopingFee"];
                  echo '<div align="right">總和:$NT' . $total_price . '(含運費60)</div>';
                } else {
                  echo '<div align="right">總和:$NT' . $total_price . '(貨到付款' . $row_fre["s_content"] . '免運)</div>';
                }
              } else {
                $sql_fre = "SELECT * FROM `setting` where `s_name`='配送'";
                $result_fre = mysqli_query($db_link, $sql_fre);
                $row_fre = $result_fre->fetch_assoc();
                if ($total_price < $row_fre["s_content"]) {
                  $total_price = $total_price + $_GET["ShopingFee"];
                  echo '<div align="right">總和:$NT' . $total_price . '(含運費100)</div>';
                } else {
                  echo '<div align="right">總和:$NT' . $total_price . '(貨到付款' . $row_fre["s_content"] . '免運)</div>';
                }
              }


              echo "<input type='hidden' name='total' value=$total_price>";
              echo "<div align='right'><input type = 'submit' class='submit' name='pay' value = '送出'></input></div>";
            }
          }
          echo '</form>';
        }
        if (isset($_POST["pay"])) {

          $date = date('Y-m-d');
          if ($_GET["ShopingFee"] == "60") {
            $ins = "INSERT INTO `orders` (`o_account`, `o_total`, `o_time`, `o_name`, `o_address`, `o_phone`, `o_payby`, `o_settle`, `o_arrtime`, `o_finishtime`) 
        VALUES ('" . $_SESSION["account"] . "','" . $_POST["total"] . "','$date','" . $_POST["name"] . "','" . $_POST["address"] . "','" . $_POST["phone"] . "','貨到付款','0','0','0')";
          } else {
            $ins = "INSERT INTO `orders` (`o_account`, `o_total`, `o_time`, `o_name`, `o_address`, `o_phone`, `o_payby`, `o_settle`, `o_arrtime`, `o_finishtime`) 
        VALUES ('" . $_SESSION["account"] . "','" . $_POST["total"] . "','$date','" . $_POST["name"] . "','" . $_POST["address"] . "','" . $_POST["phone"] . "','配送到府','0','0','0')";
          }
          $result_orders = mysqli_query($db_link, $ins);
          $query = "SELECT * FROM `orders` order by `o_id` DESC limit 1";
          $result = mysqli_query($db_link, $query);
          $row = $result->fetch_assoc();
          for ($i = 0; $i < count($c_id); $i++) {
            $date = date('Y-m-d');
            $query = "SELECT * FROM `products` where `p_id`='" . $c_pid[$i] . "' ";
            $result = mysqli_query($db_link, $query);
            $product_data = $result->fetch_assoc();
            //購物車轉明細
            $ins = "INSERT INTO `orderdetails` (`o_id`, `od_pid`, `od_num`, `od_time`) 
                    VALUES ('" . $row["o_id"] . "','" . $product_data["p_id"] . "','" . $c_num[$i] . "','$date')";
            $result_orders = mysqli_query($db_link, $ins);
            //刪除購物車內容
            $del = "DELETE FROM `shop` WHERE `s_id`='" . $c_id[$i] . "'";
            $result_del = mysqli_query($db_link, $del);
            //尋找產品庫存
            $product_num = "SELECT * FROM `products` where `p_id`='" . $c_pid[$i] . "'";
            $result_num = mysqli_query($db_link, $product_num);
            $p_num = $result_num->fetch_assoc();
            //計算庫存並更新
            $new_num = $p_num["p_num"] - $c_num[$i];
            $updete = "UPDATE `products` SET `p_num`='" . $new_num . "' WHERE `p_id`='" . $p_num["p_id"] . "'";
            $result_up = mysqli_query($db_link, $updete);
            //寄送通知
            if ($new_num <= $p_num["p_squantity"]) {

              $Value = $p_num["p_name"] . "低於安全存量，請盡速補貨!";
              $msg = array("value1" => "$Value");
              $url = "https://maker.ifttt.com/trigger/test_to_line/with/key/d56AMM4l45ICVH9-FCIgMA";
              $querydata = http_build_query($msg);
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $querydata);
              $result = curl_exec($ch);
              curl_close($ch);
            }
          }
          echo "<script>alert('訂單已送出');location.href='u_product.php';</script>";
        }
        ?>

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
    width: 120px;
  }

  .resize {
    height: auto;
    height: 120px;
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

<script>
  function checkField(val) {
    if (val == '60')
      var ShopingFee = 60;
    else if (val == '100')
      var ShopingFee = 100;
    location.href = "u_checkout.php?ShopingFee=" + ShopingFee;
  }
  document.getElementById('select').value = '<?= $_GET['ShopingFee'] ?>';
</script>