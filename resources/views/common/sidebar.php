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
            <a href="<?php echo url_for('/public'); ?>"><i class="fas fa-chart-line"></i>Dashboard</a>
        </li>
        <li>
            <a href="#bookingSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-car-crash"></i>Booking</a>
            <ul class="collapse list-unstyled" id="bookingSubmenu">
                <li><a href="<?php echo url_for('/public/views/booking/list.php');?>">List</a></li>
                <li><a href="<?php echo url_for('/public/views/service/service_type/index.php'); ?>">Walk-in</a></li>
                <li><a href="<?php echo url_for('/public/views/booking/verify_online_booking.php'); ?>">Verify Online Booking</a></li>
            </ul>
        </li>
        <li>
            <a href="#"><i class="fas fa-tasks"></i>Service Order</a>
        </li>
        <li>
            <a href="#serviceSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-car-crash"></i>Services</a>
            <ul class="collapse list-unstyled" id="serviceSubmenu">
                <li><a href="#">Service Schedule</a></li>
                <li><a href="<?php echo url_for('/public/views/service/service_type/index.php'); ?>">Service Types</a></li>
                <li><a href="#">Bays</a></li>
                <li><a href="#">Ongoing Services</a></li>
            </ul>
        </li>
        <li>
            <a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-archive"></i>Inventory</a>
            <ul class="collapse list-unstyled" id="inventorySubmenu">
                <li><a href="<?php echo url_for('/public/views/inventory/product/index.php'); ?>">Products</a></li>
                <li><a href="<?php echo url_for('/public/views/inventory/category/index.php'); ?>">Categories</a></li>
                <li><a href="#">Purchase Orders</a></li>
                <li><a href="<?php echo url_for('/public/views/inventory/supplier/index.php'); ?>">Suppliers</a></li>
            </ul>
        </li>
        <li>
            <a href="#saleSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-store"></i>Sales</a>
            <ul class="collapse list-unstyled" id="saleSubmenu">
                <li><a href="<?php echo url_for('/public/views/sale/order/newOrder.php'); ?>">Orders</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Order History</a></li>
            </ul>
        </li>
        <li>
            <a href="#customer" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-friends"></i>Customer</a>
            <ul class="collapse list-unstyled" id="customer">
                <li><a href="<?php echo url_for('/public/views/customer/index.php'); ?>"></i>Customers</a></li>
                <li><a href="<?php echo url_for('/public/views/customer/onlineProfile/index.php'); ?>"></i>Online Profiles</a></li>
            </ul>
            
        </li>
            <li>
                <a href="<?php echo url_for('/public/views/employee/index.php'); ?>"><i class="fas fa-id-badge"></i>Employees</a>
            </li>
        <li>
            <a href="#comSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-comment"></i>Communication</a>
            <ul class="collapse list-unstyled" id="comSubmenu">
                <li><a href="#">Customer Queries</a></li>
                <li><a href="#">Notifications</a></li>
            </ul>
        </li>
            <li>
                <a href="#system" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-cog"></i>System</a>
                <ul class="collapse list-unstyled" id="system">
                    <li><a href="<?php echo url_for('/public/views/system-administration/user/index.php'); ?>">Users</a></li>
                </ul>
            </li>
    </ul>
</nav>