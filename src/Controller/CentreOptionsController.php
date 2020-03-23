<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Validator;
use sbwms\Model\RecordUpdaterService;
use sbwms\Model\RecordFinderService;
use sbwms\Model\Centre\BusinessHours\BusinessHoursFormHandler;
use sbwms\Model\Centre\CentreOptionsRepository;


class CentreOptionsController extends BaseController {
    private $request;
    private $oPFormHandler;
    private $cORepository;

    public function __construct(
        Request $_request,
        BusinessHoursFormHandler $_opfh,
        CentreOptionsRepository $_cor
    ) {
        $this->request = $_request;
        $this->oPFormHandler = $_opfh;
        $this->cORepository = $_cor;
    }

    public function list() {
        $businessHours = $this->cORepository->getBusinessHours();
        // exit(var_dump($businessHours));
        $data = compact('businessHours');
        $html = $this->render_view(VIEWS . 'service/centre/viewCentreOptions.view.php', $data);
        return new Response($html);
    }

    public function updateWorking() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $formData['dataSource'] = 'user';
            $operatingPeriod = $this->oPFormHandler->createEntity($formData);
            $result = $this->cORepository->save($operatingPeriod);
            return new Response($this->render_result($result));
            // try {
            //     $this->oPFormhandler->createEntity($formData);
            // } catch (ValidationException $vex) {
            //     $errors = json_decode($vex->getMessage());
            //     return new Response($this->render_result($errors));
            // }
            exit(var_dump($formData['open']['monday']));
        }
    }
}