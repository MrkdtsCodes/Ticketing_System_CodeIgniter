<?php

/**
 * @property CI_Form_validation $form_validation
 * @property Auth_Model $Auth_Model
 * @property Tickets_Model $Tickets_Model
 * @property CI_Session $session
 */

class Pages extends CI_Controller
{

    //display login page
    public function displaylogin()
    {
        if ($this->session->userdata('is_loggedin')) {
            redirect('create/tickets');
        }
        $this->load->view('pages/login_page');
    }

    //create account page
    public function displayCreateAcc()
    {
        $data['roles'] = $this->Auth_Model->getRoles();
        $this->load->view('pages/create_account', $data);
    }

    //create ticket page
    public function displayCreateTickets()
    {
        if ($this->session->userdata('is_loggedin')) {
            $data['departments'] = $this->Tickets_Model->getDprtmnts();
            $this->load->view('pages/navbar');
            $this->load->view('pages/create_tickets', $data);
        } else {
            $this->session->set_flashdata('error', "You must be logged in to access Different page.");
            redirect('login');
        }
    }

    //dashboard
    public function displayDshbrd()
    {
        if (!$this->session->userdata('is_loggedin')) {
            redirect('login');
        }

        $data['crtdTickets'] = $this->Tickets_Model->getTickets();
        $this->load->view('pages/navbar');
        $this->load->view('pages/dashboard', $data);
    }


    //navigation bar
    public function displayNav()
    {
        $this->load->view('pages/navbar');
    }


    //department dropdown values
    public function dsplyDept()
    {
        $data['departments'] = $this->Tickets_Model->getDprtmnts();
        $this->load->view('pages/create_tickets', $data);
    }

    


    public function diplayTickt()
    {

        if ($this->session->userdata('is_loggedin')) {  
            $this->load->view('pages/navbar');
            $this->load->view('pages/view_tickets');
        } else {
            $this->session->set_flashdata('error', "You must be logged in to access Different page.");
            redirect('login');
        }
    }

    //------------------------------------TABLE PAGES---------------------------------------------------------------------/



    public function displayApprvlPgs(){
         if ($this->session->userdata('is_loggedin')) {  
            $data['crtdTickets'] = $this->Tickets_Model->getForApprovalTickets();
  
            $this->load->view('pages/navbar');
            $this->load->view('pages/approval_page' , $data);
        } else {
            $this->session->set_flashdata('error', "You must be logged in to access Different page.");
            redirect('login');
        }
    }
}
