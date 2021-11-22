<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

class Pages extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function index() {
            $users = $this->userModel->getAllUsers();
            $data = [
                'users' => $users,
            ];
            return $this->view('pages/index', $data);
        }

        public function about() {
            return $this->view('pages/about');
        }
    }
?>