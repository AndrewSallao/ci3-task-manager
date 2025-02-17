<?php

    class User_model extends CI_Model {

        public function register($data) {
            return $this->db->insert('users', $data);
        }

        public function get_user($email) {
            return $this->db->get_where('users', ['email' => $email])->row_array();
        }

        public function check_login($email, $password) {
            $user = $this->db->get_where('users', ['email' => $email])->row_array();
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        }

    }
