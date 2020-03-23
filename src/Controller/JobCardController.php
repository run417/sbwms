<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Validator;
use sbwms\Model\RecordUpdaterService;
use sbwms\Model\RecordFinderService;


class JobCardController extends BaseController {
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

    public function addItem() {
        // POST
        $formData = $this->request->request->getIterator()->getArrayCopy();
        $result = $this->recordUpdaterService->insertItemToJobCard($formData);
        if ($result) {
            $jobCardItems = $this->recordFinderService->findJobCardItems($formData['id']);
            $total = 0;
            foreach ($jobCardItems as $i) {
                $total += ($i['quantity'] * $i['selling_price']);
            }
            $data = compact('jobCardItems');
            $html = $this->render_view(VIEWS . '/item/spareItemsUsedTable.partial.view.php', $data);
            $result = ['result' => $result, 'data' => ['html' => $html, 'total' => sprintf('%0.2f', $total)]];
            return new Response($this->render_result($result));
        }
    }

    public function deleteItem() {
        // POST
        $formData = $this->request->request->getIterator()->getArrayCopy();
        $result = $this->recordUpdaterService->removeItemFromJobCard($formData);
        return new Response($this->render_result($result));
    }

    public function save() {
        // POST
        $formData = $this->request->request->getIterator()->getArrayCopy();
        $result = $this->recordUpdaterService->saveJobCard($formData);
        return new Response($this->render_result($result));
    }

    public function listItemPartial() {
        $id = $this->request->query->get('id');
        $jobCardItems = $this->recordFinderService->findJobCardItems($id);
        $total = 0;
        foreach ($jobCardItems as $i) {
            $total += ($i['quantity'] * $i['selling_price']);
        }
        $data = compact('jobCardItems');
        $html = $this->render_view(VIEWS . '/item/spareItemsUsedTable.partial.view.php', $data);
        return new Response($html);
    }
}
