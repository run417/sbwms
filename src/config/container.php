<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


include 'database_config.php';

$containerBuilder = new ContainerBuilder();
// var_dump($containerBuilder);

$containerBuilder->register('session', Symfony\Component\HttpFoundation\Session\Session::class);

/* Error Controller */
$containerBuilder->register('ErrorController', sbwms\Controller\ErrorController::class);

/* Validator */
$containerBuilder
    ->register('validator', sbwms\Model\Validator::class)
    ->setArguments([new Reference('db')]);

/* RecordFinderService */
$containerBuilder
    ->register('record.finder.service', sbwms\Model\RecordFinderService::class)
    ->setArguments([new Reference('db')]);

/* RecordUpdaterService */
$containerBuilder
    ->register('record.updater.service', sbwms\Model\RecordUpdaterService::class)
    ->setArguments([new Reference('db')]);

$containerBuilder
    ->register('db', PDO::class)
    ->setArguments([$dsn, $user, $pass, $options]);
$containerBuilder
    ->register('adapter', sbwms\Model\PDOAdapter::class)
    ->setArguments([new Reference('db')]);
$containerBuilder
    ->register('request', Symfony\Component\HttpFoundation\Request::class)
    ->setFactory([
        (Symfony\Component\HttpFoundation\Request::class),
        'createFromGlobals'
    ]);

/* Vehicle */
$containerBuilder
    ->register('vehicle.mapper', sbwms\Model\Vehicle\VehicleMapper::class)
    ->setArguments([new Reference('db')]);
$containerBuilder
    ->register('vehicle.repository', sbwms\Model\Vehicle\VehicleRepository::class)
    ->setArguments([new Reference('vehicle.mapper')]);

/* Customer */
$containerBuilder
    ->register('customer.mapper', sbwms\Model\CustomerMapper::class)
    ->setArguments([new Reference('db')]);
$containerBuilder
    ->register('customer.repository', sbwms\Model\CustomerRepository::class)
    ->setArguments([new Reference('customer.mapper')]);
$containerBuilder
    ->register('CustomerController', sbwms\Controller\CustomerController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('customer.mapper'),
            new Reference('customer.repository'),
            new Reference('vehicle.repository'),
            new Reference('vehicle.mapper'),
        ]
    );

/* Employee */
$containerBuilder
    ->register('employee.mapper', sbwms\Model\Employee\EmployeeMapper::class)
    ->setArguments([
        new Reference('db'),
        new Reference('employee.entity.manager'),
    ]);
$containerBuilder
    ->register('employee.repository', sbwms\Model\Employee\EmployeeRepository::class)
    ->setArguments([new Reference('employee.mapper')]);
$containerBuilder
    ->register('employee.form.handler', sbwms\Model\Employee\EmployeeFormHandler::class)
    ->setArguments([
        new Reference('validator'),
        new Reference('employee.entity.manager'),
    ]);
$containerBuilder
    ->register('employee.entity.manager', sbwms\Model\Employee\EmployeeEntityManager::class)
    ->setArguments([
        new Reference('service.type.entity.manager'),
        new Reference('service.type.repository'),
    ]);
$containerBuilder
    ->register('EmployeeController', sbwms\Controller\EmployeeController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('employee.form.handler'),
            new Reference('employee.repository'),
            new Reference('service.type.repository')
        ]
    );

/* Job */
/* JobController */
$containerBuilder
    ->register('JobController', sbwms\Controller\JobController::class)
    ->setArguments(
        [
            new Reference('request'),
        ]
    );

/* ServiceOrder */
$containerBuilder
    ->register('ServiceOrderController', sbwms\Controller\ServiceOrderController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('service.order.repository'),
            new Reference(('service.order.entity.manager'))
        ]
    );
$containerBuilder
    ->register('service.order.mapper', sbwms\Model\Service\ServiceOrder\ServiceOrderMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('service.order.entity.manager'),
        ]
    );
$containerBuilder
    ->register('service.order.repository', sbwms\Model\Service\ServiceOrder\ServiceOrderRepository::class)
    ->setArguments(
        [
            new Reference('service.order.mapper'),
            new Reference('record.updater.service'),
        ]
    );
$containerBuilder
    ->register('service.order.entity.manager', sbwms\Model\Service\ServiceOrder\ServiceOrderEntityManager::class)
    ->setArguments(
        [
            new Reference('booking.repository'),
            new Reference('item.repository'),
            new Reference('booking.entity.manager'),
        ]
    );

