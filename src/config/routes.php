<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

/* Customer Routes */
$routes->add('list_customers', new Route(
    '/customer',
    ['_controller' => 'CustomerController', '_method' => 'list']
));
$routes->add('edit_customer', new Route(
    '/customer/edit',
    ['_controller' => 'CustomerController', '_method' => 'edit']
));
$routes->add('new_customer', new Route(
    '/customer/new',
    ['_controller' => 'CustomerController', '_method' => 'new']
));
$routes->add('show_customer', new Route(
    '/customer/view',
    ['_controller' => 'CustomerController', '_method' => 'show']
));

$routes->add('add_vehicle', new Route(
    '/customer/vehicle/new',
    ['_controller' => 'CustomerController', '_method' => 'newVehicle']
));

$routes->add('list_vehicles', new Route(
    '/customer/vehicle',
    ['_controller' => 'CustomerController', '_method' => 'listVehicle']
));

$routes->add('edit_vehicle', new Route(
    '/customer/vehicle/edit',
    ['_controller' => 'CustomerController', '_method' => 'editVehicle']
));

/* Employee Routes */
$routes->add('list_employees', new Route(
    '/employee',
    ['_controller' => 'EmployeeController', '_method' => 'list']
));
$routes->add('edit_employee', new Route(
    '/employee/edit',
    ['_controller' => 'EmployeeController', '_method' => 'edit']
));
$routes->add('new_employee', new Route(
    '/employee/new',
    ['_controller' => 'EmployeeController', '_method' => 'new']
));
$routes->add('show_employee', new Route(
    '/employee/view',
    ['_controller' => 'EmployeeController', '_method' => 'show']
));

/* Booking */
$routes->add('list_booking', new Route(
    '/booking',
    ['_controller' => 'BookingController', '_method' => 'list']
));
$routes->add('new_booking', new Route(
    '/booking/new',
    ['_controller' => 'BookingController', '_method' => 'new']
));
$routes->add('show_booking', new Route(
    '/booking/view',
    ['_controller' => 'BookingController', '_method' => 'show']
));
$routes->add('list_timeslots', new Route(
    '/booking/new/timeslots',
    ['_controller' => 'BookingController', '_method' => 'getTimeSlots']
));
$routes->add('confirm_booking', new Route(
    '/booking/confirm',
    ['_controller' => 'BookingController', '_method' => 'confirmBooking']
));
$routes->add('realize_booking', new Route(
    '/booking/realize',
    ['_controller' => 'BookingController', '_method' => 'realizeBooking']
));

$routes->add('cancel_booking', new Route(
    '/booking/cancel',
    ['_controller' => 'BookingController', '_method' => 'cancelBooking']
));

/* Job Routes */
$routes->add('start_job_from_booking', new Route(
    '/job/new',
    ['_controller' => 'JobController', '_method' => 'new']
));

/* ServiceOrder Routes */
$routes->add('list_service-order', new Route(
    '/service-order',
    ['_controller' => 'ServiceOrderController', '_method' => 'list']
));
$routes->add('view_service-order', new Route(
    '/service-order/view',
    ['_controller' => 'ServiceOrderController', '_method' => 'show']
));
$routes->add('hold_service-order', new Route(
    '/service-order/hold',
    ['_controller' => 'ServiceOrderController', '_method' => 'hold']
));
$routes->add('start_service-order', new Route(
    '/service-order/start',
    ['_controller' => 'ServiceOrderController', '_method' => 'start']
));
$routes->add('restart_service-order', new Route(
    '/service-order/restart',
    ['_controller' => 'ServiceOrderController', '_method' => 'restart']
));
$routes->add('complete_service-order', new Route(
    '/service-order/complete',
    ['_controller' => 'ServiceOrderController', '_method' => 'complete']
));
$routes->add('terminate_service-order', new Route(
    '/service-order/terminate',
    ['_controller' => 'ServiceOrderController', '_method' => 'terminate']
));
$routes->add('history_service-order', new Route(
    '/service-order/history',
    ['_controller' => 'ServiceOrderController', '_method' => 'history']
));

/* JobCard Routes */
$routes->add('add_item_job-card', new Route(
    '/job-card/item/new',
    ['_controller' => 'JobCardController', '_method' => 'addItem']
));
$routes->add('delete_item_job-card', new Route(
    '/job-card/item/delete',
    ['_controller' => 'JobCardController', '_method' => 'deleteItem']
));
$routes->add('load_item_job-card', new Route(
    '/job-card/item/list-partial',
    ['_controller' => 'JobCardController', '_method' => 'listItemPartial']
));
$routes->add('save_job-card', new Route(
    '/job-card/save',
    ['_controller' => 'JobCardController', '_method' => 'save']
));

/* Schedule Routes */
$routes->add('list_schedule', new Route(
    '/schedule',
    ['_controller' => 'ScheduleController', '_method' => 'list']
));
$routes->add('filter_schedule', new Route(
    '/schedule/filter',
    ['_controller' => 'ScheduleController', '_method' => 'listByDateAndEmployee']
));

