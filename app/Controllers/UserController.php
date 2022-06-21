<?php

namespace App\Controllers;

use App\Exceptions\EmptyEmailPasswordException;
use App\Exceptions\LoginException;
use App\Exceptions\RegisterEmptyFieldsExceptions;
use App\Exceptions\RegisterPasswordShouldBeSameException;
use App\Models\Model;
use App\Models\User;
use App\Views\View;
use Exception;
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
                if(empty($data['name']) || empty($data['password'] || empty($data['email']))) {
                    throw new RegisterEmptyFieldsExceptions("Name or Email or Password cannot be empty");
                } else {
                    try {
                        if($data['password'] == $_POST['repeat_password']) {
                            try {
                                $this->db->beginTransaction();

                                $userId = $this->userModel->create($data['name'], $data['email'], $data['password'], $data['userProfilePic']);
                                $user = $this->userModel->find($userId);
                                if($_SESSION == null || !isAdmin()) {
                                    $this->startUserSession($user);
                                }
                                $this->db->commit();
                                if(isAdmin()) {
                                    $_SESSION['message'] = 'User has been added';
                                    header('location: '. 'http://localhost:8000/admin');
                                } else {
                                    return View::make('message');
                                }
                            } catch (Throwable $e) {
                                if ($this->db->inTransaction()) {
                                    $this->db->rollBack();
                                }
                                $params = [
                                    'error' => $e->getMessage()
                                ];
                                echo View::make('exceptionsViews/identicalUserError', $params);
                            }
                        } else {
                            throw new RegisterPasswordShouldBeSameException("You must type same password twice");
                        }
                    } catch (Exception $e) {
                        $params = [
                            'error' => $e->getMessage()
                        ];
                        echo View::make('exceptionsViews/registerPasswordShouldBeSameError', $params);
                    }
                }
            } catch (RegisterEmptyFieldsExceptions $e) {
                $params = [
                    'error' => $e->getMessage()
                ];
                echo View::make('exceptionsViews/registerEmptyFieldsError', $params);
            }
        }
    }

    /**
     * @throws Throwable
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => hash('sha512',trim($_POST['password'])),
            ];
            try {
                if(empty($data['email']) || empty($data['password'])) {
                    throw new EmptyEmailPasswordException("Email or password cannot be null");
                } else {
                    try {
                        if ($this->userModel->findUserByEmail($data['email'])) {
                            try {
                                $userFetched = $this->userModel->checkPassword($data['email'], $data['password']);
                                if (!empty($userFetched)) {
                                    $this->startUserSession($userFetched);
                                    header('location: '.'http://localhost:8000/posts');
                                }
                            } catch (Exception $e) {
                                $params = [
                                    'error' => $e->getMessage()
                                ];
                                echo View::make('exceptionsViews/passwordIncorrectError',$params);
                            }

                        } else {
                            throw new LoginException('User not found');
                        }
                    } catch (Throwable $e) {
                        $params = [
                            'error' => $e->getMessage()
                        ];
                        return View::make('exceptionsViews/loginError', $params);
                    }

                }
            } catch (EmptyEmailPasswordException $e) {
                $params = [
                    'error' => $e->getMessage()
                ];
                echo View::make('exceptionsViews/emptyEmailOrPasswordError', $params);
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

    /**
     * @throws Exception
     */
    public function admin()
    {
        if($_SESSION != null){
            if(isAdmin()) {
                return View::make('Admin/admin');
            } else {
                throw new Exception("You are not an admin");
            }
        } else {
            throw new Exception("You are not logged in");
        }
    }

    public function adminPost(): View
    {
        $user = $this->userModel->getSearchedUser($_POST['search']);
        return View::make("Admin/admin", $user);
    }
    public function updateUserByAdmin() {
        if($_POST['password']!='PASSWORD') {
            $password = $_POST['password'];
        } else {
            $password = hash('sha512',trim($_POST['password']));
        }
        $userUpdatedDetails = [
            'userId'=> $_POST['userId'],
            'name'=> $_POST['name'],
            'email'=> $_POST['email'],
            'password'=> $password,
            'accessLevel'=> $_POST['accessLevel'],
            'userProfilePic' => $_POST['userProfilePic'],
        ];
        $this->userModel->updateUserByAdmin($userUpdatedDetails);
    }

    /**
     * @throws Exception
     */
    public function deleteUserByAdmin() {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $userId = $_POST['userId'];
            if($this->userModel->deleteUserByAdmin($userId)) {
                header('location: ' . 'http://localhost:8000/admin');
            } else {
                throw new Exception('Something went wrong');
            }
        }
        if(isAdmin()) {
            return View::make('Admin/adminUserDelete');
        } else {
            header('location: ' . 'http://localhost:8000');
        }
    }

}