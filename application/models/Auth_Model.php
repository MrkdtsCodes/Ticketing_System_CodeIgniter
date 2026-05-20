<?php

class Auth_Model extends CI_Model
{

    public function verifyAdmin($username, $password)
    {
        // // 1. SELECT: get natin kung ano lang ang kukunin natin para walang conflict sa ID
        // // Kukunin natin ang ID at password ng account, tapos lahat ng info sa employee_details
        // $this->db->select('account.id as account_id, account.password, employee_details.*');


        // $this->db->join('employee_details', 'employee_details.id = account.emp_id', 'left');

        // $this->db->where('account.email', $username);

        // $query = $this->db->get('account');

        // if ($query->num_rows() == 1) {
        //     $user = $query->row();


        //     if (password_verify($password, $user->password)) {
        //         return $user;
        //     }
        // }

        // return False;
        $this->db->select("
        	account.id AS account_id,
            account.email,
            account.password,
            role.role_name,
            employee_details.firstname,
            employee_details.lastname,
            employee_details.middlename
        ", false);

        $this->db->FROM('account');
        $this->db->JOIN('role', 'account.role_id = role.id', 'left');
        $this->db->JOIN('employee_details', 'account.emp_id = employee_details.id', 'left');
        $this->db->WHERE('account.email' , $username);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
             $user = $query->row();
             if (password_verify($password, $user->password)) {
                    return $user;
             }
        }
        return false;


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

        public function _insrtUsr(){
                
        $this->db->trans_start();

        $empDetails = [

            'lastname' => $this->input->post('lastname'),
            'firstname' => $this->input->post('firstname'),
            'middlename' => $this->input->post('middlename'),
            'birthdate' => $this->input->post('birthdate'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),

           
        ];

        $this->db->insert('employee_details', $empDetails);
        $emp_id = $this->db->insert_id();

        $accountDetails = [

            'emp_id' => $emp_id,
            'role_id' => $this->input->post('role'),
            'dept_id' => $this->input->post('department'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'status' => "active"
        ];


        $this->db->insert('account', $accountDetails);

        return $this->db->trans_complete(); //returns true or false



    }

    public function getAccountsWithDetails()
    {
        $this->db->select("
        	ac.id,
            CONCAT(emp.firstname,' ',emp.lastname) AS fullname,
            emp.firstname,
            emp.lastname,
            emp.middlename,
            emp.birthdate,
            emp.address,
            emp.zipcode,
            ac.email,
            ac.emp_id,
            ac.role_id,
            ac.dept_id,
            ac.status,
            dept.dept_name,
            r.role_name,
            ac.created_at
        ", FALSE);

          $this->db->from('account ac');
          $this->db->join('employee_details  emp', 'ac.emp_id = emp.id', 'left');
          $this->db->join('department  dept', 'ac.dept_id = dept.id', 'left');
          $this->db->join('role  r', 'ac.role_id = r.id', 'left');
        
        $query = $this->db->get();   

        return $query->result_array(); // true or false lang lagi ang laman nito 
    }

    public function _updateUsr($acc_id){

        $this->db->trans_start();

        // get account first
        $account = $this->db
            ->where('id', $acc_id)
            ->get('account')
            ->row_array();

        $emp_id = $account['emp_id'];

        // employee table
        $empDetails = [

            'lastname' => $this->input->post('lastname'),
            'firstname' => $this->input->post('firstname'),
            'middlename' => $this->input->post('middlename'),
            'birthdate' => $this->input->post('birthdate'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),

        ];

        $this->db->where('id', $emp_id);
        $this->db->update('employee_details', $empDetails);

        // account table
        $accountDetails = [

            'role_id' => $this->input->post('role'),
            'dept_id' => $this->input->post('department'),
            'email' => $this->input->post('email'),

        ];

        $this->db->where('id', $acc_id);
        $this->db->update('account', $accountDetails);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function deactivateUsr($id)
    {
        $account = $this->db
            ->where('id', $id)
            ->get('account')
            ->row_array();

        if (!$account) {
            return "not found";
        }

        // safer comparison
        if (trim(strtolower($account['status'])) === 'inactive') {
            return "inactive";
        }

        $deactAcc = [
            'status' => 'inactive'
        ];

        $this->db->where('id', $id);

        $is_updated = $this->db->update('account', $deactAcc);

        if ($is_updated) {
            return "success";
        } else {
            return "failed";
        }
    }
        
        
        

    
}
