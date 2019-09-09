<nav id="sidebar">
    <div class="sidebar-header">
        <h3>SBWMS</h3>
    </div>
    <ul class="list-unstyled components">
        <!-- <p>Dummy Heading</p> -->
        <!-- <li class="active">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li><a href="#">Home</a></li>
                <li><a href="#">Home 2</a></li>
                <li><a href="#">Home 3</a></li>
            </ul>
        </li> -->
        <!-- <li class="active"> -->
        <li>
            <a href="<?= url_for('/'); ?>" id="dashboard_menu"><i class="fa-fw fas fa-chart-line"></i>Dashboard</a>
        </li>
        
        <li>
            <a href="<?= url_for('/booking') ?>" id="booking_menu"><i class="fa-fw fas fa-book"></i>Booking</a>
        </li>
       <!-- <ul>
            <li><a href="#">List</a></li>
            <li><a href="#">Walk-in</a></li>
            <li><a href="#">Verify Online Booking</a></li>
        </ul> -->
    
        <li>
            <a href="<?= url_for('/service'); ?>" id="service_menu"><i class="fa-fw fas fa-car"></i>Service</a>
        </li>
        <!-- <ul class="collapse list-unstyled" id="service_menu">
            <li><a href="#"><i class="fas fa-tasks"></i>Service Order</a></li>
            <li><a href="#">Service Schedule</a></li>
            <li><a href="/public/views/service/service_type/index.php')">Service Types</a></li>
            <li><a href="#">Bays</a></li>
            <li><a href="#">Ongoing Services</a></li>
        </ul> -->
    
        <li>
            <a href="<?= url_for('/inventory'); ?>" id="inventory_menu"><i class="fa-fw fas fa-archive"></i>Inventory</a>
        </li>
        <li>
            <a href="<?= url_for('/sale'); ?>"><i class="fa-fw fas fa-cash-register"></i>Sales</a>
        </li>
            <!-- <ul class="collapse list-unstyled" id="saleSubmenu">
                <li><a href="#">Orders</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Order History</a></li>
            </ul> -->
        <li>
            <a href="<?= url_for('/customer'); ?>" id="customer_menu"><i class="fa-fw fas fa-user"></i>Customer</a>
        </li>
        <li>
            <a href="<?= url_for('/employee'); ?>" id="employee_menu"><i class="fa-fw fas fa-id-badge"></i>Employee</a>
        </li>
        <li>
            <a href="<?= url_for('/communication'); ?>"><i class="fa-fw fas fa-comment"></i>Communication</a>
            <!-- <ul class="collapse list-unstyled" id="comSubmenu">
                <li><a href="#">Customer Queries</a></li>
                <li><a href="#">Notifications</a></li>
            </ul> -->
        </li>
        <li>
            <a href="<?= url_for('/system') ?>"><i class="fa-fw fas fa-cog"></i>System</a>
        </li>
            <!-- <ul class="collapse list-unstyled" id="system">
                <li><a href="/public/views/system-administration/user/index.php">Users</a></li>
            </ul> -->
    </ul>
</nav>