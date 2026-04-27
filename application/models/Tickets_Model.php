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

        $this->db->insert('tickets', $data);
        $ticket_id = $this->db->insert_id();


        $ticket_code = 'TCK-' . str_pad($ticket_id, 4, '0', STR_PAD_LEFT);


        $this->db->where('id', $ticket_id);
        $this->db->update('tickets', ['ticket_code' => $ticket_code]);


        foreach ($filename as $file) {
            $attachment = [
                'ticket_id'   => $ticket_id,
                'file_name'   => $file['origName'],
                'file_path'   => 'assets/images/ticket_attachments/' . $file['encryptedName'],
                'file_type'   => pathinfo($file['origName'], PATHINFO_EXTENSION),
                'uploaded_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('ticket_attachments', $attachment);
        }

        $this->db->trans_complete();

        // 5. Return result
        if ($this->db->trans_status() === FALSE) {
            return ['status' => FALSE, 'message' => 'Upload Failed!'];
        } else {
            return ['status' => TRUE, 'message' => 'Ticket created! Code: ' . $ticket_code];
        }
    }
}
