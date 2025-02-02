<?php
require_once "../db_connect.php";

$p = 0;

if (isset($_GET["sort_by"])) {
    $sortBy = $_GET["sort_by"];

    switch ($sortBy) {
        case 'id_asc':
            $orderBY = "ORDER BY product_id ASC";
            break;
        case 'id_desc':
            $orderBY = "ORDER BY product_id DESC";
            break;
        case 'price_asc':
            $orderBY = "ORDER BY product.price ASC";
            break;
        case 'price_desc':
            $orderBY = "ORDER BY product.price  DESC";
            break;
        case 'date_asc':
            $orderBY = "ORDER BY upload_date ASC";
            break;
        case 'date_desc':
            $orderBY = "ORDER BY upload_date DESC";
    }
} else {
    $orderBY = "ORDER BY product.id ASC"; // 預設排序方式
}

$sql = "SELECT
    product.*,
    product.id AS product_id,
    product.name AS product_name,
    (SELECT image_url FROM product_image WHERE F_product_id = product.id AND sort_order = 0 LIMIT 1) AS single_image_url,
    product_categories.Product_cate_ID AS category_id,
    product_categories.Product_cate_name AS category_name
FROM product
JOIN product_image ON product.id = product_image.F_product_id
JOIN product_categories ON product.category_id = product_categories.Product_cate_ID
WHERE product_image.sort_order = 0 $orderBY";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$rowsCount = $result->num_rows;

