<?php

use sbwms\Service\ServiceTypeMapper;
use sbwms\Service\ServiceTypeRepository;

/** @var array|null An array of ServiceType instances or null */
$serviceTypes = (new ServiceTypeRepository(new ServiceTypeMapper($pdoAdapter)))->findAllServiceTypes();

require_once VIEWS . 'service/type/listServiceType.view.php';