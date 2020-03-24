<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Inventory\Grn\GrnFormHandler;
use sbwms\Model\Inventory\Grn\GrnRepository;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderRepository;
use sbwms\Controller\BaseController;

class GrnController extends BaseController {
    private $request;
    private $formHandler;
    private $purchaseOrderRepository;
    private $grnRepository;

    public function __construct(
        Request $_request,
        GrnFormHandler $_formHandler,
        PurchaseOrderRepository $_purchaseOrderRepository,
        GrnRepository $_grnRepo
    ) {
        $this->request = $_request;
        $this->formHandler = $_formHandler;
        $this->purchaseOrderRepository = $_purchaseOrderRepository;
        $this->grnRepository = $_grnRepo;
    }

    public function list() {
        $grns = $this->grnRepository->findAllSansDetails();
        $data = compact('grns');
        $html = $this->render_view(VIEWS . '/grn/grnList.view.php', $data);
        return new Response($html);
    }

    public function receive() {
        // GET
        $purchaseOrderId = $this->request->query->get('id') ?? '';
        if ($this->request->getMethod() === 'GET') {
            $purchaseOrder = $this->purchaseOrderRepository->findById($purchaseOrderId);
            if ($purchaseOrder) {
                $data = compact('purchaseOrder');
                $html = $this->render_view(VIEWS . '/grn/receiveItems.view.php', $data);
                return new Response($html);
            }
            $message = 'Bad Request! Invalid Purchase Order Id!';
            return new Response($message, 400);
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $formData['dataSource'] = 'user';
            // if ($this->formHandler->validate($formData)) {
            //     return new Response($this->render_result($errors));
            // }
            $grn = $this->formHandler->createEntity($formData);
            $result = $this->grnRepository->save($grn);
            return new Response($this->render_result($result));
        }
    }
}