<?php
include('function.php');
?>
<?php
if ($_GET['p_search'] == '') {
  $sql = 'SELECT * FROM `purchase` order by `pu_date` DESC ';
} else {
  if ($_GET["sel"] == "") {
    $sql = "SELECT * FROM `purchase` WHERE `su_name` LIKE '%" . $_GET['p_search'] . "%'";
  } else {
    $sel = $_GET["sel"];
    $sql = "SELECT * FROM `purchase` WHERE `$sel` LIKE '%" . $_GET['p_search'] . "%'";
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
<title>進貨管理</title>
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
  <title>進貨管理</title>
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
          <a href="a_manproduct.php" class="nav-link text-white">
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
          <a href="a_manpurchase.php" class="nav-link text-white active">
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
      <h2>進貨管理</h2>
      <hr>
      <form method='get' class='form-inline'>
        <select name="sel" id="sel" size="1">
          <option value="su_name">供應商名稱</option>
          <option value="pu_product_name">商品名稱</option>
        </select>
        <input type='text' placeholder='請輸入搜尋關鍵字' name='p_search' id='p_search'>
        <button class='btn' type='submit'><i class='fas fa-search'></i></button>
        <input type="button" name="addsupplier" value="新增供應商" onclick="javascript:location.href='a_addsupplier.php'">
        <!-- 隱藏欄位記錄分頁欄位內的資料, 如此分頁後再搜尋, 才會以所選的分頁筆數來顯示搜尋後資料 -->
        <input name='selectpage' type='hidden' value="<?= $_GET['selectpage'] ?>">
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
        <input name="sel" type="hidden" value="<?= $_GET['sel'] ?>">
      </form>

      <form method='get' class='form-inline'>

        前往第<input type='text' size='2' name='page' class="sel_size" onkeyup='return keynum1(this,value)'>頁</label>
        <!-- 隱藏欄位記錄搜尋欄和分頁筆數資料, 如此搜尋後指定頁, 才只顯示搜尋後資料-->
        <input name='p_search' type='hidden' value="<?= $_GET['p_search'] ?>">
      </form>
      <?php
      //判斷有無搜尋到資料(start) 

      echo <<<_END
 <br>
 <table class="table table-sm align-middle">
 <thead>
 <tr>
 <td>進貨編號</td>
 <td>進貨商品</td>
 <td>供應商</td>
 <td>進貨數量</td>
 <td>進貨成本</td>
 <td>進貨日期</td>
 </tr>
 </thead>
 _END;
      echo "<tbody>";
      while ($row = $result->fetch_assoc()) {
        $sql_pname = 'SELECT * FROM `products` where `p_id`="' . $row["pu_product"] . '" ';
        $result_pname = mysqli_query($db_link, $sql_pname) or die($sql_pname);
        $p_name = mysqli_fetch_assoc($result_pname);
        $sql_sname = 'SELECT * FROM `suppliers` where `su_id`="' . $row["su_id"] . '" ';
        $result_sname = mysqli_query($db_link, $sql_sname) or die($sql_sname);
        $s_name = mysqli_fetch_assoc($result_sname);
        echo '<form method="POST" action = ""><tr>';
        echo "<td>" . $row["pu_id"] . "</td>";
        echo "<td>" . $p_name["p_name"] . "</td>";
        echo "<td>" . $s_name["su_name"] . "</td>";
        echo "<td>" . $row["pu_quantity"] . "</td>";
        echo "<td>" . $row["pu_cost"] . "</td>";
        echo "<td>" . $row["pu_date"] . "</td>";
        echo <<<_END
        <td><input type = 'button' onclick = "javascript:location.href='a_editpurchase.php?pu_id=$row[pu_id]'" value=修改></input>
        _END;
        echo "<input type='hidden' name='n' value='" . $row["pu_id"] . "'>";
        echo "</tr></form>";
      }
      echo "</tbody>";
      echo "</table><br>";
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
              echo '<li class="page-item"><a class="page-link" href=?page=1&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&sel=' . $_GET['sel'] . '>首頁</a></li>';
              echo '<li class="page-item"><a class="page-link" href=?page=' . ($page - 1) . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&sel=' . $_GET['sel'] . '>上一頁</a></li>';
            }

            for ($i = 1; $i <= $pages; $i++) {
              if ($page - 3 < $i && $i < $page + 3) {
                if ($i == $page) {
                  echo '<li class="page-item"><a class="page-link">' . $i . '</a></li>';
                } else {
                  echo '<li class="page-item"><a class="page-link" href=?page=' . $i . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&sel=' . $_GET['sel'] . '>' . $i . '</a></li>';
                }
              }
            }

            //在最後頁時, 該頁就不超連結, 可連結就送出$_GET['page']
            if ($page == $pages) {
              echo '<li class="page-item"><a class="page-link">下一頁 </a>';
              echo '<li class="page-item"><a class="page-link">末頁</a>';
            } else {
              echo '<li class="page-item"><a class="page-link" href=?page=' . ($page + 1) . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&sel=' . $_GET['sel'] . '>下一頁</a></li>';
              echo '<li class="page-item"><a class="page-link" href=?page=' . $pages . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&sel=' . $_GET['sel'] . '>末頁</a></li>';
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
  .sel_size {
    width: 65px;
    height: 25px;
  }
</style>