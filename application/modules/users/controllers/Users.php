<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller  {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','security']);
        $this->load->model('users/User_model');
        $this->load->library('users/UserService');

        // check admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_role') !== 'admin') {
            // if AJAX call, return 403
            if ($this->input->is_ajax_request()) {
                show_error('Forbidden', 403);
            }
            redirect('users/auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->User_model->get_user($user_id); 
        $this->load->view('users/templates/header', $data);
        $this->load->view('users/admin/dashboard', $data);
        $this->load->view('users/templates/footer');
    }

    public function list() {
        $user_id = $this->session->userdata('user_id');
        $data['admin'] = $this->User_model->get_user($user_id);
        $this->load->view('users/templates/header', $data);
        $this->load->view('users/admin/users_list', $data);
        $this->load->view('users/templates/footer');
    }

    // DataTables server-side JSON
    public function list_json() {
        $draw = intval($this->input->get('draw'));
        $start = intval($this->input->get('start'));
        $length = intval($this->input->get('length'));
        $order = $this->input->get('order');
        $order_col = isset($order[0]['column']) ? intval($order[0]['column']) : null;
        $order_dir = isset($order[0]['dir']) ? $order[0]['dir'] : 'desc';
        $search = $this->input->get('search')['value'];

        $total = $this->User_model->count_all();
        $filtered = $this->User_model->count_filtered($search);
        $rows = $this->User_model->get_for_datatables($length, $start, $search, $order_col, $order_dir);

        $data = [];
        foreach ($rows as $r) {

            $actions = '<a class="btn btn-sm btn-primary" href="'.site_url('users/users/edit/'.$r->id).'">ویرایش</a> ';
            $actions .= '<a class="btn btn-sm btn-danger" href="'.site_url('users/users/delete/'.$r->id).'" onclick="return confirm(\'حذف شود؟\')">حذف</a>';            
            $data[] = [
                $r->id,
                html_escape($r->name),
                html_escape($r->email),
                html_escape($r->role),
                $actions
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $filtered,
            "data" => $data
        ]);
    }

    public function create() {
        $this->form_validation->set_rules('name', 'نام', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'ایمیل', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'رمز عبور', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'نقش', 'required|in_list[user,admin]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $data = [
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password'),
            'role' => $this->input->post('role') ?: 'user'
        ];
        
        try {
            $result = $this->userservice->createUser($data);
            $this->session->set_userdata('user_added', $data);
            if($result) {
                echo json_encode(['status' => 'success', 'message' => 'کاربر با موفقیت ایجاد شد']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'خطا در ایجاد کاربر']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function edit($id) {
        $user = $this->User_model->get_user($id);
        if (!$user) {
            if($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'کاربر یافت نشد']);
                return;
            }
            show_404();
        }

        // اگر درخواست AJAX باشد و POST نباشد، اطلاعات کاربر را برگردان
        if($this->input->is_ajax_request() && !$this->input->post()){
            log_message('debug', 'AJAX GET request received for user edit: ' . $id);
            echo json_encode(['user' => $user, 'mode' => 'edit']);
            return;
        }

        // اعتبارسنجی
        $this->form_validation->set_rules('name', 'نام', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'ایمیل', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('role', 'نقش', 'required|in_list[user,admin]');
        
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'رمز عبور', 'min_length[6]');
        }


        
        if ($this->form_validation->run() === FALSE) {
            if($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => validation_errors()]);
                return;
            }
            // برای درخواست غیر AJAX
                $this->load->view('users/templates/header');
                $this->load->view('users/admin/dashboard', ['mode' => 'edit', 'user' => $user]);
                $this->load->view('users/templates/footer');
            return;
        }

        $update = [
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'role' => $this->input->post('role') ?: 'user'
        ];
        
        if ($this->input->post('password')) {
            $update['password'] = $this->input->post('password');
        }
        
        $result = $this->userservice->updateUser($id, $update);
        
        if($this->input->is_ajax_request()) {
            if($result) {
                echo json_encode(['status' => 'success', 'message' => 'کاربر با موفقیت به‌روزرسانی شد']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'خطا در به‌روزرسانی کاربر']);
            }
        } else {
            if($result) {
                $this->session->set_flashdata('success', 'کاربر با موفقیت به‌روزرسانی شد');
            } else {
                $this->session->set_flashdata('error', 'خطا در به‌روزرسانی کاربر');
            }
            redirect('users/users');
        }
    }


    public function delete($id) {
        if ($this->session->userdata('user_id') == $id) {
            if($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'نمی‌توانید خود را حذف کنید.']);
                return;
            }
            $this->session->set_flashdata('error', 'نمی‌توانید خود را حذف کنید.');
            redirect('users/users');
        }
        
        $result = $this->userservice->deleteUser($id);
        
        if($this->input->is_ajax_request()) {
            if($result) {
                echo json_encode(['status' => 'success', 'message' => 'کاربر با موفقیت حذف شد']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'خطا در حذف کاربر']);
            }
        } else {
            if($result) {
                $this->session->set_flashdata('success', 'کاربر با موفقیت حذف شد');
            } else {
                $this->session->set_flashdata('error', 'خطا در حذف کاربر');
            }
            redirect('users/users');
        }
    }

}
