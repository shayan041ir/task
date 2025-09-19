<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'users';
    protected $columns = ['id','name','email','birth_date','role','created_at'];

    public function insert_user($data) {
        return $this->db->insert($this->table, $data);
    }

    public function get_user($id) {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row();
    }

    public function get_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    public function get_by_name($name) {
        return $this->db->get_where($this->table, ['name' => $name])->row();
    }

    public function get_all() {
        return $this->db->select($this->columns)->get($this->table)->result();
    }

    public function update_user($id, $data) {
        return $this->db->where('id', (int)$id)->update($this->table, $data);
    }

    public function delete_user($id) {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    /* --- DataTables server-side helpers --- */
    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function count_filtered($search) {
        $this->build_datatables_query($search);
        return $this->db->get()->num_rows();
    }

    private function build_datatables_query($search = null, $order_col = null, $order_dir = null) {
        $this->db->select($this->columns)->from($this->table);
        if (!empty($search)) {
            $this->db->group_start()
                ->like('name', $search)
                ->or_like('email', $search)
                ->group_end();
        }
        if ($order_col !== null && isset($this->columns[$order_col])) {
            $this->db->order_by($this->columns[$order_col], $order_dir === 'asc' ? 'ASC' : 'DESC');
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function get_for_datatables($limit, $offset, $search = null, $order_col = null, $order_dir = null) {
        $this->build_datatables_query($search, $order_col, $order_dir);
        if ($limit !== -1) {
            $this->db->limit((int)$limit, (int)$offset);
        }
        return $this->db->get()->result();
    }
}
