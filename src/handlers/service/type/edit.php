<?php
// controller should send the response / prepare the response
use sbwms\Service\ServiceTypeRepository;
use sbwms\Service\ServiceTypeMapper;

$serviceTypeMapper = new ServiceTypeMapper($pdoAdapter);
$serviceTypeRepository = new ServiceTypeRepository($serviceTypeMapper);

$id = $request->query->get('id');

if ($id !== null && $id !== '') {

    $serviceType = $serviceTypeRepository->findById($id);

    echo $serviceTypeMapper->toJson($serviceType);
    return;
    // exit(var_dump($cjson));

}
if ($request->getMethod() === 'POST') {
    /** @var array */
    $formData = $request->request->getIterator()->getArrayCopy();
    
    /** @var ServiceType */
    $serviceType = $serviceTypeMapper->create($formData);
    
    /** @var true|null */
    $result = $serviceTypeRepository->save($serviceType);
    // $result = 'test';

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

require_once 'list.php';
