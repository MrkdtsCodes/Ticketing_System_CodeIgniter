<?php

/**
 * @property form_validation $form_validation
 * @property Auth_Model $Auth_Model
 * @property Tickets_Model $Tickets_Model
 * @property session $session
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

    public function displayCreateAcc()
    {
        $data['roles'] = $this->Auth_Model->getRoles();
        $this->load->view('pages/create_account', $data);
    }

    public function displayNav()
    {
        $this->load->view('pages/navbar');
    }

    public function displayCreateTickets()
    {
        if ($this->session->userdata('is_loggedin')) {
            $data['departments'] = $this->Tickets_Model->getDprtmnts();
            $this->load->view('pages/create_tickets', $data);
        } else {
            $this->session->set_flashdata('error', "You must be logged in to access this page.");
            redirect('login');
        }
    }

    public function dsplyDept()
    {
        $data['departments'] = $this->Tickets_Model->getDprtmnts();
        $this->load->view('pages/create_tickets', $data);
    }
}
