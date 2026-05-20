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

    // ─── HELPER: shared file upload logic ────────────────────────────────────────
    private function _handleFileUploads()
    {
        $files_uploaded = $_FILES['userfile'];
        $fileNames = [];

        if (empty($files_uploaded['name'][0])) {
            return $fileNames;
        }

        $count = count($files_uploaded['name']);
        $this->load->library('upload');

        for ($i = 0; $i < $count; $i++) {
            $_FILES['file']['name'] = $files_uploaded['name'][$i];
            $_FILES['file']['type'] = $files_uploaded['type'][$i];
            $_FILES['file']['tmp_name'] = $files_uploaded['tmp_name'][$i];
            $_FILES['file']['error'] = $files_uploaded['error'][$i];
            $_FILES['file']['size'] = $files_uploaded['size'][$i];

            $config['upload_path'] = './assets/images/ticket_attachments';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|docx|ppt|pptx|zip|rar|pdf';
            $config['encrypt_name'] = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $fileNames[] = [
                    'origName' => $uploadData['orig_name'],
                    'encryptedName' => $uploadData['file_name']
                ];
            } else {
                log_message('error', $this->upload->display_errors());
            }
        }

        return $fileNames;
    }


    // ─── CREATE TICKET ───────────────────────────────────────────────────────────

    public function CrtTickets()
    {
        $this->form_validation->set_rules('ticket_title', 'Title', 'required');
        $this->form_validation->set_rules('ticket_body', 'Description', 'required');
        $this->form_validation->set_rules('departments', 'Category', 'required');

        if ($this->form_validation->run()) {
            $fileNames = $this->_handleFileUploads();
            $result = $this->Tickets_Model->insrtCrtdTicket($fileNames);

            if ($result['status'] === TRUE) {
                $this->session->set_flashdata('success', $result['message']);
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


    // ─── VIEW SINGLE TICKET (view/edit page) ─────────────────────────────────────

    public function Viewtckts($tcktID)
    {
        $data['tckt_details'] = $this->Tickets_Model->getViewTckts($tcktID);
        $data['departments'] = $this->Tickets_Model->getDprtmnts();
        $this->load->view('pages/navbar');
        $this->load->view('pages/view_tickets', $data);
    }


    // ─── UPDATE TICKET ───────────────────────────────────────────────────────────

    public function UpdateTckts($tcktID)
    {
        $this->form_validation->set_rules('ticket_title', 'Title', 'required');
        $this->form_validation->set_rules('ticket_body', 'Description', 'required');
        $this->form_validation->set_rules('departments', 'Category', 'required');
        $this->form_validation->set_rules('priority', 'Priority', 'required');

        if ($this->form_validation->run()) {
            $fileNames = $this->_handleFileUploads();
            $result = $this->Tickets_Model->getUpdateTckts($tcktID, $fileNames);

            if ($result['status'] === TRUE) {
                $this->session->set_flashdata('success', $result['message']);
                redirect('tickets/view/' . $tcktID);
            } else {
                $data['tckt_details'] = $this->Tickets_Model->getViewTckts($tcktID);
                $data['error'] = $result['message'];
                $data['departments'] = $this->Tickets_Model->getDprtmnts();
                $this->load->view('pages/navbar', $data);
                $this->load->view('pages/view_tickets', $data);
            }
        } else {
            $data['tckt_details'] = $this->Tickets_Model->getViewTckts($tcktID);
            $data['departments'] = $this->Tickets_Model->getDprtmnts();
            $this->load->view('pages/navbar');
            $this->load->view('pages/view_tickets', $data);
        }
    }


    // ─── UPDATE STATUS ───────────────────────────────────────────────────────────

    public function updateStatus($status, $id)
    {
        $priority = $this->input->post('modal_priority');

    
        $this->Tickets_Model->updateStatus($status, $id, $priority);
        $this->session->set_flashdata('success', 'Ticket status updated to ' . $status . '.');
        redirect('tickets/details/view/' . $id);
    }

    public function updatePriorityAndStatus($status,$priority, $id){
        $data = [
            'status'   => $status,
            'priority' => $priority,
        ];

        $this->db->where('id', $id);
        $this->db->update('tickets', $data);
         redirect('tickets/details/view/' . $id);
    }

    public function updateStatusReject($id)
    {
        $this->Tickets_Model->updatedStatusReject('Rejected', $id);
        $this->session->set_flashdata('success', 'Ticket has been rejected.');
        redirect('tickets/all');
    }


    // ─── TICKET DETAILS PAGE ─────────────────────────────────────────────────────

    public function returnticketDetails($id)
    {
        $data['tckt_details'] = $this->Tickets_Model->getData_for_ticket_details($id);
        $dept_id = $data['tckt_details']['department_id'];

        $data['departments'] = $this->Tickets_Model->getDprtmnts();
        $data['comments'] = $this->Tickets_Model->get_ticket_comments($id);
        $data['attachments'] = $this->Tickets_Model->get_ticket_attachments($id);
        $data['employees'] = $this->Tickets_Model->getEmployee($dept_id);

        $this->load->view('pages/navbar');
        $this->load->view('pages/ticket_details', $data);
    }

    // ─── AJAX: load employees for modal dropdown ──────────────────────────────────

    public function getEmployees($dept_id)
    {
        $data['employees'] = $this->Tickets_Model->getEmployee($dept_id);
        $this->load->view('pages/navbar');
        $this->load->view('pages/ticket_details', $data);
    }

    public function getEmployeesForModal($dept_id)
    {
        $data = $this->Tickets_Model->getEmployeeForMDL($dept_id);
        echo json_encode($data);
    }


    // ─── POST COMMENT ─────────────────────────────────────────────────────────────

    public function postComment($ticket_id)
    {
        $this->form_validation->set_rules('comment_body', 'Comment', 'required|trim');

        if ($this->form_validation->run()) {
            $result = $this->Tickets_Model->insert_comment($ticket_id);

            if ($result) {
                $this->session->set_flashdata('success', 'Comment posted.');
            } else {
                $this->session->set_flashdata('error', 'Failed to post comment.');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }

        redirect('tickets/details/view/' . $ticket_id);
    }


    // ─── ASSIGN EMPLOYEE (first-time, INSERT into ticket_assigned) ────────────────

    public function assignEmployee($ticket_id)
    {
        $employee_ids = $this->input->post('employeename');

        if (!empty($employee_ids)) {
            $this->Tickets_Model->assignEmployee($ticket_id, $employee_ids);
            $this->session->set_flashdata('success', 'Employee assigned successfully.');
        } else {
            $this->session->set_flashdata('error', 'Please choose an employee.');
        }

        redirect('tickets/details/view/' . $ticket_id);
    }


    // ─── REASSIGN DEPARTMENT (resets ticket back to For Approval, clears assignees) ──

    public function reassignDepartment($ticket_id)
    {
        $department_id = (int) $this->input->post('department');

        // Guard: department_id must be a valid non-zero integer
        if (empty($department_id)) {
            $this->session->set_flashdata('error', 'Please select a valid department.');
            redirect('tickets/details/view/' . $ticket_id);
            return;
        }

        $this->Tickets_Model->reassignDepartment($ticket_id, $department_id);
        $this->session->set_flashdata('success', 'Department re-assigned successfully. Ticket is back for approval.');
        redirect('tickets/details/view/' . $ticket_id);
    }


    // ─── REASSIGN EMPLOYEE ONLY (swap assigned employees, keep department + status) ──

    public function reassignEmployeeOnly($ticket_id)
    {
        $employee_ids  = $this->input->post('employeename');
        $department_id = (int) $this->input->post('department_id');

        if (!empty($employee_ids)) {
            $this->Tickets_Model->reassignEmployeeOnly($ticket_id, $employee_ids, $department_id);
            $this->session->set_flashdata('success', 'Employee re-assigned successfully.');
        } else {
            $this->session->set_flashdata('error', 'Please choose at least one employee.');
        }

        redirect('tickets/details/view/' . $ticket_id);
    }


    // ─── START WORKING → set status to On Going ───────────────────────────────────

    public function strtWrking($tckt_id)
    {
        $result = $this->Tickets_Model->StrtSts($tckt_id);

        if ($result === TRUE) {
            echo json_encode(['result' => $result]);
            return;
        }

        $this->session->set_flashdata('error', 'Something went wrong.');
        redirect('tickets/details/view/' . $tckt_id);
    }

}