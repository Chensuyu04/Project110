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
  <title>首頁</title>
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
  <div class="container w-auto p-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">首頁</a></li>
        <li class="breadcrumb-item active" aria-current="page"></li>
      </ol>
    </nav>
  </div>
  <div class="container pt-3 w-auto">
    <!-- 轮播 -->
    <div id="demo" class="carousel slide square" data-bs-ride="carousel">

      <!-- 指示符 -->
      <div class="carousel-indicators">
        <?php
        $sql = "SELECT * FROM `setting` where `s_class`='輪播圖片'";
        $result = mysqli_query($db_link, $sql);
        $num = mysqli_num_rows($result);
        $lastnum = 0;
        for ($i = 0; $i < $num; $i++) {
          if ($lastnum == 0) {
            echo <<<_END
      
        <button type="button" data-bs-target="#demo" data-bs-slide-to=$lastnum class="active"></button>
      
      _END;
          } else {
            echo <<<_END
        <button type="button" data-bs-target="#demo" data-bs-slide-to=$lastnum></button>
      _END;
          }
          $lastnum++;
        }
        ?>
      </div>
      <!-- 轮播图片 -->
      <div class="carousel-inner resize">
        <?php
        $sql = "SELECT * FROM `setting` where `s_class`='輪播圖片'";
        $result = mysqli_query($db_link, $sql);
        $lastnum = 0;
        while ($row = $result->fetch_assoc()) {
          if ($lastnum == 0) {
            echo <<<_END
      <div class="carousel-item active">
        <img src=$row[s_content] class="d-block" style="width:100%">
      </div>
      _END;
          } else {
            echo <<<_END
      <div class="carousel-item">
        <img src=$row[s_content] class="d-block" style="width:100%">
      </div>
      _END;
          }
          $lastnum++;
        }
        ?>
      </div>

      <!-- 左右切换按钮 -->
      <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
      <hr>
    </div>
    <h2 align="center">公告</h2>
    <i class="fas fa-megaphone"></i>&nbsp/&nbsp置頂&nbsp<br>
    <span class="blink">
      <font size="2">new&nbsp;</font>
    </span>&nbsp/&nbsp近期新增&nbsp<br><br><br>
    <?php
    $sql = "SELECT * FROM `bulletin` where `b_settle`='1' and `b_top`='1' order by `b_time` DESC";
    $result = mysqli_query($db_link, $sql);
    while ($row = $result->fetch_assoc()) {
      $date = date('Y-m-d');
      if ($row["b_time"] <= $date && $row["b_timedown"] >= $date) {
        echo <<<_END
            <i class="fas fa-megaphone"></i>&nbsp&nbsp
            <font size="4.5"><a href='u_bulletin.php?id=$row[b_id]' class=link-dark>$row[b_title]&nbsp;&nbsp;&nbsp;</a></font>
            <font color="#808080" size="2">$row[b_time]<hr></font>
            _END;
      }
    }
    $sql = "SELECT * FROM `bulletin` where `b_settle`='1' and `b_top`='0' order by `b_time` DESC";
    $result = mysqli_query($db_link, $sql);
    while ($row = $result->fetch_assoc()) {
      $date = date('Y-m-d');
      if ($row["b_time"] <= $date && $row["b_timedown"] >= $date) {
        $day = (strtotime($date) - strtotime($row["b_time"])) / (60 * 60 * 24);
        if ($day <= 3) {
          echo <<<_END
          <span class="blink"><font size="2">new&nbsp;</font></span>
          <font size="4.5"><a href='u_bulletin.php?id=$row[b_id]' class=link-dark>$row[b_title]&nbsp;&nbsp;&nbsp;</a></font>
          <font color="#808080" size="2">$row[b_time]<hr></font>
          _END;
        } else {
          echo <<<_END
          &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          <font size="4.5"><a href='u_bulletin.php?id=$row[b_id]' class=link-dark>$row[b_title]&nbsp;&nbsp;&nbsp;</a></font>
          <font color="#808080" size="2">$row[b_time]<hr></font>
          _END;
        }
      }
    }

    ?>
    <div class="bob-container" align="center">
      <div class="bob-row">
        <div class="bob-4item">
          <img src="images/底圖1.png" with="100" heigh="100">
          <div style="height:43px;">優良品質</div>
        </div>
        <div class="bob-4item">
          <img src="images/底圖2.png">
          <div style="height:43px;">完善服務</div>
        </div>
        <div class="bob-4item">
          <img src="images/底圖3.png">
          <div style="height:43px;">快速到府</div>
        </div>
        <div class="bob-4item">
          <img src="images/底圖4.png">
          <div style="height:43px;">誠信第一</div>
        </div>
      </div>
      <?php
      include('footer.php');
      ?>
    </div>
  </div>
</body>

</html>
<style>
  i.fa-shopping-cart {
    color: black;
  }

  .main {
    color: #666;
    margin-top: 50px;
  }

  .carousel {
    max-height: 700px;
    max-width: 1200px;
    width: auto;
    height: auto;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 60px;
    margin-top: 50px;

  }

  /* Since positioning the image, we need to help out the caption */
  /*.carousel-caption {
  z-index: 10;
}*/

  /* Declare heights because of positioning of img element */
  .carousel .item {
    width: 100%;
    height: 500px;
    min-height: 100px;
    background-color: #777;
  }

  .carousel-inner>.item>img {
    position: absolute;
    top: 0;
    left: 0;
    min-width: 100%;
    width: auto;
    height: auto;
  }

  /* 定义keyframe动画，命名为blink */
  @keyframes blink {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }

  /* 添加兼容性前缀 */
  @-webkit-keyframes blink {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }

  @-moz-keyframes blink {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }

  @-ms-keyframes blink {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }

  @-o-keyframes blink {
    0% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }

  /* 定义blink类*/
  .blink {
    color: #ff0000;
    animation: blink 1s linear infinite;
    /* 其它浏览器兼容性前缀 */
    -webkit-animation: blink 1s linear infinite;
    -moz-animation: blink 1s linear infinite;
    -ms-animation: blink 1s linear infinite;
    -o-animation: blink 1s linear infinite;
  }

  body {
    padding: 0;
    margin: 0;
  }

  * {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  /*---------這如果布景本身沒有在加就好 end---------*/

  .bob-container {
    margin: 0 auto;
    padding-left: 15px;
    padding-right: 15px;
  }

  .bob-row {
    margin-right: -15px;
    margin-left: -15px;
  }

  .bob-row:before,
  .bob-row:after {
    display: table;
    content: " ";
  }

  .bob-row:after {
    clear: both;
  }

  /*4個並排 在767px以下會2個排列*/
  .bob-4item {
    width: 50%;
  }

  .bob-4item {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    float: left;
  }

  .bob-2item img,
  .bob-3item img,
  .bob-4item img {
    width: 50%;
    display: block;
  }

  @media (min-width: 768px) {
    .bob-container {
      width: 750px;
    }

    .bob-3item {
      width: 33.33333333%;
    }

    .bob-4item {
      width: 25%;
    }
  }

  @media (min-width: 992px) {
    .bob-container {
      width: 970px;
    }
  }

  @media (min-width: 1200px) {
    .bob-container {
      width: 1170px;
    }
  }
</style>