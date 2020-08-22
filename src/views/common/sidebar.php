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
            <div id="dashboard_menu">
                <a href="<?= url_for('/'); ?>"><i class="fa-fw fas fa-chart-line"></i>Dashboard</a>
            </div>
        </li>

        <li>
            <div id="booking_menu">
                <a href="<?= url_for('/booking') ?>"><i class="fa-fw fas fa-book"></i>Booking</a>
            </div>
        </li>
        <!-- <ul>
            <li><a href="#">List</a></li>
            <li><a href="#">Walk-in</a></li>
            <li><a href="#">Verify Online Booking</a></li>
        </ul> -->

        <li>
            <div id="service-order_menu">
                <a href="#serviceOrderSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa-fw fas fa-car"></i>Service Order</a>
            </div>
            <ul class="collapse list-unstyled" id="serviceOrderSubMenu">
                <li id="ongoing-menu"><a href="<?= url_for('/service-order?status=ongoing'); ?>"><i class="fas fa-tasks"></i>Ongoing Services</a></li>
                <li id="on-hold-menu"><a href="<?= url_for('/service-order?status=on-hold'); ?>"><i class="fas fa-tasks"></i>On-hold Services</a></li>
                <li id="servicehistory-menu"><a href="<?= url_for('/service-order/history'); ?>"><i class="fas fa-tasks"></i>History</a></li>
                <!-- <li><a href="#">Service Schedule</a></li> -->
                <!-- <li><a href="#">Bays</a></li> -->
                <!-- <li><a href="#">Ongoing Services</a></li> -->
            </ul>
        </li>

        <li>
            <div id="service_menu">
                <a href="#serviceSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa-fw fas fa-car"></i>Service Options</a>
            </div>
            <ul class="collapse list-unstyled" id="serviceSubMenu">
                <li id="service_type-menu"><a href="<?= url_for('/service/type'); ?>"><i class="fas fa-gas-pump"></i>Service Types</a></li>
                <li id="bay-menu"><a href="<?= url_for('/service/bay'); ?>"><i class="fas fa-warehouse"></i>Bays</a></li>
                <li id="centre-menu"><a href="<?= url_for('/service/options/centre'); ?>"><i class="fas fa-warehouse"></i>Centre Options</a></li>
                <!-- <li><a href="#">Service Schedule</a></li> -->
                <!-- <li><a href="#">Bays</a></li> -->
                <!-- <li><a href="#">Ongoing Services</a></li> -->
            </ul>
        </li>

        <li>
            <div id="schedule_menu">
                <a href="<?= url_for('/schedule'); ?>"><i class="fa-fw fas fa-id-badge"></i>Schedule</a>
            </div>
        </li>
        <li>
            <div id="employee_menu">
                <a href="<?= url_for('/employee'); ?>"><i class="fa-fw fas fa-id-badge"></i>Employee</a>
            </div>
        </li>

        <li>
            <div id="inventory_menu">
                <a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa-fw fas fa-archive"></i>Inventory</a>
            </div>
            <ul class="collapse list-unstyled" id="inventorySubmenu">
                <li id="stock-menu"><a href="<?= url_for('/inventory/stock'); ?>"><i class="fa-fw fas fa-car-battery"></i>Stock</a></li>
                <li id="item-menu"><a href="<?= url_for('/inventory/item'); ?>"><i class="fa-fw fas fa-car-battery"></i>Items</a></li>
                <li id="category-menu"><a href="<?= url_for('/inventory/category'); ?>"><i class="fas fa-th"></i>Categories</a></li>
                <li id="subcategory-menu"><a href="<?= url_for('/inventory/subcategory'); ?>"><i class="fas fa-th"></i>Subcategories</a></li>
                <li id="supplier-menu"><a href="<?= url_for('/inventory/supplier'); ?>"><i class="fas fa-truck"></i>Suppliers</a></li>
                <li id="purchase-order-menu"><a href="<?= url_for('/inventory/purchase-order'); ?>"><i class="fas fa-clipboard-list"></i>Purchase Order</a></li>
                <li id="grn-menu"><a href="<?= url_for('/inventory/grn'); ?>"><i class="fas fa-clipboard-list"></i>GRN</a></li>
                <!-- <li><a href="#">Service Schedule</a></li> -->
                <!-- <li><a href="#">Bays</a></li> -->
                <!-- <li><a href="#">Ongoing Services</a></li> -->
            </ul>
        </li>
        <li>
            <!-- <div id="sales_menu">
                <a href="#saleSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa-fw fas fa-cash-register"></i>Sales</a>
            </div> -->

            <!-- <ul class="collapse list-unstyled" id="saleSubmenu"> -->
            <!-- <li id="new-order-menu"><a href="<?= url_for('/sale/item/new') ?>"><i class="fas fa-shopping-cart"></i>New Order</a></li>
                <li id="sales-history-menu"><a href="#"><i class="fas fa-file-alt"></i>Sales History</a></li> -->
            <!-- <li><a href="#">Returns</a></li> -->
            <!-- </ul> -->
            <!-- </li> -->
            <!-- <li> -->
            <div id="customer_menu">
                <a href="<?= url_for('/customer'); ?>"><i class="fa-fw fas fa-user"></i>Customer</a>
            </div>
        </li>
        <!-- <li> -->
        <!-- <a href="<?= url_for('/communication'); ?>"><i class="fa-fw fas fa-comment"></i>Communication</a> -->
        <!-- <ul class="collapse list-unstyled" id="comSubmenu">
                <li><a href="#">Customer Queries</a></li>
                <li><a href="#">Notifications</a></li>
            </ul> -->
        <!-- </li> -->
        <li>
            <div id="system_menu">
                <a href="#userSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa-fw fas fa-cog"></i>System</a>
            </div>
            <ul class="collapse list-unstyled" id="userSubMenu">
                <!-- <li><a href="#"><i class="fas fa-tasks"></i>Service Order</a></li> -->
                <li id="user-menu"><a href="<?= url_for('/user'); ?>">Users</a></li>
                <!-- <li><a href="#">Service Schedule</a></li> -->
                <!-- <li><a href="#">Bays</a></li> -->
                <!-- <li><a href="#">Ongoing Services</a></li> -->
            </ul>
        </li>
        <li>
            <div id="report_menu">
                <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-file-alt"></i>Report</a>
            </div>
            <ul class="collapse list-unstyled" id="reportSubmenu">
                <!-- <li><a href="#"><i class="fas fa-tasks"></i>Service Order</a></li> -->
                <li id="empreport-menu"><a href="<?= url_for('/report/employee'); ?>">Employee Report</a></li>
                <li id="empjob-menu"><a href="<?= url_for('/report/employee/job-count'); ?>">Employee Job Count</a></li>
                <li id="empjob-menu"><a href="<?= url_for('/c-report/customer'); ?>">Active Customer</a></li>
                <li id="empjob-menu"><a href="<?= url_for('/c-report/employee/service-count'); ?>">Employee Service Count</a></li>
                <li id="empjob-menu"><a href="<?= url_for('/c-report/service/average'); ?>">Service Average</a></li>
                <li id="empjob-menu"><a href="<?= url_for('/c-report/service/list'); ?>">Service Types Report</a></li>
                <!-- <li id="schedule_report-menu"><a href="<?= url_for('/report/employee'); ?>">Schedule List</a></li> -->
                <!-- <li id="customer_report-menu"><a href="<?= url_for('/report/customer'); ?>">Customer Report List</a></li>
                <li id="empreport-menu"><a href="<?= url_for('/report/service-type'); ?>">Service Type Report</a></li> -->
                <!-- <li><a href="#">Service Schedule</a></li> -->
                <!-- <li><a href="#">Bays</a></li> -->
                <!-- <li><a href="#">Ongoing Services</a></li> -->
            </ul>
        </li>
        <!-- <li>
            <div id="report_menu">
                <a href="#"><i class="fas fa-file-alt"></i>Reports</a>
            </div>
        </li> -->
        <!-- <ul class="collapse list-unstyled" id="system">
                <li><a href="/public/views/system-administration/user/index.php">Users</a></li>
            </ul> -->
    </ul>
</nav>