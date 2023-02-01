<?php
include('function.php');
?>
<html lang="en">

<head>
  <title>設定</title>
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

    <?php
    if ($_GET["class"] == "photo") {
    ?>main {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
      overflow-y: auto
    }

    <?php
    } else {
    ?>main {
      display: flex;
      flex-wrap: nowrap;
      height: 100vh;
      height: -webkit-fill-available;
      max-height: 100vh;
      overflow-x: auto;
      overflow-y: auto;
    }

    <?php
    }
    ?>main {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
      overflow-y: auto
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
          <a href="a_manchat.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#chat-quote-fill" />
            </svg>
            客服中心
          </a>
        </li>
        <li>
          <a href="a_setting.php" class="nav-link text-white active">
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

    <div class="container mt-3">
      <h2>設定</h2>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="a_setting.php?class=stop">停權設定</a>
          <?php
          if ($_GET["class"] == "stop") {
            echo "停權設定：<br>";
            $sql = "SELECT * FROM `setting` where `s_class`='停權設定' order by `s_content` ASC";
            $result = mysqli_query($db_link, $sql);
            $num = mysqli_num_rows($result);
            $lastnum = 0;
            while ($row = $result->fetch_assoc()) {
              echo '<form method="post">';
              echo $row["s_content"] . "天";
              echo "<input type='hidden' name='n' value='" . $row["s_id"] . "'>&nbsp";
              echo '<button name="del_stop" onclick=\'return confirm("是否刪除")\' class="btn"><i class="fas fa-trash-alt"></i></button><br>';
              $lastnum++;
              if ($lastnum == $num) {
                echo '<br><input type="text" name="ins_day" placeholder="輸入數字">';
                echo '<input type="submit" name="ins_stop" value="新增">';
              }

              echo '</form>';
            }
          }
          ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_setting.php?class=p_class">商品類別設定</a>
          <?php
          if ($_GET["class"] == "p_class") {
            echo "商品類別：<br><br>";
            $sql = "SELECT * FROM `setting` where `s_class`='商品分類'";
            $result = mysqli_query($db_link, $sql);
            $num = mysqli_num_rows($result);
            $lastnum = 0;
            while ($row = $result->fetch_assoc()) {
              echo '<form method="post">';
              echo "類型：" . $row["s_name"];
              echo "(代號：" . $row["s_content"] . ")&nbsp";
              echo "<input type='hidden' name='n' value='" . $row["s_id"] . "'>";
              echo "<input type='hidden' name='content' value='" . $row["s_content"] . "'>";
              echo '<button name="del_pclass" onclick=\'return confirm("是否刪除")\' class="btn"><i class="fas fa-trash-alt"></i></button><br>';
              $lastnum++;
              if ($lastnum == $num) {
                echo '<br><input type="text" name="ins_name" placeholder="輸入名稱">';
                echo '<br><input type="text" name="ins_class" placeholder="輸入代號">';
                echo '<input type="submit" name="ins_pclass" value="新增">';
              }
              echo '</form>';
            }
          }
          ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_setting.php?class=photo">輪播管理</a>
          <?php
          if ($_GET["class"] == "photo") {
            echo "輪播圖片設定：";
            $sql = "SELECT * FROM `setting` where `s_class`='輪播圖片'";
            $result = mysqli_query($db_link, $sql);
            $num = mysqli_num_rows($result);
            $lastnum = 0;
            while ($row = $result->fetch_assoc()) {
              echo '<form method="post" enctype="multipart/form-data">';
              echo "<img src=$row[s_content] class=resize>";
              echo "<input type='hidden' name='n' value='" . $row["s_id"] . "'>&nbsp";
              echo '<button name="del_photo" onclick=\'return confirm("是否刪除")\' class="btn"><i class="fas fa-trash-alt"></i></button><br>';
              $lastnum++;
              if ($lastnum == $num) {
                echo "<br><input type='file' value='瀏覽' name='upfile' id='upfile'>";
                echo '<input type="submit" name="ins_photo" value="新增">';
              }

              echo '</form>';
            }
          }
          /*<li class="nav-item">
                  <a class="nav-link" href="a_setting.php?class=discount">優惠卷設定</a>
                  <?php
                  if ($_GET["class"] == "discount") {
                    echo "優惠：<br><br>";
                    $sql = "SELECT * FROM `setting` where `s_class`='打折'";
                    $result = mysqli_query($db_link, $sql);
                    while ($row = $result->fetch_assoc()) {
                      echo '<form method="post">';
                      echo "幾折：" . $row["s_name"] . "折";
                      echo "(輸入代碼：" . $row["s_content"] . ")<br>";
                      echo "<input type='hidden' name='n' value='" . $row["s_id"] . "'>";
                      echo '</form>';
                    }
                  }
                  ?>
          </li>*/
          ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_setting.php?class=freight">免運限制</a>
          <?php
          if ($_GET["class"] == "freight") {
            echo "運費：<br><br>";
            $sql = "SELECT * FROM `setting` where `s_class`='運費'";
            $result = mysqli_query($db_link, $sql);
            while ($row = $result->fetch_assoc()) {
              echo '<form method="post">';
              echo $row["s_name"] . "：";
              echo "<input type='text' name='freight' value='" . $row["s_content"] . "'>";
              echo '<input type="submit" name="ins_freight" value="修改">';
              echo "<input type='hidden' name='n' value='" . $row["s_id"] . "'>";
              echo '</form>';
            }
          }
          ?>
        </li>
      </ul>
    </div>

    <?php
    //新增停權天數
    if (isset($_POST["ins_stop"])) {
      $ins = "INSERT INTO `setting` (`s_class`,`s_name`,`s_content`) VALUES ('停權設定','停權時間','" . $_POST["ins_day"] . "')";
      $result = mysqli_query($db_link, $ins);
      echo "<script>alert('新增成功');location.href='a_setting.php?class=stop';</script>";
    }
    //刪除天數
    if (isset($_POST["del_stop"])) {
      $del = "DELETE FROM `setting` WHERE `s_id`='" . $_POST["n"] . "'";
      $result = mysqli_query($db_link, $del);
      echo "<script>alert('刪除成功');location.href='a_setting.php?class=stop';</script>";
    }
    //新增商品類別
    if (isset($_POST["ins_pclass"])) {
      $ins = "INSERT INTO `setting` (`s_class`,`s_name`,`s_content`) VALUES ('商品分類','" . $_POST["ins_name"] . "','" . $_POST["ins_class"] . "')";
      $result = mysqli_query($db_link, $ins);
      echo "<script>alert('新增成功');location.href='a_setting.php?class=p_class';</script>";
    }
    //刪除商品類別
    if (isset($_POST["del_pclass"])) {
      $content = "SELECT * FROM `products` WHERE `p_class`='" . $_POST["content"] . "'";
      $result_content = mysqli_query($db_link, $content);
      $row_content = $result_content->fetch_assoc();
      if (isset($row_content)) {
        echo "<script>alert('此類別有商品正在上架中');location.href='a_setting.php?class=p_class';</script>";
      } else {
        $del = "DELETE FROM `setting` WHERE `s_id`='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $del);
        echo "<script>alert('刪除成功');location.href='a_setting.php?class=p_class';</script>";
      }
    }
    //新增輪播圖片
    if (isset($_POST["ins_photo"])) {
      $img_y = $_FILES['upfile']['name'];
      $file = $_FILES['upfile']['tmp_name'];
      $dest = 'images/' . $_FILES['upfile']['name'];
      # 將檔案移至指定位置
      move_uploaded_file($file, $dest);
      $ins = "INSERT INTO `setting` (`s_class`,`s_name`,`s_content`) VALUES ('輪播圖片','輪播圖片','images/" . $_FILES['upfile']['name'] . "')";
      $result = mysqli_query($db_link, $ins);
      echo "<script>alert('新增成功');location.href='a_setting.php?class=photo';</script>";
    }
    //刪除天數
    if (isset($_POST["del_photo"])) {
      $del = "DELETE FROM `setting` WHERE `s_id`='" . $_POST["n"] . "'";
      $result = mysqli_query($db_link, $del);
      echo "<script>alert('刪除成功');location.href='a_setting.php?class=photo';</script>";
    }
    if (isset($_POST["ins_freight"])) {
      $update = "UPDATE `setting` 
        SET `s_content`='" . $_POST["freight"] . "' where `s_id`='" . $_POST["n"] . "'";
      $result = mysqli_query($db_link, $update);
      echo "<script>alert('更改成功');location.href='a_setting.php?class=freight';</script>";
    }

    ?>

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
    width: 400px;
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

  .sel_size {
    width: 70px;
    height: 20px;
  }
</style>