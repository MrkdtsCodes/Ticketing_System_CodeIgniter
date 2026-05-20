<?php
/**
 * @property CI_Form_validation $form_validation
 * @property Auth_Model $Auth_Model
 * @property CI_input $input
 * @property Tickets_Model $Tickets_Model
 *  @property CI_Session $session
 */

class AuthProcess extends CI_Controller
{


    public function VerifyUsr()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');


        if ($this->form_validation->run()) {
            $username = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Auth_Model->verifyAdmin($username, $password);


            if ($user){

                $this->session->set_flashdata('Loggedin', "Welcome $username");
                //create an userdata for session that we can access throughout pages
                $user_data = [
                    'user_id' => $user->account_id,
                    'lastname' => $user->lastname,
                    'firstname' => $user->firstname,
                    'middlename' => $user->middlename,
                    'role_name' => $user->role_name,
                    'is_loggedin' => true
                ];

                $this->session->set_userdata($user_data);
                
                redirect('tickets/dashboard');
                //create session
            } else {
                $this->session->set_flashdata('error', 'Email and Password did not match');
                redirect('login');
            }
        } else {
            $this->load->view('pages/login_page');
        }
    }

    public function Insrtdata()
    {

        $this->form_validation->set_rules('lname', 'Lastname', 'required');
        $this->form_validation->set_rules('fname', 'Firstname', 'required');
        $this->form_validation->set_rules('mname', 'Middlename', 'required');
        $this->form_validation->set_rules('bday', 'BirthDate', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('role', 'Roles Category', 'required');



        if ($this->form_validation->run()) { //if tama lahat go pero kung hindi redirect
            $is_saved = $this->Auth_Model->InsrtEmply();

            if ($is_saved) {
                echo "Pasok";
            } else {
                echo "hindi pumasok";
            }
        } else {
            $data['roles'] = $this->Auth_Model->getRoles();
            $this->load->view('pages/create_account', $data);
        }
    }

    public function createUser(){
        // $this->form_validation->set_rules('inputname', 'Name you want in your message', 'rules to follow')

        $this->form_validation->set_rules('lastname', 'Lastname', 'required');
        $this->form_validation->set_rules('firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('middlename', 'Middlename', 'required');
        $this->form_validation->set_rules('birthdate', 'BirthDate', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('role', 'Roles Category', 'required');
        $this->form_validation->set_rules('department', 'Department', 'required');

        if ($this->form_validation->run() === TRUE) { //if tama lahat go pero kung hindi redirect
            $is_saved = $this->Auth_Model->_insrtUsr();

            if ($is_saved) {
                echo "Pasok";
            } else {
                echo "hindi pumasok";
            }
        } else {
            $data['roles'] = $this->Auth_Model->getRoles();
            $data['departments'] = $this->Tickets_Model->getDprtmnts();
            $data['accounts'] = $this->Auth_Model->getAccountsWithDetails();
            $this->load->view('pages/navbar');
            $this->load->view('pages/accountTable', $data);
        }
    }

    public function accounts(){
        $data['accounts'] = $this->Auth_Model->getAccountsWithDetails();
        $this->load->view('pages/accountTable', $data);
        }

    public function updateUsr($acc_id){

        $is_saved = $this->Auth_Model->_updateUsr($acc_id);

        if($is_saved){

            echo json_encode([
                'status' => 'success',
                'message' => 'User updated successfully',
                "accounts" => []
            ]);

        }else{

            echo json_encode([
                'status' => 'error'
            ]);

        }

    }

    //status active or deactivated account

    public function updtdStatus($id){

        $updated = $this->Auth_Model->deactivateUsr($id);

        echo json_encode([
              'message' => $updated
        ]);
    }


    public function LogOut()
    {
        //logging out
        $this->session->sess_destroy();

        //redirect to login page
        redirect('login');
    }
}