<div class="sidebar">
    <div>
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

                <li class="nav-item category">
                    <a href="category.php" class="nav-link">
                        <i class="nav-icon fa fa-th "></i>
                        <p>
                            کتگوری
                            <i class="right"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fa fa-shopping-cart"></i>
                        <p>
                            جنس
                            <i class="right"></i>
                        </p>
                    </a>
                </li>

                <li class="nav-item users">
                    <a href="users.php" class="nav-link ">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            کاربرها
                            <i class="right"></i>
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</div>