<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Inventory\Category\CategoryFormHandler;
use sbwms\Model\Inventory\Category\CategoryRepository;
use sbwms\Controller\BaseController;


class CategoryController extends BaseController {
    private $request;
    private $formHandler;
    private $categoryRepository;

    public function __construct(
        Request $_request,
        CategoryFormHandler $_formHandler,
        CategoryRepository $_categoryRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_formHandler;
        $this->categoryRepository = $_categoryRepository;
    }

    public function list() {
        $returnType = $this->request->query->get('return-type') ?? null;
        $categories = $this->categoryRepository->findAll();
        // $categories = [];
        $data = compact('categories');
        if ($returnType) {
            $html = $this->render_view(VIEWS . '/category/listCategory.partial.view.php', $data);
            return new Response($html);
        }
        $html = $this->render_view(VIEWS . '/category/listCategory.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $returnType = $this->request->query->get('type') ?? null;
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! No Category Id!';
            return new Response($message, 400);
        }
        $category = $this->categoryRepository->findById($id);
        $data = compact('category');
        if ($returnType) { // assumed row partial type
            $html = $this->render_view(VIEWS . '/category/viewCategoryTableRow.partial.view.php', $data);
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
            $category = $this->formHandler->createEntity($formData);
            $result = $this->categoryRepository->save($category);
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
                $message = 'Bad Request! No Category Id!';
                return new Response($message, 400);
            }
            $category = $this->categoryRepository->findById($id);
            return new Response($this->formHandler->serialize($category));
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['_origin'] = 'user';
            $category = $this->formHandler->createEntity($formData);
            $result = $this->categoryRepository->save($category);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
    }
}
