<?php

use sbwms\Service\ServiceType;
use sbwms\Service\ServiceTypeMapper;
use sbwms\Service\ServiceTypeRepository;

if ($request->getMethod() === 'POST') {

    /** @var array */
    $formData = $request->request->getIterator()->getArrayCopy();

    /** @var ServiceTypeMapper */
    $serviceTypeMapper = new ServiceTypeMapper($pdoAdapter);

    /** @var ServiceType */
    $serviceType = $serviceTypeMapper->create($formData);

    /** @var ServiceTypeRepository */
    $serviceTypeRepository = new ServiceTypeRepository($serviceTypeMapper);

    /** @var true|null */
    $result = $serviceTypeRepository->save($serviceType);

    
    
    /* 
        0 = success
        1 = failure (expect error list)
    */

    /** @var int */
    $successStatus = 1;

    if ($result === true) { $successStatus = 0; }
    $resultArray = [
        'result' => $result,
        'success' => $successStatus,
    ];

    echo json_encode($resultArray); // buffered
    return;
}

require_once VIEWS . '/service/type/createServiceType.view.php';