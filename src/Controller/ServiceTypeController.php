<?php

namespace sbwms\Controller;

use sbwms\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Service\Type\ServiceTypeFormHandler;
use sbwms\Model\Service\Type\ServiceTypeRepository;

class ServiceTypeController extends BaseController {
    private $request;
    private $formHandler;
    private $repository;

    public function __construct(
        Request $_request,
        ServiceTypeFormHandler $_serviceTypeFormHandler,
        ServiceTypeRepository $_serviceTypeRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_serviceTypeFormHandler;
        $this->repository = $_serviceTypeRepository;
    }

    public function list() {
        /** @var array|null An array of ServiceType instances or null */
        $serviceTypes = $this->repository->findAll();
        $data = compact('serviceTypes');
        $html = $this->render_view(
            VIEWS . 'service/type/listServiceType.view.php',
            $data
        );
        return new Response($html);
    }

    public function show() {
        $returnType = $this->request->query->get('type') ?? null;
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! No Service Type Id!';
            return new Response($message, 400);
        }
        $serviceType = $this->repository->findById($id);
        // exit(var_dump($serviceType));
        $data = compact('serviceType');
        if ($returnType) { // assumed 'row-partial' type
            $html = $this->render_view(VIEWS . '/service/type/viewServiceTypeTableRow.partial.view.php', $data);
            return new Response($html);
        }
        return new Response('no return type set!');
    }

    public function new() {
        if ($this->request->getMethod() === 'POST') {

            /** @var array */
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }

            /** @var ServiceType */
            $formData['_origin'] = 'user';
            $serviceType = $this->formHandler->createEntity($formData);

            /** @var bool */
            $result = $this->repository->save($serviceType);

            return new Response($this->render_result($result));
        }
        // if request is GET
        $html = $this->render_view(VIEWS . 'service/type/createServiceType.view.php');
        return new Response($html);
    }

    public function edit() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $id = $this->request->query->get('id');
            if ($id === '' || $id === null) {
                $message = 'Bad Request! No Service Type Id!';
                return new Response($message, 400);
            }
            $serviceType = $this->repository->findById($id);
            return new Response($this->formHandler->serialize($serviceType));
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['_origin'] = 'user';
            $serviceType = $this->formHandler->createEntity($formData);
            $result = $this->repository->save($serviceType);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'ST0010', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
    }
    public function isServiceTypeNameUnique() {
        $name = $this->request->query->get('name');
        $currentId = $this->request->query->get('id');
        if ($name === '' || $name === null) {
            return new Response('Bad Request! name not set!', 400);
        }
        $message = $this->formHandler->isServiceTypeNameUnique($name, $currentId);
        if (!$message) $message = "$name name is already taken. Try another name";
        return new Response(json_encode($message));
    }
}
