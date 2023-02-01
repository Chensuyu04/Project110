<nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top ">
  <div class="container-fluid">
    <!-- Brand -->
    <img src="images/Logo.png" class="navbar-brand">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <!-- Links -->
      <ul class="navbar-nav ">
        <li class="nav-item">
          <a class="nav-link" href="u_index.php">首頁</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="u_product.php">商品一覽</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="u_illustrate.php">挑選說明</a>
        </li>
        <?
        if ($_SESSION['account'] != "") {
          echo <<<_END
    <li class="nav-item">
      <a class="nav-link" href="u_order.php">訂單查詢</a>
    </li>
    
    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-bs-toggle="dropdown">
      會員中心
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="u_data.php">個人資料</a>
        <a class="dropdown-item" href="u_service.php">客服中心</a>
        <a class="dropdown-item" href="u_password.php">更改密碼</a>
      </div>
    _END;
        }
        ?>
        </li>
      </ul>