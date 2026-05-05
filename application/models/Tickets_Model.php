<?php

class Tickets_Model extends CI_Model
{

    private function _baseTicketQuery(){
         $this->db->select("
            tickets.id,
            CONCAT('TCK-', LPAD(tickets.id, 5, '0')) AS ticket_code,
            tickets.title,
            tickets.body,
            tickets.department_id,
            tickets.priority,
            tickets.status,
            dept.dept_name,
            tickets.created_at,
            tickets.updated_at,
            DATEDIFF(NOW(), tickets.created_at) AS Ticket_Age,
            CONCAT(author_details.firstname, ' ', author_details.lastname) AS author_fullname,
            CONCAT(pic_details.firstname, ' ', pic_details.lastname) AS pic_fullname
        ", FALSE);

        $this->db->from('tickets');
        $this->db->join('account AS author_account', 'tickets.author_id = author_account.id', 'left');
        $this->db->join('employee_details AS author_details', 'author_account.emp_id = author_details.id', 'left');
        $this->db->join('account AS pic_account', 'tickets.assignee_id = pic_account.id', 'left');
        $this->db->join('employee_details AS pic_details', 'pic_account.emp_id = pic_details.id', 'left');
        $this->db->join('department AS dept', 'tickets.department_id = dept.id');

    }
    // Get departments from the database
    public function getDprtmnts()
    {
        $query = $this->db->get('department');
        return $query->result_array();
    }




    public function insrtCrtdTicket($filename)
    {
        $author_id = $this->session->userdata('user_id');

        $this->db->trans_start();

        $data = [
            'author_id'     => $author_id,
            'department_id' => $this->input->post('departments'),
            'title'         => $this->input->post('ticket_title'),
            'body'          => $this->input->post('ticket_body'),
            'status'        => 'For Approval',
        ];

        // FIX #2: Removed the unused "$insert =" assignment.
        // The return value of db->insert() is a boolean and was
        // never being used anywhere, so storing it was pointless.
        $this->db->insert('tickets', $data);

        $ticket_id = $this->db->insert_id();

        if (!empty($filename)) {
            foreach ($filename as $file) {
                $attachment = [
                    'ticket_id'   => $ticket_id,
                    'file_name'   => $file['origName'],
                    'file_path'   => 'assets/images/ticket_attachments/' . $file['encryptedName'],
                    'file_type'   => pathinfo($file['origName'], PATHINFO_EXTENSION),
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // FIX #3: Actually insert the attachment into the database.
                // Before this fix, $attachment was built but never saved —
                // so uploaded files were stored on disk but had no DB record.
                $this->db->insert('ticket_attachments', $attachment);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => FALSE, 'message' => "We couldn't create your ticket. Please review your details and try again."];
        }

        $ticket_code = 'TCK-' . str_pad($ticket_id, 5, '0', STR_PAD_LEFT);
        return ['status' => TRUE, 'message' => 'Ticket created! Code: ' . $ticket_code];
    }


    public function getTickets()
    {
        $this->_baseTicketQuery();

        $query = $this->db->get();
        return $query->result_array();
    }


    public function getViewTckts($tcktID)
    {
     
       $this->_baseTicketQuery();

        return $this->db->get()->row();
    }


    public function getUpdateTckts($tcktID, $fileNames)
    {
        $this->db->trans_start();

        $data = [
            'department_id' => $this->input->post('departments'),
            'title'         => $this->input->post('ticket_title'),
            'body'          => $this->input->post('ticket_body'),
            'priority'      => $this->input->post('priority'),
            'status'        => $this->input->post('status')
        ];

        $this->db->where('id', $tcktID);
        $this->db->update('tickets', $data);

        // This was already correct — attachment insert was present here.
        if (!empty($fileNames)) {
            foreach ($fileNames as $file) {
                $attachment = [
                    'ticket_id'   => $tcktID,
                    'file_name'   => $file['origName'],
                    'file_path'   => 'assets/images/ticket_attachments/' . $file['encryptedName'],
                    'file_type'   => pathinfo($file['origName'], PATHINFO_EXTENSION),
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('ticket_attachments', $attachment);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => FALSE, 'message' => "We couldn't update your ticket. Please review your details and try again."];
        }

        $ticket_code = 'TCK-' . str_pad($tcktID, 5, '0', STR_PAD_LEFT);
        return ['status' => TRUE, 'message' => 'Ticket Updated! Code: ' . $ticket_code];
    }


    //approval page
      public function getForApprovalTickets()
    {
        $this->_baseTicketQuery();

        // Only this line is different from getTickets()
        $this->db->where('tickets.status', 'For Approval');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function updatedStatus($status, $id)
    {   

        $sendstatus = [
            'status' => $status
        ];
        
        $this->db->where('id', $id);
        $this->db->update('tickets', $sendstatus);
    }

    public function updatedStatusReject($status, $id)
    {   
        
        $sendstatus = [
            
            'status' => $status
        ];
        
        $this->db->where('id', $id);
        $this->db->update('tickets', $sendstatus);
    }
        



}