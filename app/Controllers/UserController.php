<?php

namespace App\Controllers;

use App\Exceptions\AdminSearchUserException;
use App\Exceptions\EmptyEmailPasswordException;
use App\Exceptions\LoginException;
use App\Exceptions\RegisterEmptyFieldsExceptions;
use App\Exceptions\RegisterPasswordShouldBeSameException;
use App\Models\Model;
use App\Models\User;
use App\Views\View;
use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class UserController extends Model
{
    /** @var User
     * Creating a userModel
     */
    protected User $userModel;

    #[Pure] public function __construct()
    {
        $this->userModel = new User();
        parent::__construct();
    }

    /**
     * @throws Throwable
     * It registers the user
     */
    public function register()
    {
        /** making sure that the request is post */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**
             * Preparing the data by using global $_POST variable
             */
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => hash('sha512', trim($_POST['password'])),
                'userProfilePic' => trim($_POST['userProfilePic'])
            ];

            /**
             * Catching RegisterEmptyFieldsExceptions which is thrown when user submits the empty signup form
             */
            try {
                if (empty($data['name']) || empty($data['password'] || empty($data['email']))) {
                    throw new RegisterEmptyFieldsExceptions("Name or Email or Password cannot be empty");
                } else {
                    /** Catching Exception thrown when the password and repeat password aren't same */
                    try {
                        if ($data['password'] == hash('sha512', trim($_POST['repeat_password']))) {
                            /** Throws the PDO Exception when something is wrong with the database
                             * If the transaction isn't complete then it rolls back to the initial point
                             */
                            try {
                                $this->db->beginTransaction();

                                $userId = $this->userModel->create($data['name'], $data['email'], $data['password'], $data['userProfilePic']);
                                $user = $this->userModel->find($userId);
                                /** Users can be added by admin too
                                 * Making sure if the session doesn't already exists any kinds of user
                                 */
                                if ($_SESSION == null || !isAdmin()) {
                                    $this->startUserSession($user);
                                }
                                /** commiting the changes if everything goes well */
                                $this->db->commit();
                                if (isAdmin()) {
                                    $_SESSION['message'] = 'User has been added';
                                    header('location: ' . 'http://localhost:8000/admin');
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
                /**
                 * Passing Error to the respective error page to show to the users
                 */
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
            $data = [
                'email' => trim($_POST['email']),
                'password' => hash('sha512', trim($_POST['password'])),// Encrypting the password
            ];
            //Catching the EmptyEmailPasswordException caused as a result of user submission with empty email or password or both
            try {
                if (empty($data['email']) || empty($data['password'])) {
                    throw new EmptyEmailPasswordException("Email or password cannot be null");
                } else {
                    // Catching the LoginException which is thrown when the user don't exits in database
                    try {
                        if ($this->userModel->findUserByEmail($data['email'])) {
                            //catching the PasswordIncorrectException
                            try {
                                $userFetched = $this->userModel->checkPassword($data['email'], $data['password']);
                                if (!empty($userFetched)) {
                                    $this->startUserSession($userFetched);
                                    header('location: ' . 'http://localhost:8000/posts');
                                }
                            } catch (Exception $e) {
                                $params = [
                                    'error' => $e->getMessage()
                                ];
                                echo View::make('exceptionsViews/passwordIncorrectError', $params);
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

    // Starts the user session
    public function startUserSession($user)
    {
        $_SESSION['user'] = $user;
    }

    // called when logout button is pressed on UI
    public function logout()
    {
        //Setting the $_SESSION variable to null
        $_SESSION = null;
        //Destroys the session from the browser
        session_destroy();
        //Directing towards the login page when the user logs out
        header('location: ' . 'http://localhost:8000/login');
    }

    /**
     * Checks whether the user is admin or not before letting user access the Admin Page
     * @throws Exception
     */
    public function admin(): View
    {
        if ($_SESSION != null) {
            if (isAdmin()) {
                return View::make('Admin/admin');
            } else {
                // throws this exception if the user is not an admin
                throw new Exception("You are not an admin");
            }
        } else {
            // throws this exception if no one is logged in and is trying to access the admin page
            throw new Exception("You are not logged in");
        }
    }

    /**
     * This function is called when the admin search the user using the search bar present in admin page
     * @throws Exception
     */
    public function adminPost()
    {
        try {
            $user = $this->userModel->getSearchedUser($_POST['search']);
            return View::make("Admin/admin", $user);
        } catch (AdminSearchUserException $e) {
            $params = [
                'error' => $e->getMessage()
            ];
            echo View::make('exceptionsViews/adminusersearchError', $params);
        }
    }

    /** Called when user submit the user with the update */
    public function updateUserByAdmin()
    {
        if ($_POST['password'] != 'PASSWORD') {
            $password = $_POST['password'];
        } else {
            $password = hash('sha512', trim($_POST['password']));
        }
        $userUpdatedDetails = [
            'userId' => $_POST['userId'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $password,
            'accessLevel' => $_POST['accessLevel'],
            'userProfilePic' => $_POST['userProfilePic'],
        ];
        $this->userModel->updateUserByAdmin($userUpdatedDetails);
    }

    /**
     * Deletes the user on Admin request
     * @throws Exception
     */
    public function deleteUserByAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_POST['userId'];
            if ($this->userModel->deleteUserByAdmin($userId)) {
                header('location: ' . 'http://localhost:8000/admin');
            } else {
                throw new Exception('Something went wrong');
            }
        }
        if (isAdmin()) {
            return View::make('Admin/adminUserDelete');
        } else {
            header('location: ' . 'http://localhost:8000');
        }
    }

}