$sqlCategories = "SELECT Product_cate_ID, Product_cate_name FROM product_categories";
$resultCategories = $conn->query($sqlCategories);
$categories = $resultCategories->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>營養大選 Nutripoll</title>

  <!-- Bootstrap -->
  <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->

  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
          <a href="HomePage.html" class="site_title"
                >營養大選 Nutripoll<span></span
              ></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2>John Doe</h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <!-- <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>
                  </li> -->
                <!-- <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="form.html">General Form</a></li>
                      <li><a href="form_advanced.html">Advanced Components</a></li>
                      <li><a href="form_validation.html">Form Validation</a></li>
                      <li><a href="form_wizards.html">Form Wizard</a></li>
                      <li><a href="form_upload.html">Form Upload</a></li>
                      <li><a href="form_buttons.html">Form Buttons</a></li>
                    </ul>
                  </li> -->
                <!-- <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="general_elements.html">General Elements</a></li>
                      <li><a href="media_gallery.html">Media Gallery</a></li>
                      <li><a href="typography.html">Typography</a></li>
                      <li><a href="icons.html">Icons</a></li>
                      <li><a href="glyphicons.html">Glyphicons</a></li>
                      <li><a href="widgets.html">Widgets</a></li>
                      <li><a href="invoice.html">Invoice</a></li>
                      <li><a href="inbox.html">Inbox</a></li>
                      <li><a href="calendar.html">Calendar</a></li>
                    </ul>
                  </li> -->
                  <li>
                    <a href="member.php"
                      ><i class="fa fa-table"></i> 會員管理
                      <span class="fa fa-chevron-down"></span
                    ></a>
                  </li>
                  <li>
                    <a href="product.php"
                      ><i class="fa fa-table"></i>商品管理
                      <span class="fa fa-chevron-down"></span
                    ></a>
                  </li>
                  <li>
                    <a
                      ><i class="fa fa-table"></i>分類管理<span
                        class="fa fa-chevron-down"
                      ></span>
                      <ul class="nav child_menu">
                        <li><a href="categories_product.php">商品</a></li>
                        <li><a href="categories_product.php">課程</a></li>
                        <li><a href="categories_product.php">食譜</a></li>
                      </ul>
                    </a>
                  </li>
                  <li>
                    <a href="recipe-list.php"
                      ><i class="fa fa-table"></i>食譜管理<span
                        class="fa fa-chevron-down"
                      ></span
                    ></a>
                  </li>
                  <li>
                    <a href="speaker.php"
                      ><i class="fa fa-table"></i>講師管理<span
                        class="fa fa-chevron-down"
                      ></span
                    ></a>
                  </li>
                  <li>
                    <a href="redirectClass.php"
                      ><i class="fa fa-table"></i>課程管理<span
                        class="fa fa-chevron-down"
                      ></span
                    ></a>
                  </li>
                  <li>
                    <a href="coupons.php"
                      ><i class="fa fa-table"></i>優惠卷管理<span
                        class="fa fa-chevron-down"
                      ></span
                    ></a>
                  </li>
                <!-- <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="chartjs.html">Chart JS</a></li>
                      <li><a href="chartjs2.html">Chart JS2</a></li>
                      <li><a href="morisjs.html">Moris JS</a></li>
                      <li><a href="echarts.html">ECharts</a></li>
                      <li><a href="other_charts.html">Other Charts</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                      <li><a href="fixed_footer.html">Fixed Footer</a></li>
                    </ul>
                  </li>
                </ul> -->
            </div>
            <!-- <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div> -->

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a> -->
            <!-- <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a> -->
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
            <ul class=" navbar-right">
              <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/img.jpg" alt="">John Doe
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Profile</a>
                  <a class="dropdown-item" href="javascript:;">
                    <span class="badge bg-red pull-right">50%</span>
                    <span>Settings</span>
                  </a>
                  <a class="dropdown-item" href="javascript:;">Help</a>
                  <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                </div>
              </li>

              <li role="presentation" class="nav-item dropdown open">
                <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item">
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <div class="text-center">
                      <a class="dropdown-item">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">

            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">

              </div>
            </div>
          </div>

          <div class="clearfix"></div>



          <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
              <div class="x_title row justify-content-between">
                <h1 class="col-auto">商品管理<small></small></h1>
                <div class="col-auto">
                  <div class="input-group ">
                    <input type="text" class="form-control" placeholder="請輸入關鍵字">
                    <span class="input-group-btn">
                      <button class="btn btn-secondary" type="button">Go</button>
                    </span>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="row ">
                  <div class="col-auto">
                    <form action="" method="get">
                      <select class="form-select form-select-sm" aria-label="Small select example" name="sort_by" onchange="this.form.submit()">
                        <option selected>排序方式</option>
                        <option value="id_asc" name="id_asc">ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 小->大</option>
                        <option value="id_desc" name="id_desc">ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 大->小</option>
                        <option value="price_asc" name="price_asc">價格 &nbsp;&nbsp;低->高</option>
                        <option value="price_desc" name="price_desc">價格&nbsp;&nbsp; 高->低</option>
                        <option value="date_desc" name="date_desc">更新時間 近->遠</option>
                        <option value="date_asc" name="date_asc">更新時間 遠->近</option>

                      </select>

                  </div>
                  <div class="col-auto">
                    <select class="form-select form-select-sm" aria-label="Small select example">
                      <option selected>分類</option>
                      <?php foreach ($categories as $category): ?>
                        <option value="<?=htmlspecialchars($category["Product_cate_ID"])?>"><?=htmlspecialchars($category["Product_cate_name"])?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                  <div class="col-2">
                    <div class="input input-group-sm mb-3 ">
                      <input type="number" name="price_min" class="form-control" placeholder="最低價格">
                    </div>
                  </div>
                  <div class="col-auto">
                    <div>~</div>
                  </div>
                  <div class="col-2">
                    <div class="input input-group-sm mb-3 ">
                      <input type="number" class="form-control" name="price_max" placeholder="最高價格">
                    </div>
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn-sm btn-secondary" name="price">
                      價格篩選
                    </button>

                  </div>
                  <div class="col-auto">

                    <li class="list-unstyled"><a href="addProduct.php" class="btn btn-sm btn-secondary">
                        新增商品
                      </a></li>

                  </div>
                  <div class="col-auto">
                    <li class="list-unstyled"><a href="addProduct.php" class="btn btn-sm btn-secondary" name="addProduct">
                        管理下架商品
                      </a></li>

                  </div>
                  </form>
                  <div class="col-auto">
                    <h5>共<?=$rowsCount?> 筆資料</h5>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="card-box table-responsive">
                    <!-- <p class="text-muted font-13 m-b-30"></p> -->

                    <table id="" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr class="col-auto">
                          <th>編號</th>
                          <th>圖片</th>
                          <th>商品名稱</th>
                          <th>種類</th>
                          <th>最後更新時間</th>
                          <th>價格</th>
                          <th>庫存</th>
                          <th></th>
                        </tr>
                      </thead>
                      <?php foreach ($rows as $product): ?>
                        <?php $imagePath = './p_image/' . $product['single_image_url'];?>

                        <tbody>
                          <tr>
                            <td><?=$product["product_id"]?></td>
                            <td><img src="<?=$imagePath?>" style="width: 100px; height: auto;" alt="<?=$product["product_name"]?> " class="object-fit"></td>
                            <td><?=$product["product_name"]?></td>
                            <td><?=$product["category_name"]?></td>
                            <td><?=$product["upload_date"]?></td>
                            <td><?=$product["price"]?> $</td>
                            <td><?=$product["stock_quantity"]?></td>
                            <td><i class="fa fa-pencil fa-fw"></i> <i class="fa fa-trash fa-fw mx-1"></i></td>
                          </tr>
                        </tbody>
                      <?php endforeach;?>

                    </table>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination justify-content-end">
                        <li class="page-item disabled">
                          <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="tables_dynamic.php?p=1">1</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">Next</a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- /page content -->

  <!-- footer content -->
  <footer>
    <div class="pull-right">
      Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
    </div>
    <div class="clearfix"></div>
  </footer>
  <!-- /footer content -->
  </div>
  </div>
  <?php include_once "../js.php";?>
  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="../vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="../vendors/nprogress/nprogress.js"></script>
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
  <!-- Datatables -->
  <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="../vendors/jszip/dist/jszip.min.js"></script>
  <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

  <!-- Custom Theme Scripts -->
  <script src="../build/js/custom.min.js"></script>

</body>

</html>