<?php
    class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function register() {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirmPassword' => trim($_POST['confirmPassword']),
                    'usernameError' => '',
                    'emailError' => '',
                    'passwordError' => '',
                    'confirmPasswordError' => '',
                ];

                $nameValidation = '/^[a-zA-Z\d]+$/';
                $passwordValidation = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';

                if(empty($data['username'])) {
                    $data['usernameError'] = 'Sorry, Username can not be empty.';
                } else if(!preg_match($nameValidation, $data['username'])) {
                    $data['usernameError'] = 'Sorry, Username can contain only alphanumeric characters.';
                }

                if(empty($data['email'])) {
                    $data['emailError'] = 'Sorry, Email can not be empty.';
                } else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['emailError'] = 'Sorry, Email is of incorrect format.';
                } else {
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['emailError'] = 'Sorry, an account with specifed email already exists.';
                    }
                }

                if(empty($data['password'])) {
                    $data['passwordError'] = 'Sorry, Password can not be empty.';
                } else if(strlen($data['password']) < 8) {
                    $data['passwordError'] = 'Sorry, Password has to be atleast 8 characters.';
                } else if(!preg_match($passwordValidation, $data['password'])) {
                    $data['passwordError'] = 'Sorry, Password should contain atleast one numeric character.';
                }

                if(empty($data['confirmPassword'])) {
                    $data['confirmPasswordError'] = 'Sorry, Password can not be empty.';
                } else if($data['password'] != $data['confirmPassword']) {
                    $data['confirmPasswordError'] = 'Sorry, Passwords do not match.';
                }

                if(empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    if($this->userModel->register($data)) {
                        header('Location: ' . URLROOT . '/users/login');
                    } else {
                        die('Sorry, something went wrong.');
                    }
                }  
            } else {
                $data = [
                    'username' => '',
                    'email' => '',
                    'password' => '',
                    'confirmPassword' => '',
                    'usernameError' => '',
                    'emailError' => '',
                    'passwordError' => '',
                    'confirmPasswordError' => '',
                ]; 
            }
            return $this->view('users/register', $data);
        }

        public function login() {
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => '',
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'usernameError' => '',
                    'passwordError' => '',
                ];

                if(empty($data['username'])) {
                    $data['usernameError'] = 'Sorry, Username can not be empty.';
                }

                if(empty($data['password'])) {
                    $data['passwordError'] = 'Sorry, Password can not be empty.';
                }

                if(empty($data['usernameError']) && empty($data['passwordError'])) {
                    $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                    if($loggedInUser) {
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['passwordError'] = 'Sorry, either Username or Password is incorrect.';
                    }
                }  
            } else {
                $data = [
                    'username' => '',
                    'password' => '',
                    'usernameError' => '',
                    'passwordError' => '',
                ];
            }
            return $this->view('users/login', $data);
        }

        private function createUserSession($user) {
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['username'] = $user->user_name;
            $_SESSION['email'] = $user->user_email;
            header('Location: ' . URLROOT . '/pages/index');
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            header('Location: ' . URLROOT . '/uses/login');
        }
    }
?>