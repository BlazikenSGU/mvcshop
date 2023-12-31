<!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="profile.html"><img src="<?= ASSETS . THEME ?>admin/img/ui-sam.jpg"
                        class="img-circle" width="60"></a></p>
            <h5 class="centered">
                <?= $data['user_data']->name ?>
            </h5>
            <h5 class="centered">
                <?= $data['user_data']->email ?>
            </h5>

            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Dashboard</span>
                </a>

            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/products">
                    <i class="fa fa-desktop"></i>
                    <span>Products</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/products">View Product</a></li>
                  
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/categories">
                    <i class="fa fa-desktop"></i>
                    <span>Categories</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/categories">View</a></li>
                
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/orders">
                    <i class="fa fa-desktop"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/settings">
                    <i class="fa fa-desktop"></i>
                    <span>Settings</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/setting/slider_images">Slider Images</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/users">
                    <i class="fa fa-desktop"></i>
                    <span>Users</span>
                </a>
                <ul class="sub">
                    <li><a href="<?= ROOT ?>admin/users/customers">Customer</a></li>
                    <li><a href="<?= ROOT ?>admin/users/admins">Admin</a></li>

                </ul>
            </li>

            <li class="sub-menu">
                <a href="<?= ROOT ?>admin/backup">
                    <i class="fa fa-desktop"></i>
                    <span>Website backup</span>
                </a>
            </li>

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->

<section id="main-content">
    <section class="wrapper site-min-height">
        <h3><i class="fa fa-angle-right"></i>
            <?= ucwords($data['page_title']) ?>
        </h3>
        <div class="row mt">
            <div class="col-lg-12">
            
   
