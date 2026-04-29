<?php

class Tickets_Model extends CI_Model
{
    //get departments in the database
    public function getDprtmnts()
    {
        $query = $this->db->get('department');
        return $query->result_array();
    }

    //insert Created ticket
    public function insrtCrtdTicket($filename)
    {
        
        $author_id = $this->session->userdata('user_id');

        $this->db->trans_start();

        $data = [
            'author_id'     => $author_id,
            'department_id' => $this->input->post('departments'),
            'title'         => $this->input->post('ticket_title'),
            'body'          => $this->input->post('ticket_body'),
            'priority'      => $this->input->post('priority'),
            'status'        => 'For Approval',
        ];
        

        
       $insert = $this->db->insert('tickets', $data);
        
        $ticket_id = $this->db->insert_id();

        // no more ticket_code insert needed

        if (!empty($filename)) {
            foreach ($filename as $file) {
                $attachment = [
                    'ticket_id'   => $ticket_id,
                    'file_name'   => $file['origName'],
                    'file_path'   => 'assets/images/ticket_attachments/' . $file['encryptedName'],
                    'file_type'   => pathinfo($file['origName'], PATHINFO_EXTENSION),
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];
            
                
            }
        }

        $this->db->trans_complete();

        
        // $mark = false;
        //  if ($mark === FALSE) {
        if ($this->db->trans_status() === FALSE) {
            return ['status' => FALSE, 'message' => "We couldn’t create your ticket. Please review your details and try again"];
        } else {
            $ticket_code = 'TCK-' . str_pad($ticket_id, 5, '0', STR_PAD_LEFT);
            return ['status' => TRUE, 'message' => 'Ticket created! Code: ' . $ticket_code];
        }

        
    }

    public function getTickets()
    {
        $this->db->select("
        CONCAT('TCK-', LPAD(tickets.id, 5, '0')) AS ticket_code,
        tickets.title,
        tickets.priority,
        tickets.status,
        tickets.created_at,
        tickets.updated_at,
        CONCAT(author_details.firstname, ' ', author_details.lastname) AS author_fullname,
        CONCAT(pic_details.firstname, ' ', pic_details.lastname) AS pic_fullname
    ", FALSE);

        $this->db->from('tickets');

        $this->db->join('account AS author_account', 'tickets.author_id = author_account.id', 'left');
        $this->db->join('employee_details AS author_details', 'author_account.emp_id = author_details.id', 'left');
        $this->db->join('account AS pic_account', 'tickets.assignee_id = pic_account.id', 'left');
        $this->db->join('employee_details AS pic_details', 'pic_account.emp_id = pic_details.id', 'left');

        $query = $this->db->get();
        return $query->result_array();
    }
}
