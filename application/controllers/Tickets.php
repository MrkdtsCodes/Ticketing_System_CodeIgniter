<?php

/**
 * @property form_validation $form_validation
 * @property Auth_Model $Auth_Model
 *  @property upload $upload
 * @property input $input
 * @property db $db
 * @property Tickets_Model $Tickets_Model
 * @property session $session
 */

class Tickets extends CI_Controller
{

    //create tickets
    public function CrtTickets()
    {
        // validation
        $this->form_validation->set_rules('ticket_title', 'Title', 'required');
        $this->form_validation->set_rules('ticket_body', 'Description', 'required');
        $this->form_validation->set_rules('departments', 'Category', 'required');
        $this->form_validation->set_rules('priority', 'Priority', 'required');


        //if lahat may pumasa sa validation try to 
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
                        // optional: log instead of echo
                        log_message('error', $this->upload->display_errors());
                    }
                }
            }

            // send to model
            $result = $this->Tickets_Model->insrtCrtdTicket($fileNames);

            if ($result['status'] === TRUE) {
                $this->session->set_flashdata('success', $result['message']); // e.g. "Ticket created! Code: TCK-00001"
                redirect('tickets/send');
            } else {
                $data['error'] = $result['message'];
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
}
