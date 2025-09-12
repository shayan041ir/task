<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','security']);
        $this->load->model('User_model');
        $this->load->library('UserService');

        // check admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('user_role') !== 'admin') {
            // if AJAX call, return 403
            if ($this->input->is_ajax_request()) {
                show_error('Forbidden', 403);
            }
            redirect('login');
        }
    }

    public function index() {
        $this->load->view('templates/header');
        $this->load->view('admin/users_list');
        $this->load->view('templates/footer');
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
            $actions = '<a class="btn btn-sm btn-primary" href="'.site_url('admin/users/edit/'.$r->id).'">ویرایش</a> ';
            $actions .= '<a class="btn btn-sm btn-danger" href="'.site_url('admin/users/delete/'.$r->id).'" onclick="return confirm(\'حذف شود؟\')">حذف</a>';
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
    $data = [
        'name' => $this->input->post('name', true),
        'email' => $this->input->post('email', true),
        'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
        'role' => $this->input->post('role') ?: 'user'
    ];
    $this->userservice->createUser($data);
    echo json_encode(['status'=>'success']);
}

public function edit($id) {
    $user = $this->User_model->get_user($id);
    if (!$user) show_404();

    if($this->input->is_ajax_request() && $this->input->method() === 'get'){
        echo json_encode($user);
        return;
    }

    $update = [
        'name' => $this->input->post('name', true),
        'email' => $this->input->post('email', true),
        'role' => $this->input->post('role') ?: 'user'
    ];
    if ($this->input->post('password'))  password_hash($update['password'] = $this->input->post('password'), PASSWORD_BCRYPT);
    $this->userservice->updateUser($id, $update);

    if($this->input->is_ajax_request()) {
        echo json_encode(['status'=>'success']);
    } else {
        redirect('admin/users');
    }
}

    public function delete($id) {
        if ($this->session->userdata('user_id') == $id) {
            $this->session->set_flashdata('error', 'نمی‌توانید خود را حذف کنید.');
            redirect('admin/users');
        }
        $this->userservice->deleteUser($id);
        redirect('admin/users');
    }
}
