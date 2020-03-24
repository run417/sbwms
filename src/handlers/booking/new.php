<?php 

$timeSlot = $request->query->get('timeSlot');

if ($timeSlot !== null && $timeSlot !== '') {
    // get time slots for this service.
    echo "Time slots for $timeSlot";
    return;
}

use sbwms\Service\ServiceTypeMapper;
use sbwms\Service\ServiceTypeRepository;

$serviceTypeMapper = new ServiceTypeMapper($pdoAdapter);
$serviceTypeRepository = new ServiceTypeRepository($serviceTypeMapper);

$serviceTypes = $serviceTypeRepository->findAllServiceTypes();

require_once VIEWS . 'booking/createBooking.view.php';