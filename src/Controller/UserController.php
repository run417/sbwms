<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\User\UserFormHandler;
use sbwms\Model\User\UserRepository;

class UserController extends BaseController {

    private $request;
    private $formHandler;
    private $userRepository;

    public function __construct(
        Request $_request,
        UserFormHandler $_userFormHandler,
        UserRepository $_userRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_userFormHandler;
        $this->userRepository = $_userRepository;
    }

    public function new() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $html = $this->render_view(VIEWS . 'user/createUser.view.php');
            return new Response($html);
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $formData['_origin'] = 'user';
            if ($this->formHandler->validate($formData)) {
                return new Response($this->render_result($errors));
            }
            $user = $this->formHandler->createEntity($formData);
            $result = $this->userRepository->save($user);
            return new Response($this->render_result($result));
        }
    }

    public function list() {
        $users = $this->userRepository->findAll();
        $data = compact('users');
        $html = $this->render_view(VIEWS . 'user/listUser.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $id = $this->request->query->get('id');

        if ($id !== null && $id !== '') {
            $user = $this->userRepository->findById($id);
            if ($user === null) {
                return $this->list();
            }
            $html = $this->render_view(VIEWS . 'user/viewUser.view.php', compact('user'));
            return new Response($html);
        }
        return $this->list();
    }
    public function getProfilesSansAccount() {
        $userRole = $this->request->query->get('role');
        if (
            $userRole === '' ||
            $userRole === null ||
            $this->formHandler->isUserRoleInValid($userRole)
        ) {
            $message = 'Bad Request! Invalid User Role!';
            return new Response($message, 400);
        }

        $profiles = $this->formHandler->findProfilesSansAccount($userRole);
        $data = compact('profiles');
        $html = $this->render_view(VIEWS . 'user/profileTable.partial.view.php', $data);
        return new Response($html);
    }

    public function isUsernameUnique() {
        $username = $this->request->query->get('username');
        if ($username === '' || $username === null) {
            return new Response('Bad Request! Username not set!', 400);
        }
        $message = $this->formHandler->isUsernameUnique($username);
        if (!$message) $message = "$username is already taken. Try another username";
        return new Response(json_encode($message));
    }
}
