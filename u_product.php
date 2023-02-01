<?php
include('function.php');
session_start();

$sql = "SELECT * FROM `products` WHERE `p_status`= 1";
if ($_GET["selectAD"] != "") {
    if ($_GET["selectAD"] == "ASC")
        $sql = "SELECT * FROM `products` where `p_status`= 1 order by `p_price` ASC";
    if ($_GET["selectAD"] == "DESC")
        $sql = "SELECT * FROM `products` where `p_status`= 1 order by `p_price` DESC";
}
if ($_GET["class"] != "") {
    $sql = "SELECT * FROM `products` WHERE  `p_class`='" . $_GET["class"] . "' and `p_status`= 1";
}
if ($_GET["p_search"] != "") {
    $sql = "SELECT * FROM `products` WHERE `p_name` LIKE '%" . $_GET['p_search'] . "%' and `p_status`= 1";
    if ($_GET["class"] != "") {
        $sql = "SELECT * FROM `products` WHERE `p_name` LIKE '%" . $_GET['p_search'] . "%' and `p_class`='" . $_GET["class"] . "' and `p_status`= 1";
    }
}
$result = mysqli_query($db_link, $sql) or die($sql);
//分頁設定
$per_total = mysqli_num_rows($result);  //計算總筆數

if ($_GET['selectpage'] == NULL) { //每頁筆數; 初始值設10
    $per = 10;
} else {
    $per = $_GET['selectpage'];
}

$pages = ceil($per_total / $per);  //計算總頁數;ceil(x)取>=x的整數,也就是小數無條件進1法

if (!isset($_GET['page'])) {  // !isset 判斷有沒有設置 $_GET['page'] 這個變數
    $page = 1;
} elseif ($_GET['page'] > $pages) {  //判斷傳來的$_GET['page']值,超過就為最後一頁
    $page = $pages;
} else {
    $page = $_GET['page'];
}

$start = ($page - 1) * $per;  //每一頁開始的資料序號(資料庫序號是從0開始)
$result = mysqli_query($db_link, $sql . ' LIMIT ' . $start . ', ' . $per) or die('MySQL query error'); //讀取選取頁的資料

