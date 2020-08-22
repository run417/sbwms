<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Service\Bay\BayFormHandler;
use sbwms\Model\Service\Bay\BayRepository;
use sbwms\Controller\BaseController;


class BayController extends BaseController {
    private $request;
    private $formHandler;
    private $bayRepository;

    public function __construct(
        Request $_request,
        BayFormHandler $_formHandler,
        BayRepository $_bayRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_formHandler;
        $this->bayRepository = $_bayRepository;
    }

    public function list() {
        $bays = $this->bayRepository->findAll();
        // $bays = [];
        $data = compact('bays');
        $html = $this->render_view(VIEWS . '/service/bay/listBay.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $returnType = $this->request->query->get('type') ?? null;
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! No Bay Id!';
            return new Response($message, 400);
        }
        $bay = $this->bayRepository->findById($id);
        $data = compact('bay');
        if ($returnType) { // assumed row partial type
            $html = $this->render_view(VIEWS . '/service/bay/viewBayTableRow.partial.view.php', $data);
            return new Response($html);
        }
        return new Response('no return type set!');
    }

    public function new() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['_origin'] = 'user';
            $bay = $this->formHandler->createEntity($formData);
            $result = $this->bayRepository->save($bay);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
        return new Response('use list view modal (no get method)');
    }

    public function edit() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $id = $this->request->query->get('id');
            if ($id === '' || $id === null) {
                $message = 'Bad Request! No Bay Id!';
                return new Response($message, 400);
            }
            $bay = $this->bayRepository->findById($id);
            return new Response($this->formHandler->serialize($bay));
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['_origin'] = 'user';
            $bay = $this->formHandler->createEntity($formData);
            $result = $this->bayRepository->save($bay);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
    }
}