/* ServiceStatus routes */
$routes->add('change_status', new Route(
    '/service/check-update-status',
    ['_controller' => 'StatusController', '_method' => 'runStatusChange']
));

/* ServiceType Routes */
$routes->add('list_service_types', new Route(
    '/service/type',
    ['_controller' => 'ServiceTypeController', '_method' => 'list']
));
$routes->add('new_service_types', new Route(
    '/service/type/new',
    ['_controller' => 'ServiceTypeController', '_method' => 'new']
));
$routes->add('view_service_types', new Route(
    '/service/type/view',
    ['_controller' => 'ServiceTypeController', '_method' => 'show']
));
$routes->add('edit_service_types', new Route(
    '/service/type/edit',
    ['_controller' => 'ServiceTypeController', '_method' => 'edit']
));
$routes->add('check_service_type_name_uniqueness', new Route(
    '/service/type/is-unique',
    ['_controller' => 'ServiceTypeController', '_method' => 'isServiceTypeNameUnique']
));

/* Bay Routes */
$routes->add('list_bay', new Route(
    '/service/bay',
    ['_controller' => 'BayController', '_method' => 'list']
));
$routes->add('new_bay', new Route(
    '/service/bay/new',
    ['_controller' => 'BayController', '_method' => 'new']
));
$routes->add('show_bay', new Route(
    '/service/bay/view',
    ['_controller' => 'BayController', '_method' => 'show']
));
$routes->add('edit_bay', new Route(
    '/service/bay/edit',
    ['_controller' => 'BayController', '_method' => 'edit']
));

/* Service Centre Options */
$routes->add('list_options', new Route(
    '/service/options/centre',
    ['_controller' => 'CentreOptionsController', '_method' => 'list']
));
$routes->add('update_working_time', new Route(
    '/centre/working/update',
    ['_controller' => 'CentreOptionsController', '_method' => 'updateWorking']
));

/* User Routes */
$routes->add('list_users', new Route(
    '/user',
    ['_controller' => 'UserController', '_method' => 'list']
));
$routes->add('new_user', new Route(
    '/user/new',
    ['_controller' => 'UserController', '_method' => 'new']
));
$routes->add('show_user', new Route(
    '/user/view',
    ['_controller' => 'UserController', '_method' => 'show']
));
$routes->add('new_user_find_profile', new Route(
    '/user/no-account-profiles',
    ['_controller' => 'UserController', '_method' => 'getProfilesSansAccount']
));
$routes->add('check_username_uniqueness', new Route(
    '/user/is-unique',
    ['_controller' => 'UserController', '_method' => 'isUsernameUnique']
));

/* Stock Routes */
$routes->add('list_stock', new Route(
    '/inventory/stock',
    ['_controller' => 'ItemController', '_method' => 'listStock']
));

/* Item Routes */
$routes->add('list_item', new Route(
    '/inventory/item',
    ['_controller' => 'ItemController', '_method' => 'list']
));
$routes->add('new_item', new Route(
    '/inventory/item/new',
    ['_controller' => 'ItemController', '_method' => 'new']
));
$routes->add('show_item', new Route(
    '/inventory/item/view',
    ['_controller' => 'ItemController', '_method' => 'show']
));
$routes->add('edit_item', new Route(
    '/inventory/item/edit',
    ['_controller' => 'ItemController', '_method' => 'edit']
));
$routes->add('delete_item', new Route(
    '/inventory/item/delete',
    ['_controller' => 'ItemController', '_method' => 'delete']
));
$routes->add('list_item_partial', new Route(
    '/inventory/item/partial',
    ['_controller' => 'ItemController', '_method' => 'tableList']
));

/* Category Routes */
$routes->add('list_categories', new Route(
    '/inventory/category',
    ['_controller' => 'CategoryController', '_method' => 'list']
));
$routes->add('new_category', new Route(
    '/inventory/category/new',
    ['_controller' => 'CategoryController', '_method' => 'new']
));
$routes->add('show_category', new Route(
    '/inventory/category/view',
    ['_controller' => 'CategoryController', '_method' => 'show']
));
$routes->add('edit_category', new Route(
    '/inventory/category/edit',
    ['_controller' => 'CategoryController', '_method' => 'edit']
));

/* Subcategory Routes */
$routes->add('list_subcategories', new Route(
    '/inventory/subcategory',
    ['_controller' => 'SubcategoryController', '_method' => 'list']
));
$routes->add('new_subcategory', new Route(
    '/inventory/subcategory/new',
    ['_controller' => 'SubcategoryController', '_method' => 'new']
));
$routes->add('show_subcategory', new Route(
    '/inventory/subcategory/view',
    ['_controller' => 'SubcategoryController', '_method' => 'show']
));
$routes->add('edit_subcategory', new Route(
    '/inventory/subcategory/edit',
    ['_controller' => 'SubcategoryController', '_method' => 'edit']
));
$routes->add('delete_subcategory', new Route(
    '/inventory/subcategory/delete',
    ['_controller' => 'SubcategoryController', '_method' => 'delete']
));
$routes->add('list_subcategories-by-category', new Route(
    '/inventory/subcategory/category',
    ['_controller' => 'SubcategoryController', '_method' => 'listSubcategoriesByCategory']
));

