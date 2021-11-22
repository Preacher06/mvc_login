<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function getAllUsers() {
            $this->db->query('SELECT * FROM users');
            $users = $this->db->resultSet();
            return $users;
        }

        public function findUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE user_email = :email');
            $this->db->bind(':email', $email);
            $this->db->execute();
            
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function register($data) {
            $this->db->query('INSERT INTO users (user_name, user_email, password) VALUES (:username, :email, :password)');
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            
            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function login($username, $password) {
            $this->db->query('SELECT * FROM users WHERE user_name = :username');
            $this->db->bind(':username', $username);
            $user = $this->db->single();

            $hashedPassword = $user->password;
            if(password_verify($password, $hashedPassword)) {
                return $user;
            } else {
                return false;
            }
        }
    }
?>