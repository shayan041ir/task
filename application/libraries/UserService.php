<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserService {
    protected $CI;
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('User_model');
    }

    public function createUser(array $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        return $this->CI->User_model->insert_user($data);
    }

    public function updateUser($id, array $data) {
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        } elseif (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        return $this->CI->User_model->update_user($id, $data);
    }

    public function deleteUser($id) {
        return $this->CI->User_model->delete_user($id);
    }

    public function getById($id) {
        return $this->CI->User_model->get_user($id);
    }
}