/* JobCard */
$containerBuilder
    ->register('JobCardController', sbwms\Controller\JobCardController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('validator'),
            new Reference('record.finder.service'),
            new Reference('record.updater.service'),
        ]
    );

/* Schedule */
$containerBuilder
    ->register('ScheduleController', sbwms\Controller\ScheduleController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('service.order.repository'),
            new Reference('booking.repository'),
            new Reference('record.finder.service'),
        ]
    );

/* StatusController */
$containerBuilder
    ->register('StatusController', sbwms\Controller\StatusController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('db'),
        ]
    );

/* ReportController */
$containerBuilder
    ->register('ReportController', sbwms\Controller\ReportController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('db'),
            new Reference('employee.repository'),
            new Reference('customer.repository'),
            // new Reference('service.type.repository'),
        ]
    );

/* CustomReportController */
$containerBuilder
    ->register('CustomReportController', sbwms\Controller\CustomReportController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('db'),
        ]
    );

/* Booking */
$containerBuilder
    ->register('booking.mapper', sbwms\Model\Booking\BookingMapper::class)
    ->setArguments([
        new Reference('db'),
        new Reference('booking.entity.manager'),
    ]);
$containerBuilder
    ->register('booking.repository', sbwms\Model\Booking\BookingRepository::class)
    ->setArguments(
        [
            new Reference('vehicle.mapper'),
            new Reference('service.type.mapper'),
            new Reference('booking.mapper'),
        ]
    );
$containerBuilder
    ->register('booking.entity.manager', sbwms\Model\Booking\BookingEntityManager::class)
    ->setArguments(
        [
            new Reference('vehicle.repository'),
            new Reference('employee.repository'),
            new Reference('service.type.repository'),
        ]
    );
$containerBuilder
    ->register('booking.form.handler', sbwms\Model\Booking\BookingFormHandler::class)
    ->setArguments([
        new Reference('validator'),
        new Reference('booking.entity.manager'),
    ]);
$containerBuilder
    ->register('BookingController', sbwms\Controller\BookingController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('booking.form.handler'),
            new Reference('schedule.service'),
            new Reference('booking.repository'),
            new Reference('service.order.repository'),
        ]
    );


/* ServiceTypes */
$containerBuilder
    ->register('service.type.mapper', sbwms\Model\Service\Type\ServiceTypeMapper::class)
    ->setArguments([
        new Reference('db'),
        new Reference('service.type.entity.manager'),
    ]);
$containerBuilder
    ->register('service.type.repository', sbwms\Model\Service\Type\ServiceTypeRepository::class)
    ->setArguments([
        new Reference('service.type.mapper')
    ]);
$containerBuilder
    ->register('service.type.entity.manager', sbwms\Model\Service\Type\ServiceTypeEntityManager::class);
$containerBuilder
    ->register('service.type.form.handler', sbwms\Model\Service\Type\ServiceTypeFormHandler::class)
    ->setArguments([
        new Reference('validator'),
        new Reference('service.type.entity.manager'),
    ]);
$containerBuilder
    ->register('ServiceTypeController', sbwms\Controller\ServiceTypeController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('service.type.form.handler'),
            new Reference('service.type.repository')
        ]
    );

/* Service Bays */
$containerBuilder
    ->register('bay.entity.manager', sbwms\Model\Service\Bay\BayEntityManager::class)
    ->setArguments(
        [
            // new Reference('item.entity.manager'),
        ]
    );
$containerBuilder
    ->register('bay.form.handler', sbwms\Model\Service\Bay\BayFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('bay.entity.manager'),
        ]
    );
$containerBuilder
    ->register('bay.mapper', sbwms\Model\Service\Bay\BayMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('bay.entity.manager'),
        ]
    );
$containerBuilder
    ->register('bay.repository', sbwms\Model\Service\Bay\BayRepository::class)
    ->setArguments(
        [
            new Reference('bay.mapper'),
        ]
    );
$containerBuilder
    ->register('BayController', sbwms\Controller\BayController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('bay.form.handler'),
            new Reference('bay.repository'),
        ]
    );

/* CentreOptionsController */
$containerBuilder
    ->register('CentreOptionsController', sbwms\Controller\CentreOptionsController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('business.hours.form.handler'),
            new Reference('centre.options.repository'),
        ]
    );

/* CentreOptionsRepository */
$containerBuilder
    ->register('centre.options.repository', sbwms\Model\Centre\CentreOptionsRepository::class)
    ->setArguments(
        [
            new Reference('business.hours.mapper'),
        ]
    );

