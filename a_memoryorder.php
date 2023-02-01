<?php
include('function.php');
?>
<?php
if ($_GET['p_search'] == '') {
  $sql = 'SELECT * FROM `orders` WHERE `o_settle`= 3 and `o_time` LIKE "' . $_GET["month"] . '%"';
} else {
  if (!isset($_GET["month"])) {
    $sql = "SELECT * FROM `orders` WHERE `o_settle`= 3  and `o_account` LIKE '%" . $_GET['p_search'] . "%'";
  } else if (isset($_GET["month"])) {
    $sql = "SELECT * FROM `orders` WHERE `o_settle`= 3 and `o_account` LIKE '%" . $_GET['p_search'] . "%' and  `o_time` LIKE '" . $_GET["month"] . "%'";
  }
}
$result = mysqli_query($db_link, $sql) or die($sql);
//分頁設定
$per_total = mysqli_num_rows($result);
//計算總筆數

if ($_GET['selectpage'] == NULL) {
  //每頁筆數初始值設10;

  $per = 5;
} else {
  $per = $_GET['selectpage'];
}

$pages = ceil($per_total / $per);
//計算總頁數ceil( x )取 >= x的整數, 也就是小數無條件進1法;


if (!isset($_GET['page'])) {
  // !isset 判斷有沒有設置 $_GET['page'] 這個變數
  $page = 1;
} elseif ($_GET['page'] > $pages) {
  //判斷傳來的$_GET['page']值, 超過就為最後一頁
  $page = $pages;
} else {
  $page = $_GET['page'];
}

$start = ($page - 1) * $per;
//每一頁開始的資料序號( 資料庫序號是從0開始 )
$result = mysqli_query($db_link, $sql . ' LIMIT ' . $start . ', ' . $per) or die('MySQL query error');
//讀取選取頁的資料

$page_start = $start + 1;
//選取頁的起始筆數
$page_end = $start + $per;
//選取頁的最後筆數
if ($page_end > $per_total) {
  //最後頁的最後筆數 = 總筆數
  $page_end = $per_total;
}
?>
<html lang="en">

