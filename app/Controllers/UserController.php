<?php

namespace App\Controllers;

use App\Models\Model;
use App\Models\User;
use App\Views\View;
use Throwable;

class UserController extends Model
{

    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        parent::__construct();
    }

    /**
     * @throws Throwable
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'userProfilePic'=>trim($_POST['userProfilePic']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            /** Simply needed on this if else: Looks too messy */
            if (empty($data['email'])) {
                $data['email_error'] = 'Please Enter email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email already Taken';
                }
            }
            if (empty($data['name'])) {
                $data['name_error'] = 'Please Enter name';
            }
            if (empty($data['password'])) {
                $data['password_error'] = 'Please Enter password';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please confirm Password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = "Password do not match";
                }
            }

            if (empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                try {
                    $this->db->beginTransaction();


                    $userId = $this->userModel->create($data['name'], $data['email'], $data['password'],$data['userProfilePic']);
                    $user = $this->userModel->find($userId);

                    $this->startUserSession($user);

                    $this->db->commit();
                } catch (Throwable $e) {
                    if ($this->db->inTransaction()) {
                        $this->db->rollBack();
                    }
                    throw $e;
                }

                return View::make('message');
            }

            return View::make('message');

        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['email']) || empty($data['password'])) {
                $data['password_err'] = 'You are missing either of this';
            }

            if ($this->userModel->findUserByEmail($data['email'])) {
                $userFetched = $this->userModel->checkPassword($data['email'], $data['password']);

                if (!empty($userFetched)) {

                    $this->startUserSession($userFetched);

                }
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            $this->view('users/login', $data);
        }
    }

    public function startUserSession($user)
    {
        $_SESSION['user'] = $user;


        header('location: ' . 'http://localhost:8000/posts');
    }

    public function logout()
    {
        $_SESSION = null;
        session_destroy();

        header('location: ' . 'http://localhost:8000/login');
    }


}