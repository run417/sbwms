<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Inventory\Item\ItemFormHandler;
use sbwms\Model\Inventory\Item\ItemRepository;
use sbwms\Model\Inventory\Category\CategoryRepository;
use sbwms\Model\Inventory\Category\SubcategoryRepository;
use sbwms\Model\Inventory\Supplier\SupplierRepository;

class ItemController extends BaseController {

    private $request;
    private $formHandler;
    private $itemRepository;
    private $categoryRepository;
    private $subcategoryRepository;
    private $supplierRepository;

    public function __construct(
        Request $_request,
        ItemFormHandler $_ifh,
        ItemRepository $_ir,
        CategoryRepository $_cr,
        SubcategoryRepository $_subrepo,
        SupplierRepository $_suprepo
    ) {
        $this->request = $_request;
        $this->formHandler = $_ifh;
        $this->itemRepository = $_ir;
        $this->categoryRepository = $_cr;
        $this->subcategoryRepository = $_subrepo;
        $this->supplierRepository = $_suprepo;
    }

    public function list() {
        $items = $this->itemRepository->findAllActive();
        $categories = $this->categoryRepository->findAllActive();
        $subcategories = $this->subcategoryRepository->findAllActive();
        $suppliers = $this->supplierRepository->findAllActive();
        $data = compact('items', 'categories', 'subcategories', 'suppliers');
        $html = $this->render_view(VIEWS . '/item/listItem.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $returnType = $this->request->query->get('type') ?? null;
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! No Item Id!';
            return new Response($message, 400);
        }
        $item = $this->itemRepository->findById($id);
        $data = compact('item');
        if ($returnType) { // assumed 'row-partial' type
            $html = $this->render_view(VIEWS . '/item/viewItemTableRow.partial.view.php', $data);
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
            $formData['dataSource'] = 'user';
            $item = $this->formHandler->createEntity($formData);
            $result = $this->itemRepository->save($item);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
        return new Response('get method not supported');
    }

    public function edit() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $id = $this->request->query->get('id') ?? '';
            $item = $this->itemRepository->findById($id);
            if ($item) {
                return new Response($this->formHandler->serialize($item));
            } else {
                $message = "Item Not Found for Id - '$id'" ;
                return new Response($message, 404);
            }
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['dataSource'] = 'user';
            $item = $this->formHandler->createEntity($formData);
            $result = $this->itemRepository->save($item);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
    }

    public function delete() {
        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $item = $this->itemRepository->findById($formData['id']);
            // $result = $this->subcategoryRepository->delete($subcategory);
            $result = [
                'result' => true,
                'data' => ['id' => 'IT0001', 'name' => 'Item-name'],
            ];
            return new Response($this->render_result($result));
        }
    }

    public function listStock() {
        $items = $this->itemRepository->findAllActive();
        $data = compact('items');
        $html = $this->render_view(VIEWS . '/item/listStock.view.php', $data);
        return new Response($html);
    }

    public function tableList() {
        $items = $this->itemRepository->findAllActive();
        $data = compact('items');
        $html = $this->render_view(VIEWS . '/item/listItemTable.partial.view.php', $data);
        return new Response($html);
    }
}