/* Supplier Routes */
$routes->add('list_supplier', new Route(
    '/inventory/supplier',
    ['_controller' => 'SupplierController', '_method' => 'list']
));
$routes->add('new_supplier', new Route(
    '/inventory/supplier/new',
    ['_controller' => 'SupplierController', '_method' => 'new']
));
$routes->add('show_supplier', new Route(
    '/inventory/supplier/view',
    ['_controller' => 'SupplierController', '_method' => 'show']
));
$routes->add('edit_supplier', new Route(
    '/inventory/supplier/edit',
    ['_controller' => 'SupplierController', '_method' => 'edit']
));

/* Inventory Purchase Order Routes */
$routes->add('list_purchase_order', new Route(
    '/inventory/purchase-order',
    ['_controller' => 'PurchaseOrderController', '_method' => 'list']
));
$routes->add('new_purchase_order', new Route(
    '/inventory/purchase-order/new',
    ['_controller' => 'PurchaseOrderController', '_method' => 'new']
));
$routes->add('show_purchase_order', new Route(
    '/inventory/purchase-order/view',
    ['_controller' => 'PurchaseOrderController', '_method' => 'show']
));
$routes->add('edit_purchase_order', new Route(
    '/inventory/purchase-order/edit',
    ['_controller' => 'PurchaseOrderController', '_method' => 'edit']
));
$routes->add('delete_purchase_order', new Route(
    '/inventory/purchase-order/delete',
    ['_controller' => 'PurchaseOrderController', '_method' => 'delete']
));
$routes->add('add_item_purchase_order', new Route(
    '/inventory/purchase-order/item/add',
    ['_controller' => 'PurchaseOrderController', '_method' => 'addItem']
));

/* Inventory GRN - Receive Items */
$routes->add('new_grn', new Route(
    '/inventory/grn/receive',
    ['_controller' => 'GrnController', '_method' => 'receive']
));
$routes->add('list_grn', new Route(
    '/inventory/grn',
    ['_controller' => 'GrnController', '_method' => 'list']
));

/* Sale - Item */
$routes->add('new_item_sale', new Route(
    '/sale/item/new',
    ['_controller' => 'SalesController', '_method' => 'sellItem']
));
$routes->add('get_customers', new Route(
    '/sale/customers',
    ['_controller' => 'SalesController', '_method' => 'getCustomers']
));

/* Login Routes */
$routes->add('login_user', new Route(
    '/login',
    ['_controller' => 'LoginController', '_method' => 'login']
));
$routes->add('logout_user', new Route(
    '/logout',
    ['_controller' => 'LoginController', '_method' => 'logout']
));

/* Home Routes */
$routes->add('root', new Route(
    '/',
    ['_controller' => 'HomeController', '_method' => 'home']
));
$routes->add('home', new Route(
    '/home/{p_id}',
    ['_controller' => 'HomeController', '_method' => 'home']
));
$routes->add('dashboard', new Route(
    '/dashboard',
    ['_controller' => 'HomeController', '_method' => 'home']
));

/* Report Routes */
$routes->add('empreport', new Route(
    '/report/employee',
    ['_controller' => 'ReportController', '_method' => 'employeeList']
));
$routes->add('empjobreport', new Route(
    '/report/employee/job-count',
    ['_controller' => 'ReportController', '_method' => 'findWithJobCount']
));

/* CustomReport Routes */
$routes->add('customerreport', new Route(
    '/c-report/customer',
    ['_controller' => 'CustomReportController', '_method' => 'customerList']
));
$routes->add('employeereport', new Route(
    '/c-report/employee/service-count',
    ['_controller' => 'CustomReportController', '_method' => 'emloyeeServiceCount']
));
$routes->add('serviceaverage', new Route(
    '/c-report/service/average',
    ['_controller' => 'CustomReportController', '_method' => 'serviceAverage']
));
$routes->add('servicetypesreport', new Route(
    '/c-report/service/list',
    ['_controller' => 'CustomReportController', '_method' => 'serviceTypesList']
));



/* Test Routes */
$routes->add('test', new Route(
    '/test',
    ['_controller' => 'TestController', '_method' => 'test']
));
$routes->add('testnewmapper', new Route(
    '/testnewmapper',
    ['_controller' => 'TestController', '_method' => 'testnewmapper']
));
$routes->add('testnewmapper', new Route(
    '/testmethod',
    ['_controller' => 'TestController', '_method' => 'testMethod']
));
$routes->add('testinterface', new Route(
    '/testinterface',
    ['_controller' => 'TestController', '_method' => 'testInterface']
));

return $routes;
