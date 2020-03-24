<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;

class ErrorController extends BaseController {

    public function notFound() {
        $html = $this->render_view(VIEWS . '404.view.php');
        return new Response($html, 404);
    }
}