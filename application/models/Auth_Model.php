<?php

class Auth_Model extends CI_Model
{

    public function verifyAdmin($username, $password)
    {
        // 1. SELECT: Sabihin natin kung ano lang ang kukunin natin para walang conflict sa ID
        // Kukunin natin ang ID at password ng account, tapos lahat ng info sa employee_details
        $this->db->select('account.id as account_id, account.password, employee_details.*');


        $this->db->join('employee_details', 'employee_details.id = account.emp_id', 'left');

        $this->db->where('account.email', $username);

        $query = $this->db->get('account');

        if ($query->num_rows() == 1) {
            $user = $query->row();


            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return False;
    }



    public function InsrtEmply()
    {
        $this->db->trans_start();

        $data = [
            'lastname' => $this->input->post('lname'),
            'firstname' => $this->input->post('fname'),
            'middlename' => $this->input->post('mname'),
            'birthdate' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),

        ];


        $this->db->insert('employee_details', $data);
        //Get inserted employee ID
        $emp = $this->db->insert_id();


        $data_accs = [
            'emp_id' => $emp,
            'role_id' => $this->input->post('roles'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        ];
        $this->db->insert('account', $data_accs);

        return $this->db->trans_complete(); //returns true or false

    }


    public function getRoles()
    {
        $this->db->order_by('role_name');
        $query = $this->db->get('role');
        return $query->result_array();
    }
}
