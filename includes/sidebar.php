<div class="sidebar">
    <div>
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo "images/".$_SESSION["user-image"];?>" ; class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['name'];?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fa fa-th "></i>
                        <p>
                            صفحه اصلی
                            <i class="right"></i>
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview menu-close ">
                    <a href="purchase.php" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            حسابات خالد
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close setting-menu">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            تنضیمات عمومی
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="sarafi.php" class="nav-link ">
                                <i class="fa fa-building-o nav-icon"></i>
                                <p> صرافی </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="company.php" class="nav-link ">
                                <i class="fa fa-building-o nav-icon"></i>
                                <p> شرکت های داخلی </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="fabric.php" class="nav-link">
                                <i class="fa fa-square nav-icon"></i>
                                <p>تکه </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="vendorcompany.php" class="nav-link">
                                <i class="fa fa-truck nav-icon"></i>
                                <p> شرکتهای خارجی </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="transfercompany.php" class="nav-link">
                                <i class="fa fa-truck nav-icon"></i>
                                <p> انتفالات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="warehouse.php" class="nav-link ">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>گدامها </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customer.php" class="nav-link ">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> مشتریان </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close talabat-menu">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            طلبات
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="vendorcompanylist.php" class="nav-link ">
                                <i class="fa fa-shopping-basket nav-icon"></i>
                                <p> حسابات چین </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p> خرید مال به دیگران </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> قرض نقده</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close transportpending-menu">
                    <!-- <a href="transportpending.php" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            مال در راه
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a> -->
                </li>
                <li class="nav-item has-treeview menu-close transport-menu">
                    <a href="transportlist.php" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            ترانسپورت
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close sarai-menu">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            اجناس گدام
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="sarailist.php" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>سرایها </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="itemlist.php" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> لست اجناس </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview menu-close ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            حسابات حامد
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close ">
                    <a href="customerpage.php" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            حسابات مشتریان
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close sarafi-menu">
                    <a href="sarafilist.php" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            صرافی
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview menu-close users-menu">
                    <a href="users.php" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            کاربرها
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item has-treeview menu-close purchase-menu">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            مدیریت خریداری
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="purchase.php" class="nav-link ">
                                <i class="fa fa-shopping-basket nav-icon"></i>
                                <p>لست خریداری </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="fabricdesign.php" class="nav-link">
                                <i class="fa fa- nav-icon"></i>
                                <p>لست دیزاینها </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="purchasecolor.php" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>لست رنگها </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close transport-menu">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            مدیریت انتقالات
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="outsideshipment.php" class="nav-link ">
                                <i class="fa fa-truck nav-icon"></i>
                                <p>انتقال خارجی </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-truck nav-icon"></i>
                                <p>انتقال داخلی </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close stock-menu">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            مدیریت گدام
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="stock.php" class="nav-link ">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>لست اجناس </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="transferpati.php" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> انتقال پتی </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>لست دخولی </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            مدیریت فروشات
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>لست فروشات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>لست قروض </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            مدیریت صرافی
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>برداشت پول </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> ذخیره پول </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p> مدیریت صراف </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-close">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            مدیریت راپورها
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link ">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>راپور صرافی </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>راپور مشتریان </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>راپور قروض </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>راپور خریداری </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>راپور گدام </p>
                            </a>
                        </li>

                    </ul>
                </li> -->

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</div>