/* BusinessHours */
$containerBuilder
    ->register('business.hours.mapper', sbwms\Model\Centre\BusinessHours\BusinessHoursMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('business.hours.entity.manager'),
        ]
    );
$containerBuilder
    ->register('business.hours.form.handler', sbwms\Model\Centre\BusinessHours\BusinessHoursFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('business.hours.entity.manager'),
        ]
    );
$containerBuilder
    ->register('business.hours.entity.manager', sbwms\Model\Centre\BusinessHours\BusinessHoursEntityManager::class);

/* User */
$containerBuilder
    ->register('user.mapper', sbwms\Model\User\UserMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('user.entity.manager'),
        ]
    );
$containerBuilder
    ->register('user.repository', sbwms\Model\User\UserRepository::class)
    ->setArguments(
        [
            new Reference('user.mapper'),
        ]
    );
$containerBuilder
    ->register('user.entity.manager', sbwms\Model\User\UserEntityManager::class)
    ->setArguments(
        [
            new Reference('customer.repository'),
            new Reference('employee.repository'),
        ]
    );
$containerBuilder
    ->register('user.form.handler', sbwms\Model\User\UserFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('user.entity.manager'),
            new Reference('customer.repository'),
            new Reference('employee.repository'),
        ]
    );

$containerBuilder
    ->register('UserController', sbwms\Controller\UserController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('user.form.handler'),
            new Reference('user.repository'),
        ]
    );

/* Inventory Item */
$containerBuilder
    ->register('item.entity.manager', sbwms\Model\Inventory\Item\ItemEntityManager::class)
    ->setArguments(
        [
            new Reference('subcategory.repository'),
            new Reference('supplier.repository'),
        ]
    );
$containerBuilder
    ->register('item.form.handler', sbwms\Model\Inventory\Item\ItemFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('item.entity.manager'),
        ]
    );
$containerBuilder
    ->register('item.mapper', sbwms\Model\Inventory\Item\ItemMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('item.entity.manager'),
        ]
    );
$containerBuilder
    ->register('item.repository', sbwms\Model\Inventory\Item\ItemRepository::class)
    ->setArguments(
        [
            new Reference('item.mapper'),
        ]
    );
$containerBuilder
    ->register('ItemController', sbwms\Controller\ItemController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('item.form.handler'),
            new Reference('item.repository'),
            new Reference('category.repository'),
            new Reference('subcategory.repository'),
            new Reference('supplier.repository'),
        ]
    );

/* Inventory Category */
$containerBuilder
    ->register('category.entity.manager', sbwms\Model\Inventory\Category\CategoryEntityManager::class)
    ->setArguments(
        [
            // new Reference('item.entity.manager'),
        ]
    );
$containerBuilder
    ->register('category.form.handler', sbwms\Model\Inventory\Category\CategoryFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('category.entity.manager'),
        ]
    );
$containerBuilder
    ->register('category.mapper', sbwms\Model\Inventory\Category\CategoryMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('category.entity.manager'),
        ]
    );
$containerBuilder
    ->register('category.repository', sbwms\Model\Inventory\Category\CategoryRepository::class)
    ->setArguments(
        [
            new Reference('category.mapper'),
        ]
    );
$containerBuilder
    ->register('CategoryController', sbwms\Controller\CategoryController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('category.form.handler'),
            new Reference('category.repository'),
        ]
    );

/* Inventory Subcategory */
$containerBuilder
    ->register('subcategory.entity.manager', sbwms\Model\Inventory\Category\SubcategoryEntityManager::class)
    ->setArguments(
        [
            new Reference('category.repository'),
        ]
    );
$containerBuilder
    ->register('subcategory.form.handler', sbwms\Model\Inventory\Category\SubcategoryFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('subcategory.entity.manager'),
        ]
    );
$containerBuilder
    ->register('subcategory.mapper', sbwms\Model\Inventory\Category\SubcategoryMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('subcategory.entity.manager'),
        ]
    );
$containerBuilder
    ->register('subcategory.repository', sbwms\Model\Inventory\Category\SubcategoryRepository::class)
    ->setArguments(
        [
            new Reference('subcategory.mapper'),
        ]
    );
$containerBuilder
    ->register('SubcategoryController', sbwms\Controller\SubcategoryController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('subcategory.form.handler'),
            new Reference('subcategory.repository'),
            new Reference('category.repository'),
        ]
    );

