<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Inventory\Category\SubcategoryFormHandler;
use sbwms\Model\Inventory\Category\SubcategoryRepository;
use sbwms\Model\Inventory\Category\CategoryRepository;
use sbwms\Controller\BaseController;

class SubcategoryController extends BaseController {
    private $request;
    private $formHandler;
    private $subcategoryRepository;
    private $categoryRepository;

    public function __construct(
        Request $_request,
        SubcategoryFormHandler $_formHandler,
        SubcategoryRepository $_subcategoryRepository,
        CategoryRepository $_categoryRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_formHandler;
        $this->subcategoryRepository = $_subcategoryRepository;
        $this->categoryRepository = $_categoryRepository;
    }

    public function list() {
        $categories = $this->categoryRepository->findAll();
        $subcategories = $this->subcategoryRepository->findAllActive();
        $data = compact('subcategories', 'categories');
        $html = $this->render_view(VIEWS . '/category/listSubcategory.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $returnType = $this->request->query->get('type') ?? null;
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! No Subcategory Id!';
            return new Response($message, 400);
        }
        $subcategory = $this->subcategoryRepository->findById($id);
        $data = compact('subcategory');
        if ($returnType) { // assumed 'row-partial' type
            $html = $this->render_view(VIEWS . '/category/viewSubcategoryTableRow.partial.view.php', $data);
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
            $subcategory = $this->formHandler->createEntity($formData);
            $result = $this->subcategoryRepository->save($subcategory);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
        return new Response('get method');
    }

    public function edit() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $id = $this->request->query->get('id');
            if ($id === '' || $id === null) {
                $message = 'Bad Request! No Subcategory Id!';
                return new Response($message, 400);
            }
            $subcategory = $this->subcategoryRepository->findById($id);
            return new Response($this->formHandler->serialize($subcategory));
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['dataSource'] = 'user';
            $subcategory = $this->formHandler->createEntity($formData);
            $result = $this->subcategoryRepository->save($subcategory);
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
            $subcategory = $this->subcategoryRepository->findById($formData['id']);
            // $result = $this->subcategoryRepository->delete($subcategory);
            $result = [
                'result' => true,
                'data' => ['id' => 'SCAT001', 'name' => 'Engine Oils'],
            ];
            return new Response($this->render_result($result));
        }
    }

    public function listSubcategoriesByCategory() {
        $categoryId = $this->request->query->get('id') ?? '';
        $subcategories = $this->subcategoryRepository->findByCategory($categoryId);
        if ($subcategories) {
            $data = compact('subcategories');
            $html = $this->render_view(VIEWS . '/category/listSubcategoriesHtmlSelect.partial.view.php', $data);
            return new Response($html);
        }
        return new Response('No subcategories');
    }
}