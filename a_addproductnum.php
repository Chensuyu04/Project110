<?php
include('function.php');
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <script src="ckeditor/ckeditor.js"></script>
  <script src="ckfinder/ckfinder.js"></script>
  <title>商品進貨</title>
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
      height: 100vh;
      height: -webkit-fill-available;
      max-height: 100vh;
      overflow-x: auto;
    }

    .b-example-divider {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
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
  <script>
    //只能輸入整數
    function keynum1(e, pnumber) {
      if (!/^\d+$/.test(pnumber)) {
        e.value = /^\d+/.exec(e.value);
      }
      return false;
    }
  </script>
</head>

<body>
  <?php
  include('svg.php');
  ?>

  <main>


    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-auto w-auto" style="width: 280px;">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi me-2" width="10" height="8">
          <img src="images/Logo.png" class="navbar-brand">
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
          <a href="a_manproduct.php" class="nav-link text-white active">
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
          <a href="a_manchat.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#chat-quote-fill" />
            </svg>
            客服中心
          </a>
        </li>
        <li>
          <a href="a_setting.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#tools" />
            </svg>
            設定
          </a>
        </li>
      </ul>
      <hr>
    </div>
    <div class="b-example-divider"></div>

    <div class="container pt-3 w-auto">
      <br>
      <?php
      $query = "SELECT * FROM `products` where `p_id`='" . $_GET["p_id"] . "'";
      $result = mysqli_query($db_link, $query);
      while ($rows = $result->fetch_assoc()) {
        echo <<<_END
          <form method="POST"><br>
          <img src=$rows[p_img] id='g_img' class="resize"><br><br>
          <hr>
          名稱：$rows[p_name]<br>
          類別：
          _END;
        $product_name = $rows["p_name"];
        $product = $rows["p_id"];
        $sql = "SELECT * FROM `setting` where `s_class`='商品分類'";
        $result = mysqli_query($db_link, $sql);
        while ($row = $result->fetch_assoc()) {
          if ($row["s_content"] == $rows["p_class"])
            echo  $row["s_name"] . "<br>";
        }
        echo <<<_END
          庫存剩餘：$rows[p_num]<br>
          _END;
        if ($rows["p_status"] == "0") {
          echo <<<_END
              上下架狀態：下架中<br>
              進貨數量：<input type="text" name="addnum" class="text"><br>
              進貨單價：<input type="text" name="cost" class="text" required=''><br>
              進貨日期:<input type="date" name="date" required='' >
              <input type="submit" name="addnum" value="進貨" class="btn btn-secondary">
              </form>
              _END;
        } else {
          echo <<<_END
              上下架狀態：上架中<br>
              _END;
          $sql_su_id = "SELECT * FROM `suppliers`";
          $result_su_id = mysqli_query($db_link, $sql_su_id);
          echo "供應商名稱:";
          echo "<select name='su_id' size='1'>";
          while ($row = $result_su_id->fetch_assoc()) {
            echo "<option value='" . $row["su_id"] . "'>" . $row["su_name"] . "</option>";
          }
          echo "</select>";
          echo <<<_END
              <br>
              進貨數量：<input type="text" name="num" class="text" required=''><br>
              進貨單價：<input type="text" name="cost" class="text" required=''><br>
              進貨日期:<input type="date" name="date" required='' >
              <input type="submit" name="addnum" value="進貨" class="btn btn-secondary">
              <br>
              </form>
              _END;
        }
      }
      if (isset($_POST["addnum"])) {
        $query = "SELECT * FROM `products` where `p_id`='" . $_GET["p_id"] . "' ";
        $result = mysqli_query($db_link, $query);
        $product_num = $result->fetch_assoc();
        $product_name = $product_num["p_name"];
        $num = $product_num["p_num"];
        $newnum = $num + $_POST["num"];
        $update = "UPDATE `products` SET `p_num` = '" . $newnum . "' WHERE `p_id` ='" . $_GET["p_id"] . "'";
        $result = mysqli_query($db_link, $update);
        $sql_name = "SELECT * FROM `suppliers` WHERE `su_id` = '" . $_POST["su_id"] . "'";
        $result_name = mysqli_query($db_link, $sql_name);
        $su_name = $result_name->fetch_assoc();
        $purchase = "INSERT INTO `purchase` (`pu_product`, `pu_product_name`, `su_id`, `su_name`, `pu_quantity`, `pu_cost`, `pu_date`) 
                VALUES ( '" . $product . "','" . $product_name . "', '" . $_POST["su_id"] . "', '" . $su_name["su_name"] . "', '" . $_POST["num"] . "', '" . $_POST["cost"] . "', '" . $_POST["date"] . "')";
        $result = mysqli_query($db_link, $purchase);
        echo "<script>alert('進貨成功');location.href='a_manproduct.php';</script>";
      }
      ?>
    </div>

  </main>

</body>

</html>
<script>
  var editor = CKEDITOR.replace('content', {
    customConfig: '/ckeditor/config.js'
  });
  CKFinder.setupCKEditor(editor, '/ckfinder/');
</script>
<style>
  .resize {
    width: auto;
    width: 150px;
  }

  .resize {
    height: auto;
    height: 150px;
  }

  tr,
  td {
    border: 1px solid #666;
  }

  td:hover {
    background-color: #E6FBFF;
  }

  .text {
    width: 180px;
    height: 25px;
  }
</style>