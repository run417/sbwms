<?php

namespace sbwms\Controller;

use sbwms\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobController extends BaseController {
    private $request;

    public function __construct(Request $_r) {
        $this->request = $_r;
    }

    public function new() {
        $bookingId = $this->request->query->get('id'); // null or ''
        exit(var_dump($bookingId));
        $errors = $this->formHandler->validate($bookingId, 'booking'); // validate id specifically.
        if ($errors) {
            return new Response($this->render_result($errors));
        }
        $formData = ['bookingId' => $bookingId, '_origin' => 'user'];
        $job = $this->formhandler->createEntity($formData);
        $result = $this->repository;
        // get booking id;
    }
}
