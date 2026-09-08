<?php

class Auth_Model extends CI_Model
{
    public function get_many_by($params = array(), $count = false)
    {
        if( ! empty($params['date']))
        {
            $this->db->where('DATE(cs_blog.created)', $params['date']);
        }

        if( ! empty($params['keywords']))
        {
            $fields = ['cs_blog.id', 'cs_blog.title', 'cs_blog.body'];

            $this->db->group_start();

            // specific search (" ")
            if(preg_match('/"([^"]+)"/', $params['keywords'], $m))
            {
                $params['keywords'] = $m[1];
                foreach($fields as $key => $field)
                {
                    if($key) $this->db->or_where($field, $params['keywords']);
                    else $this->db->where($field, $params['keywords']);
                }
            }
            else
            {
                foreach($fields as $key => $field)
                {
                    if($key) $this->db->or_like($field, $params['keywords']);
                    else $this->db->like($field, $params['keywords']);
                }
            }
            $this->db->group_end();
            
        }

        $last_update = 'COALESCE(cs_blog.updated, cs_blog.created)';
        
        $this->db->select('cs_blog.*, category.name as category_name, CONCAT(uc.first_name, " ", uc.last_name) as created_name');
        $this->db->select($last_update .' as `last_updated`, COALESCE(uu.name, uc.name) as `last_updated_by`', false);
        $this->db->select('cs_files.width as thumb_width');
        $this->db->select("
                            IF(prop.main_residential_type = 'lot', 'Lot Only',
                                IF(prop.construction_type_id IN (431,430), 'Ground-up', 'Renovation')
                            ) as property_type_label
                        ", false);
        
        $this->db->join('cs_blog_categories as category', 'category.id = cs_blog.category_id', 'left');
        $this->db->join('cs_files', 'cs_files.id = cs_blog.thumb', 'left');
        
        $this->db->join('cs_users as uc', 'uc.id = cs_blog.created_by', 'left');
        $this->db->join('cs_users as uu', 'uu.id = cs_blog.updated_by', 'left');
        
        $this->db->where('cs_blog.deleted', null);
        
        if( ! $count)
        {
            $this->db->order_by('cs_blog.created', 'DESC');
            
            $result = $this->db->get_where('cs_blog')->result();
            
            return $result;
        }
        else
        {
            
            return $this->db->count_all_results('cs_blog');
        }
    }

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
