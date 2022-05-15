<?php
namespace App\Controllers;

use App\Models\Model;
use App\Models\User;
use App\Views\View;
use Throwable;

class UserController extends Model {

    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
        parent::__construct();
    }

    /**
     * @throws Throwable
     */
    public function register() {


        if($_SERVER['REQUEST_METHOD'] == 'POST') {


            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_error'=> '',
                'email_error'=>'',
                'password_error'=>'',
                'confirm_password_error'=>''
            ];

            if(empty($data['email'])) {
                $data['email_error'] = 'Please Enter email';
            }

            if(empty($data['name'])) {
                $data['name_error'] = 'Please Enter name';
            }
            if(empty($data['password'])) {
                $data['password_error'] = 'Please Enter password';
            }

            if(empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please confirm Password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = "Password do not match";
                }
            }


            try {
                $this->db->beginTransaction();

                $userId = $this->userModel->create($data['name'], $data['email'], $data['password']);

                $this->db->commit();
            } catch (Throwable $e) {
                if($this->db->inTransaction()) {
                    $this->db->rollBack();
                }
                throw $e;
            }

//            if(empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
//                die('Success');
//            }

            return View::make('message', ['userInfo'=>$this->userModel->find($userId)]);

        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_error'=> '',
                'email_error'=>'',
                'password_error'=>'',
                'confirm_password_error'=>''
            ];

            $this->view('users/register', $data);
        }




    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

        } else {
            $data = [
                'email'=>'',
                'password'=>'',
                'email_err'=>'',
                'password_err'=>''
            ];

            $this->view('users/login', $data);
        }
    }


}