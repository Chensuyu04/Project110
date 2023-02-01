<?php
include('function.php');

$sql = "SELECT * FROM `products` where `p_class`='" . $_GET["class"] . "' ";
$result = mysqli_query($db_link, $sql);
$sens = array();
$temp = array();
while ($row = mysqli_fetch_array($result)) {
  $sens[] = $row['p_name'];
}
$sql_t = "SELECT `p_name`,`p_price`,sum(`od_num`) 
                FROM (`orderdetails` INNER JOIN `orders` ON `orders`.`o_id`=`orderdetails`.`o_id`) 
                INNER JOIN `products` ON `products`.`p_id`=`orderdetails`.`od_pid`
                where  to_days(now())-to_days(`o_time`)<=180 and `o_settle`='1' 
                or to_days(now())-to_days(`o_time`)<=180 and `o_settle`='0'
                or to_days(now())-to_days(`o_time`)<=180 and `o_settle`='2'
                or to_days(now())-to_days(`o_time`)<=180 and `o_settle`='3'
                GROUP BY `p_id`";
$result_t = mysqli_query($db_link, $sql_t) or die($sql_t);

while ($rows = $result_t->fetch_array()) {
  $temp_name[] = $rows[0];
  $temp_num[] = $rows[2];
}
for ($i = 0; $i <= count($sens); $i++) {
  for ($j = 0; $j <= count($temp_name); $j++) {
    if ($sens[$i] == $temp_name[$j]) {
      $temp[$i] = $temp_num[$j];
      break;
    } else
      $temp[$i] = 0;
  }
}
?>

<!doctype html>
<html lang="en">

<head>
<title>首頁</title>
  <meta charset="utf-8">
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>銷售圖</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }

    .chartMenu {
      width: 100vw;
      height: 40px;
      background: #1A1A1A;
      color: rgba(255, 26, 104, 1);
    }

    .chartMenu p {
      padding: 10px;
      font-size: 20px;
    }

    .chartCard {
      width: 100vw;
      height: calc(100vh - 40px);
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .chartBox {
      width: 1000px;
      padding: 20px;
      border-radius: 20px;
      border: solid 3px rgba(255, 26, 104, 1);
      background: white;
    }
  </style>
</head>
<?php
include('svg.php');
?>

<main>
  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-auto w-auto " style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="10" height="8">
        <img src="images/Logo.png" class="navbar-brand">
        </svg>
        <span class="fs-4">後台管理</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="a_index.php" class="nav-link text-white active">
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
        <a href="a_manbulletin.php" class="nav-link text-white ">
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

  <body>
    <div class="chartCard">
      <div class="chartBox">
        <form name=data>
          商品類型：
          <select name=class onchange=checkField(this.value);>
            <option value=0 selected>
              <?php
              $sql_class = "SELECT * FROM `setting` where `s_class`='商品分類'";
              $result_class = mysqli_query($db_link, $sql_class);
              while ($row_class = $result_class->fetch_assoc()) {
                echo "<option value=$row_class[s_content]>" . $row_class["s_name"] . "<br>";
              }
              ?>
          </select>
          <canvas id="myChart"></canvas>
          <div id=namelist></div>
          <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
            // setup 
            const data = {
              labels: <?php echo json_encode($sens); ?>,
              datasets: [{
                label: '半年銷售量',
                data: <?php echo json_encode($temp); ?>,
                backgroundColor: [
                  'rgba(255, 26, 104, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(0, 0, 0, 0.2)'
                ],
                borderColor: [
                  'rgba(255, 26, 104, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(0, 0, 0, 1)'
                ],
                borderWidth: 1
              }]
            };

            // config 
            const config = {
              type: 'bar',
              data,
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            };

            // render init block
            const myChart = new Chart(
              document.getElementById('myChart'),
              config
            );
          </script>
      </div>
    </div>
</main>

</body>
<script>
  function checkField(val) {
    location.href = "a_index.php?class=" + val;
  }
  document.getElementById('class').value = '<?= $_GET['class'] ?>';
</script>

</html>