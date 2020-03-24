<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\User\UserFormHandler;
use sbwms\Model\User\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends BaseController {
    private $request;
    // private $formHandler;
    private $userRepository;

    public function __construct(
        Request $_request,
        // UserFormHandler $_userFormHandler,
        UserRepository $_userRepository
    ) {
        $this->request = $_request;
        $this->userRepository = $_userRepository;
    }

    public function login() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $html = $this->render_view(VIEWS . 'login.view.php');
            return new Response($html);
        }

        if ($this->request->getMethod() === 'POST') {
            $errors = [];
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $username = $formData['username'];
            $user = $this->userRepository->findByUsername($username);
            if ($user) { $user = array_shift($user); }
            if ($user === null) {
                $errors['status'] = 2;
                $errors['message'] = 'Username or Password is incorrect';
                return new Response(\json_encode($errors));
            }
            if ($user->getStatus() === 'suspended') {
                $errors['status'] = 2;
                $errors['message'] = 'User is suspended. Please contact administrator.';
                return new Response(\json_encode($errors));
            }
            if ($user->getPassword() !== $formData['password']) {
                $errors['status'] = 2;
                $errors['message'] = 'Username or Password is incorrect';
                return new Response(\json_encode($errors));
            }
            $session = new \Symfony\Component\HttpFoundation\Session\Session();
            $userInfoArray = [
                'userId' => $user->getId(),
                'accountType' => $user->getAccountType(),
                'username' => $user->getUsername(),
                'profileId' => $user->getProfile()->getId(),
                'userRole' => $user->getUserRole(),
            ];
            $session->set('user', $userInfoArray);
            $output['status'] = 0;
            return new Response(\json_encode($output));
            // return new RedirectResponse('http://localhost/sbwms/public/booking/view?id=B0001');
            var_dump($user);
            exit();
        }
    }
    
    public function logout() {
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $session->remove('user');
        return new RedirectResponse('http:\\sbwms\public\login');
    }
}