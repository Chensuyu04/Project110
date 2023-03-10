<?php
include('function.php');
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <script src="ckeditor/ckeditor.js"></script>
  <script src="ckfinder/ckfinder.js"></script>
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
  <!-- ??? Bootstrap5 ?????? CSS ?????? -->
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
  <!--  popper.min.js ???????????????????????????????????? -->
  <script src="https://cdn.staticfile.org/popper.js/2.9.3/umd/popper.min.js"></script>
  <!-- ????????? Bootstrap5 ?????? JavaScript ?????? -->
  <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.min.js"></script>
  <!--icon??????-->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <title>???????????????</title>
  <script>
    //??????????????????
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
        <span class="fs-4">????????????</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="a_index.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#calendar3" />
            </svg>
            ??????
          </a>
        </li>
        <li>
          <a href="a_manuser.php" class="nav-link text-white" aria-current="page">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#people-circle" />
            </svg>
            ????????????
          </a>
        </li>
        <li>
          <a href="a_manproduct.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#calendar3" />
            </svg>
            ????????????
          </a>
        </li>
        <li>
          <a href="a_mansupplier.php" class="nav-link text-white active">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#calendar3" />
            </svg>
            ???????????????
          </a>
        </li>
        <li>
          <a href="a_manpurchase.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#calendar3" />
            </svg>
            ????????????
          </a>
        </li>
        <li>
          <a href="a_manorder.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#collection" />
            </svg>
            ????????????
          </a>
        </li>
        <li>
        <a href="a_reorder.php" class="nav-link text-white">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#collection" />
          </svg>
          ????????????
        </a>
      </li>
        <li>
          <a href="a_manbulletin.php" class="nav-link text-white  ">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#table" />
            </svg>
            ???????????????
          </a>
        </li>
        <li>
          <a href="a_manchat.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#chat-quote-fill" />
            </svg>
            ????????????
          </a>
        </li>
        <li>
          <a href="a_setting.php" class="nav-link text-white">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#tools" />
            </svg>
            ??????
          </a>
        </li>
      </ul>
      <hr>
    </div>
    <div class="b-example-divider"></div>

    <div class="container pt-3 w-50 ">
      <br>
      <h2>???????????????</h2>
      <hr>
      <form method="POST">
        <div class="form-floating mb-3">
          <input type="text" placeholder="name" name="name" class="form-control" id="floatingInput" required="">
          <label for="floatingInput">???????????????</label>
        </div>
        <div class="form-floating">
          <input type="text" placeholder="person" name="person" class="form-control" id="floatingInput" required=""><br>
          <label for="floatingInput">??????????????????</label>
        </div>
        <div class="form-floating">
          <input type="text" placeholder="phone" name="phone" id="phone" pattern="09\d{8}" class="form-control"><br>
          <label for="floatingInput">????????????</label>
        </div>
        <div class="form-floating">
          <input type="text" placeholder="address" name="address" class="form-control" id="floatingInput" required=""><br>
          <label for="floatingInput">??????</label>
        </div>
        <div class="form-floating">
          <input type="text" placeholder="numbers" name="numbers" class="form-control" id="number" onchange="check_tax_number(this.id)"><br>
          <label for="floatingInput">????????????</label>
          <script>
            function check_tax_number(x) {
              const gui_number = document.getElementById(x).value; // ???????????????
              const cx = [1, 2, 1, 2, 1, 2, 4, 1];
              const cnum = gui_number.split('');
              let sum = 0;

              function cc(num) {
                let total = num;
                if (total > 9) {
                  let s = total.toString();
                  const n1 = s.substring(0, 1) * 1;
                  const n2 = s.substring(1, 2) * 1;
                  total = n1 + n2;
                }
                return total;
              }
              if (gui_number.length != 8) {
                window.alert('????????????????????? 8 ?????????');
              }
              cnum.forEach((item, index) => {
                if (gui_number.charCodeAt() < 48 || gui_number.charCodeAt() > 57) {
                  window.alert('????????????????????? 8 ??? 0-9 ????????????');
                }
                sum += cc(item * cx[index]);
              });
              if (sum % 10 === 0) {
                window.alert('????????????');
              } else if (cnum[6] === '7' && (sum + 1) % 10 === 0) {
                window.alert('????????????2');
              } else {
                window.alert('????????????');
              }
            }
          </script>
        </div>
        <input type="submit" name="add" value="??????" class="btn btn-secondary">
      </form>
    </div>
    <?php
    if (isset($_POST["add"])) {
      $sql = "INSERT INTO `suppliers` (`su_name`, `su_person`, `su_phone`, `su_address`, `su_numbers`) VALUES ('" . $_POST["name"] . "', '" . $_POST["person"] . "', '" . $_POST["phone"] . "', '" . $_POST["address"] . "', '" . $_POST["numbers"] . "')";
      $result = mysqli_query($db_link, $sql) or die($sql);
      echo "<script>alert('????????????');location.href='a_mansupplier.php';</script>";
    }
    ?>
  </main>


</body>

</html>
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
    width: 150px;
    height: 25px;
  }
</style>