$page_start = $start + 1;  //選取頁的起始筆數
$page_end = $start + $per;  //選取頁的最後筆數
if ($page_end > $per_total) {  //最後頁的最後筆數=總筆數
    $page_end = $per_total;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覽</title>
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
    <div class="container mt-3">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="u_index.php">首頁</a></li>
            <li class="breadcrumb-item active">產品</li>
        </ul>
    </div>
    <div class="container p-5 w-auto">
        <div class="row">
            <div class="col-md-3">
                <form method="get" class="form-inline">
                    <select name="selectAD" id="selectAD" size="1">
                        <option value="ASC">價格小到大排序</option>
                        <option value="DESC">價格大到小排序</option>
                    </select>
                    <input class="search" type="text" placeholder="請輸入搜尋關鍵字" name="p_search" id="p_search">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                    <!-- 隱藏欄位記錄分頁欄位內的資料,如此分頁後再搜尋,才會以所選的分頁筆數來顯示搜尋後資料 -->
                    <input name="selectpage" type="hidden" value="<?= $_GET['selectpage'] ?>">
                    <input name="class" type="hidden" value="<?= $_GET['class'] ?>">
                </form>
                <ul class="list-group sticky-top w-auto">
                    <?php
                    echo "商品類別<br>";
                    $s_class = "SELECT * FROM `setting` where `s_class`='商品分類'";
                    $s_class_result = mysqli_query($db_link, $s_class);
                    while ($rows = $s_class_result->fetch_assoc()) {
                        echo "<li class='list-group-item'><a href=u_product.php?class=$rows[s_content] class=link-dark>" . $rows["s_name"] . "</a></li>";
                    }

                    ?>
                </ul>
            </div>

            <div class="col-md-9 ">
                <div class="row row-cols-md-4">
                    <?php
                    $br = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo <<<_END
                                <div class="col">
                                <form method="POST">
                                    <img src=$row[p_img] class="resize btn" data-bs-toggle="modal" data-bs-target="#exampleModal$row[p_id]"><br>
                                    <font size="3">$row[p_name]</font><br>
                                    NT$$row[p_price]<br>
                                    <div class="modal fade" id="exampleModal$row[p_id]" tabindex="-1" aria-labelledby="exampleModalLabel$row[p_id]" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel$row[p_id]">$row[p_name]</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                            <div class="modal-body">
                                            <img src=$row[p_img] class=resize1>
                                                $row[p_detail]
                                            </div>
                                        <div class="modal-footer">
                                            NT$$row[p_price]&nbsp
                                            數量<input type="number" name="num"  min="1" max=$row[p_num] value=1 class="number">
                                            <input type="submit" name="in_shop" value="加入購物車" class="submit">
                                            <input type="hidden" name="p_id" value=$row[p_id]>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                                </div>
                            _END;
                    }
                    if (isset($_POST["in_shop"])) {
                        if (isset($_SESSION["account"])) {
                            $query = "SELECT * FROM `products` where `p_id`='" . $_POST["p_id"] . "'  ";
                            $result = mysqli_query($db_link, $query);
                            $row = mysqli_fetch_assoc($result);
                            $query = "SELECT * FROM `shop` where `s_account`='" . $_SESSION["account"] . "'and `s_pid`='" . $_POST["p_id"] . "'";
                            $result = mysqli_query($db_link, $query);
                            $rows = mysqli_fetch_assoc($result);
                            if (isset($rows["s_account"])) {
                                $num = $rows["s_num"] + $_POST["num"];
                                $update = "UPDATE `shop` SET `s_num`='" . $num . "' where `s_account`='" . $_SESSION["account"] . "'and `s_pid`='" . $_POST["p_id"] . "'";
                                $result = mysqli_query($db_link, $update);
                                echo '<div class="alert alert-danger" role="alert">
                                        已加入購物車
                                    </div>';
                            } else {
                                $ins = "INSERT INTO `shop` (`s_account`, `s_pid`, `s_num`) 
                                VALUES ('" . $_SESSION['account'] . "','" . $_POST['p_id'] . "','" . $_POST["num"] . "')";
                                $result = mysqli_query($db_link, $ins);
                                echo '<div class="alert alert-danger" role="alert">
                                        已加入購物車
                                    </div>';
                            }
                        } else {
                            echo "<script>alert('請先登入');location.href='login.php';</script>";
                        }
                    }

                    ?>
                </div>

                <form id="frmpage" method="get">
                    每頁顯示
                    <select name="selectpage" id="selectpage" onChange="submit()" size="1">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="100">100</option>
                        <option value="<?php echo $per_total; ?>">All</option>
                    </select>筆
                    <!-- 隱藏欄位記錄搜尋欄位內的資料,如此搜尋後再分頁,才只顯示搜尋後資料-->
                    <input name="p_search" type="hidden" value="<?= $_GET['p_search'] ?>">
                    <input name="selectAD" type="hidden" value="<?= $_GET['selectAD'] ?>">
                    <input name="class" type="hidden" value="<?= $_GET['class'] ?>">
                </form>
                <p align="center">
                <ul class="pagination pagination-sm ">
                    <?php
                    if ($pages >= 1) {  //總頁數>1才顯示分頁選單
                        if ($page == '1') {
                            echo '<li class="page-item"><a class="page-link text-black">首頁 </a></li>';
                            echo '<li class="page-item"><a class="page-link text-black">上一頁 </a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link text-black" href=?page=1&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&class=' . $_GET['class'] . '&selectAD=' . $_GET['selectAD'] . '>首頁</a></li>';
                            echo '<li class="page-item"><a class="page-link text-black" href=?page=' . ($page - 1) . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&class=' . $_GET['class'] . '&selectAD=' . $_GET['selectAD'] . '>上一頁</a></li>';
                        }


                        for ($i = 1; $i <= $pages; $i++) {
                            if ($page - 3 < $i && $i < $page + 3) {
                                if ($i == $page) {
                                    echo '<li class="page-item"><a class="page-link text-black">' . $i . '</a></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link text-black" href=?page=' . $i . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&class=' . $_GET['class'] . '&selectAD=' . $_GET['selectAD'] . '>' . $i . '</a></li>';
                                }
                            }
                        }


                        //在最後頁時,該頁就不超連結,可連結就送出$_GET['page']	
                        if ($page == $pages) {
                            echo '<li class="page-item"><a class="page-link text-black">下一頁 </a></li>';
                            echo '<li class="page-item"><a class="page-link text-black">末頁</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link text-black" href=?page=' . ($page + 1) . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&class=' . $_GET['class'] . '&selectAD=' . $_GET['selectAD'] . '>下一頁</a></li>';
                            echo '<li class="page-item"><a class="page-link text-black" href=?page=' . $pages . '&p_search=' . $_GET['p_search'] . '&selectpage=' . $_GET['selectpage'] . '&class=' . $_GET['class'] . '&selectAD=' . $_GET['selectAD'] . '>末頁</a></li>';
                        }
                    }
                    ?>

                </ul>
                <form method="get" class="form-inline">
                    <label>前往第<input type="text" size="2" name="page" onkeyup="return keynum1(this,value)">頁</label>
                    <!-- 隱藏欄位記錄搜尋欄和分頁筆數資料,如此搜尋後指定頁,才只顯示搜尋後資料-->
                    </p>
                    <input name="p_search" type="hidden" value="<?= $_GET['p_search'] ?>">
                    <input name="class" type="hidden" value="<?= $_GET['class'] ?>">
                </form>
                <script>
                    document.getElementById('p_search').value = '<?= $_GET['p_search'] ?>'; //搜尋欄位保留輸入的字 
                    document.getElementById('selectpage').value = '<?= $_GET['selectpage'] ?>'; //保留下拉所選每頁筆數
                    document.getElementById('selectAD').value = '<?= $_GET['selectAD'] ?>';
                </script>

            </div>
        </div>
    </div>
    <?php
    include('footer.php');
    ?>
</body>

</html>
<style>
    i.fa-shopping-cart {
        color: black;
    }

    .submit {
        border: 0;
        background-color: #808080;
        color: #fff;
        border-radius: 5px;
        width: 100px;
        height: 30px;
        font-size: 15;
    }

    .resize {
        width: auto;
        width: 225px;
    }

    .resize {
        height: auto;
        height: 150px;
    }

    .resize1 {
        width: auto;
        width: 350px;
    }

    .resize1 {
        height: auto;
        height: 200px;
    }

    .modal-backdrop {
        background-color: #fff;
    }

    .card-modal~.modal-backdrop {
        background-color: #000;
    }

    .search {
        width: 200px;
    }

    .number {
        width: 80px;
        height: 30px;
        border-radius: 5px;
    }

    .a.page-link {
        color: #ffffff;
    }
</style>