<head>
<title>歷史訂單</title>
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
      overflow-y: hidden
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
  <title>歷史訂單</title>
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
          <a href="a_manorder.php" class="nav-link text-white active">
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
          <a href="a_setting.php" class="nav-link text-white ">
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

    <div class="container w-auto">
      <br>
      <h2>歷史訂單</h2>
      <hr>
      <form method='get' class='form-inline'>
        <input type='text' placeholder='請輸入搜尋關鍵字' name='p_search' id='p_search'>
        <input type="month" name="month">
        <button class='btn' type='submit'><i class='fas fa-search'></i></button>
        <!-- 隱藏欄位記錄分頁欄位內的資料, 如此分頁後再搜尋, 才會以所選的分頁筆數來顯示搜尋後資料 -->
        <input name='selectpage' type='hidden' value="<?= $_GET['selectpage'] ?>">
        <input name='settle' type='hidden' value="<?= $_GET['settle'] ?>">
      </form>
      <form id='frmpage' method='get'>
        每頁顯示
        <select name='selectpage' id='selectpage' onChange='submit()' size='1' class="sel_size">
          <option value='5'>5</option>
          <option value='10'>10</option>
          <option value='25'>25</option>
          <option value="<?php echo $per_total; ?>">All</option>
        </select>筆
        <!-- 隱藏欄位記錄搜尋欄位內的資料, 如此搜尋後再分頁, 才只顯示搜尋後資料-->
        <input name='p_search' type='hidden' value="<?= $_GET['p_search'] ?>">
        <input name='settle' type='hidden' value="<?= $_GET['settle'] ?>">
        <input name='month' type='hidden' value="<?= $_GET['month'] ?>">
      </form>

      <form method='get' class='form-inline'>
        前往第<input type='text' size='2' name='page' class="sel_size" onkeyup='return keynum1(this,value)'>頁</label>
        <!-- 隱藏欄位記錄搜尋欄和分頁筆數資料, 如此搜尋後指定頁, 才只顯示搜尋後資料-->
        <input name='p_search' type='hidden' value="<?= $_GET['p_search'] ?>">
        <input name='settle' type='hidden' value="<?= $_GET['settle'] ?>">
      </form>

      <?php
      $sql_quality = "SELECT * FROM `setting` where `s_class`='庫存'";
      $result_quality = mysqli_query($db_link, $sql_quality);
      $rows_quality = mysqli_fetch_assoc($result_quality);
      $quality = $rows_quality["s_content"];
      //判斷有無搜尋到資料( start )
      echo <<<_END
    <table class="table table-sm">
    <thead>
    <tr>
    <td>訂單編號</td>
    <td>帳號</td>
    <td>&nbsp;總金額&nbsp;</td>
    <td>下單時間</td>
    <td>付款方式</td>
    <td>訂單狀況</td>
    <td>到貨日期</td>
    <td>簽收日期</td>
    </tr>
    </thead>
    _END;
      echo "<tbody>";

      while ($row = $result->fetch_assoc()) {
        echo '<form method="POST"><tr>';
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
        echo "<td>" . $row["o_account"] . "</td>";
        echo "<td>" . $row["o_total"] . "</td>";
        echo "<td>" . $row["o_time"] . "</td>";
        echo "<td>" . $row["o_payby"] . "</td>";
        if ($row["o_settle"] == "3") {
          echo "<td>已完成</td>";
          echo "<td>" . $row["o_arrtime"] . "</td>";
          echo "<td>" . $row["o_finishtime"] . "</td>";
        }

        //echo '<td><button name="delmember" onclick=\'return confirm("是否刪除")\'>刪除資料</button></td>';
        echo "<input type='hidden' name='n' value='" . $row["o_id"] . "'>";
        echo "<input type='hidden' name='settle' value='" . $row["o_settle"] . "'>";
        echo "</form>";
      }
      echo "</tbody>";
      echo "</table>";
      if (isset($_POST["settle_1"])) {
        $update = "UPDATE `orders` SET `o_settle`='1',`o_finishtime`='" . $_POST["time"] . "' ,`o_arrtime`='" . $_POST["arrtime"] . "' 
            WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('訂單已確認');location.href='a_manorder.php';</script>";
      }
      if (isset($_POST["settle_2"])) {
        $update = "UPDATE `orders` SET `o_settle`='2',`o_finishtime`='" . $_POST["time"] . "' ,`o_arrtime`='" . $_POST["arrtime"] . "' 
            WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('訂單已出貨');location.href='a_manorder.php';</script>";
      }
      if (isset($_POST["settle_3"])) {
        $update = "UPDATE `orders` SET `o_settle`='3',`o_finishtime`='" . $_POST["time"] . "' ,`o_arrtime`='" . $_POST["arrtime"] . "' 
            WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('訂單已完成');location.href='a_manorder.php';</script>";
      }
      if (isset($_POST["settle_5"])) {
        $update = "UPDATE `orders` SET `o_settle`='5',`o_finishtime`='" . $_POST["time"] . "' ,`o_arrtime`='" . $_POST["arrtime"] . "' 
            WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('訂單已取消');location.href='a_manorder.php';</script>";
      }
      if (isset($_POST["settle_7"])) {
        $update = "UPDATE `orders` SET `o_settle`='7',`o_finishtime`='" . $_POST["time"] . "' ,`o_arrtime`='" . $_POST["arrtime"] . "' 
            WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('商品已退回');location.href='a_manorder.php';</script>";
      }
      if (isset($_POST["settle_8"])) {
        $update = "UPDATE `orders` SET `o_settle`='8',`o_finishtime`='" . $_POST["time"] . "'  
            WHERE `o_id` ='" . $_POST["n"] . "'";
        $result = mysqli_query($db_link, $update);
        echo "<script>alert('確認退貨');location.href='a_manorder.php';</script>";
      }
      ?>

      <div class="container mt-3 pull-right">
        <ul class="pagination pagination-sm">

          <?php
          if ($pages > 1) {
            //總頁數>1才顯示分頁選單
            if ($page == '1') {
              echo '<li class="page-item"><a class="page-link">首頁 </a></li>';
              echo '<li class="page-item"><a class="page-link">上一頁 </a></li>';
            } else {
              echo '<li class="page-item"><a class="page-link" href=?page=1&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&settle=' . $_GET['settle'] . '&month=' . $_GET['month'] . '>首頁</a></li>';
              echo '<li class="page-item"><a class="page-link" href=?page=' . ($page - 1) . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&settle=' . $_GET['settle'] . '&month=' . $_GET['month'] . '>上一頁</a></li>';
            }

            for ($i = 1; $i <= $pages; $i++) {
              if ($page - 3 < $i && $i < $page + 3) {
                if ($i == $page) {
                  echo '<li class="page-item"><a class="page-link">' . $i . '</a></li>';
                } else {
                  echo '<li class="page-item"><a class="page-link" href=?page=' . $i . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&settle=' . $_GET['settle'] . '&month=' . $_GET['month'] . '>' . $i . '</a></li>';
                }
              }
            }

            //在最後頁時, 該頁就不超連結, 可連結就送出$_GET['page']
            if ($page == $pages) {
              echo '<li class="page-item"><a class="page-link">下一頁 </a>';
              echo '<li class="page-item"><a class="page-link">末頁</a>';
            } else {
              echo '<li class="page-item"><a class="page-link" href=?page=' . ($page + 1) . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&settle=' . $_GET['settle'] . '&month=' . $_GET['month'] . '>下一頁</a></li>';
              echo '<li class="page-item"><a class="page-link" href=?page=' . $pages . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&settle=' . $_GET['settle'] . '&month=' . $_GET['month'] . '>末頁</a></li>';
            }
          }

          ?>
        </ul>
      </div>
  </main>
  <script>
    document.getElementById('p_search').value = '<?= $_GET['p_search'] ?>';
    //搜尋欄位保留輸入的字
    document.getElementById('selectpage').value = '<?= $_GET['selectpage'] ?>';
    //保留下拉所選每頁筆數
  </script>

  </div>



</body>

</html>

<style>
  .resize {
    width: auto;
    width: 180px;
  }

  .resize {
    height: auto;
    height: 180px;
  }

  .sel_size {
    width: 65px;
    height: 25px;
  }
</style>