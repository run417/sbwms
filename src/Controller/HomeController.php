<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;


class HomeController extends BaseController {
    private $request;

    public function __construct(
        Request $_request
    ) {
        $this->request = $_request;
    }

    public function home(string $id = '') {
        // var_dump($id);
        $html = $this->render_view(VIEWS . 'dashboard.view.php');
        return new Response($html);
    }
}