<?php

/**
 * @property CI_form_validation $form_validation
 * @property Auth_Model $Auth_Model
 * @property CI_upload $upload
 * @property CI_input $input
 * @property CI_db $db
 * @property Tickets_Model $Tickets_Model
 * @property CI_session $session
 */

class Tickets extends CI_Controller
{

    // Create ticket
    public function CrtTickets()
    {
        $this->form_validation->set_rules('ticket_title', 'Title', 'required');
        $this->form_validation->set_rules('ticket_body', 'Description', 'required');
        $this->form_validation->set_rules('departments', 'Category', 'required');
        $this->form_validation->set_rules('priority', 'Priority', 'required');

        if ($this->form_validation->run()) {

            $files_uploaded = $_FILES['userfile'];
            $fileNames = [];

            if (!empty($files_uploaded['name'][0])) {

                $count = count($files_uploaded['name']);
                $this->load->library('upload');

                for ($i = 0; $i < $count; $i++) {

                    $_FILES['file']['name']     = $files_uploaded['name'][$i];
                    $_FILES['file']['type']     = $files_uploaded['type'][$i];
                    $_FILES['file']['tmp_name'] = $files_uploaded['tmp_name'][$i];
                    $_FILES['file']['error']    = $files_uploaded['error'][$i];
                    $_FILES['file']['size']     = $files_uploaded['size'][$i];

                    $config['upload_path']   = './assets/images/ticket_attachments';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|docx|ppt|pptx|zip|rar|pdf';
                    $config['encrypt_name']  = TRUE;

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $uploadData = $this->upload->data();
                        $fileNames[] = [
                            'origName'      => $uploadData['orig_name'],
                            'encryptedName' => $uploadData['file_name']
                        ];
                    } else {
                        log_message('error', $this->upload->display_errors());
                    }
                }
            }

            $result = $this->Tickets_Model->insrtCrtdTicket($fileNames);

            if ($result['status'] === TRUE) {
                $this->session->set_flashdata('success', $result['message']);
                redirect('tickets/send');
            } else {
                $data['error']       = $result['message'];
                $data['departments'] = $this->Tickets_Model->getDprtmnts();
                $this->load->view('pages/navbar', $data);
                $this->load->view('pages/create_tickets', $data);
            }

        } else {
            $data['departments'] = $this->Tickets_Model->getDprtmnts();
            $this->load->view('pages/navbar');
            $this->load->view('pages/create_tickets', $data);
        }
    }


    // View single ticket via route
    public function Viewtckts($tcktID)
    {
        $data['tckt_details'] = $this->Tickets_Model->getViewTckts($tcktID);
        $data['departments']  = $this->Tickets_Model->getDprtmnts();
        $this->load->view('pages/navbar');
        $this->load->view('pages/view_tickets', $data);
    }


    public function UpdateTckts($tcktID)
    {
        $this->form_validation->set_rules('ticket_title', 'Title', 'required');
        $this->form_validation->set_rules('ticket_body', 'Description', 'required');
        $this->form_validation->set_rules('departments', 'Category', 'required');
        $this->form_validation->set_rules('priority', 'Priority', 'required');

        if ($this->form_validation->run()) {                                        
                                                                                    
            $files_uploaded = $_FILES['userfile'];                                  
            $fileNames = [];                                                        
                                                                                    
            if (!empty($files_uploaded['name'][0])) {                               
                $count = count($files_uploaded['name']);                             
                $this->load->library('upload');                                     
                                                                                    
                for ($i = 0; $i < $count; $i++) {                                  
                    $_FILES['file']['name']     = $files_uploaded['name'][$i];      
                    $_FILES['file']['type']     = $files_uploaded['type'][$i];      
                    $_FILES['file']['tmp_name'] = $files_uploaded['tmp_name'][$i];  
                    $_FILES['file']['error']    = $files_uploaded['error'][$i];     
                    $_FILES['file']['size']     = $files_uploaded['size'][$i];      
                                                                                    
                    $config['upload_path']   = './assets/images/ticket_attachments';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|docx|ppt|pptx|zip|rar|pdf';
                    $config['encrypt_name']  = TRUE;                                
                                                                                    
                    $this->upload->initialize($config);                             
                                                                                    
                    if ($this->upload->do_upload('file')) {                         
                        $uploadData = $this->upload->data();                        
                        $fileNames[] = [                                            
                            'origName'      => $uploadData['orig_name'],            
                            'encryptedName' => $uploadData['file_name']             
                        ];                                                          
                    } else {                                                        
                        log_message('error', $this->upload->display_errors());      
                    }                                                               
                }                                                                   
            }                                                                       
                                                                                    
            $result = $this->Tickets_Model->getUpdateTckts($tcktID, $fileNames);   
                                                                                    
            if ($result['status'] === TRUE) {                                       
                // SUCCESS: redirect to the route so Viewtckts() loads data properly
                $this->session->set_flashdata('success', $result['message']);       
                redirect('tickets/view/' . $tcktID);                               
                                                                                    
            } else {                                                                
                // Model error: reload view with ticket data + error message        
                $data['tckt_details'] = $this->Tickets_Model->getViewTckts($tcktID);
                $data['error']        = $result['message'];                         
                $data['departments']  = $this->Tickets_Model->getDprtmnts();        
                $this->load->view('pages/navbar', $data);                           
                $this->load->view('pages/view_tickets', $data);                     
            }                                                                       
                                                                          
        } else {                                                                   
            // Validation failed: reload view with ticket data so form re-renders    validation failed
            $data['tckt_details'] = $this->Tickets_Model->getViewTckts($tcktID);   
            $data['departments']  = $this->Tickets_Model->getDprtmnts();            
            $this->load->view('pages/navbar');                                      
            $this->load->view('pages/view_tickets', $data);                         
        }                                                                           
    }
}