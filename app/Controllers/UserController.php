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
                'password' => hash('sha512',trim($_POST['password'])),
                'userProfilePic' => trim($_POST['userProfilePic'])
            ];

            try {
                $this->db->beginTransaction();

                $userId = $this->userModel->create($data['name'], $data['email'], $data['password'], $data['userProfilePic']);
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
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => hash('sha512',trim($_POST['password'])),
            ];
            if ($this->userModel->findUserByEmail($data['email'])) {
                $userFetched = $this->userModel->checkPassword($data['email'], $data['password']);

                if (!empty($userFetched)) {
                    $this->startUserSession($userFetched);
                }
            }
        }
    }

    public function startUserSession($user)
    {
        $_SESSION['user'] = $user;
    }

    public function logout()
    {
        $_SESSION = null;
        session_destroy();

        header('location: ' . 'http://localhost:8000/login');
    }


}