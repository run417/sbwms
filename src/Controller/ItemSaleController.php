<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Validator;
use sbwms\Model\RecordUpdaterService;
use sbwms\Model\RecordFinderService;


class ItemSaleController extends BaseController {
    private $request;
    private $validator;
    private $recordFinderService;
    private $recordUpdaterService;

    public function __construct(
        Request $_request,
        Validator $_v,
        RecordFinderService $_rfs,
        RecordUpdaterService $_rus
    ) {
        $this->request = $_request;
        $this->validator = $_v;
        $this->recordFinderService = $_rfs;
        $this->recordUpdaterService = $_rus;
    }

    public function new() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $result = $this->recordUpdaterService->makeItemSale($data);
            return $result;
        }
    }
}