/* Inventory Supplier */
$containerBuilder
    ->register('supplier.entity.manager', sbwms\Model\Inventory\Supplier\SupplierEntityManager::class)
    ->setArguments(
        [
            // new Reference('item.entity.manager'),
        ]
    );
$containerBuilder
    ->register('supplier.form.handler', sbwms\Model\Inventory\Supplier\SupplierFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('supplier.entity.manager'),
        ]
    );
$containerBuilder
    ->register('supplier.mapper', sbwms\Model\Inventory\Supplier\SupplierMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('supplier.entity.manager'),
        ]
    );
$containerBuilder
    ->register('supplier.repository', sbwms\Model\Inventory\Supplier\SupplierRepository::class)
    ->setArguments(
        [
            new Reference('supplier.mapper'),
        ]
    );
$containerBuilder
    ->register('SupplierController', sbwms\Controller\SupplierController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('supplier.form.handler'),
            new Reference('supplier.repository'),
        ]
    );

/* Inventory PurchaseOrder */
$containerBuilder
    ->register('purchase.order.entity.manager', sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderEntityManager::class)
    ->setArguments(
        [
            new Reference('item.repository'),
            new Reference('supplier.repository'),
        ]
    );
$containerBuilder
    ->register('purchase.order.form.handler', sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('purchase.order.entity.manager'),
        ]
    );
$containerBuilder
    ->register('purchase.order.mapper', sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('purchase.order.entity.manager'),
        ]
    );
$containerBuilder
    ->register('purchase.order.repository', sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderRepository::class)
    ->setArguments(
        [
            new Reference('purchase.order.mapper'),
        ]
    );
$containerBuilder
    ->register('PurchaseOrderController', sbwms\Controller\PurchaseOrderController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('purchase.order.form.handler'),
            new Reference('purchase.order.repository'),
            new Reference('supplier.repository'),
        ]
    );

/* Inventory GRN */
$containerBuilder
    ->register('grn.entity.manager', sbwms\Model\Inventory\Grn\GrnEntityManager::class)
    ->setArguments(
        [
            new Reference('item.repository'),
            new Reference('purchase.order.repository'),
        ]
    );
$containerBuilder
    ->register('grn.form.handler', sbwms\Model\Inventory\Grn\GrnFormHandler::class)
    ->setArguments(
        [
            new Reference('validator'),
            new Reference('grn.entity.manager'),
        ]
    );
$containerBuilder
    ->register('grn.mapper', sbwms\Model\Inventory\Grn\GrnMapper::class)
    ->setArguments(
        [
            new Reference('db'),
            new Reference('grn.entity.manager'),
        ]
    );
$containerBuilder
    ->register('grn.repository', sbwms\Model\Inventory\Grn\GrnRepository::class)
    ->setArguments(
        [
            new Reference('grn.mapper'),
        ]
    );
$containerBuilder
    ->register('GrnController', sbwms\Controller\GrnController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('grn.form.handler'),
            new Reference('purchase.order.repository'),
            new Reference('grn.repository'),
        ]
    );

/* Sales - Item */
$containerBuilder
    ->register('SalesController', sbwms\Controller\SalesController::class)
    ->setArguments(
        [
            new Reference('request'),
            // new Reference('purchase.order.form.handler'),
            new Reference('customer.repository'),
        ]
    );

/* LoginController */
$containerBuilder
    ->register('LoginController', sbwms\Controller\LoginController::class)
    ->setArguments(
        [
            new Reference('request'),
            new Reference('user.repository'),
        ]
    );

/* HomeController */
$containerBuilder
    ->register('HomeController', sbwms\Controller\HomeController::class)
    ->setArguments(
        [
            new Reference('request'),
        ]
    );

/* Test */
$containerBuilder
    ->register('schedule.service', sbwms\Model\Booking\ScheduleService::class)
    ->setArguments(
        [
            new Reference('service.type.repository'),
            new Reference('employee.repository'),
        ]
    );
// $containerBuilder
//     ->register('new.employee.mapper', sbwms\Model\Employee\newEmployeeMapper::class)
//     ->setArguments([new Reference('db')]);

$containerBuilder
    ->register('TestController', sbwms\Controller\TestController::class)
    ->setArguments([
        new Reference('db'),
        new Reference('request'),
        new Reference('schedule.service'),
        new Reference('employee.mapper'),
        new Reference('vehicle.mapper')
    ]);

return $containerBuilder;
