<?php

class Tickets_Model extends CI_Model
{

    private function _baseTicketQuery()
{
    $this->db->select("
        tickets.id,
        CONCAT('TCK-', LPAD(tickets.id, 5, '0')) AS ticket_code,
        tickets.department_id,
        tickets.title,
        tickets.body,
        tickets.priority,
        tickets.status,
        tickets.created_at,
        tickets.updated_at,
        department.dept_name,
        DATEDIFF(NOW(), tickets.created_at) AS Ticket_Age,
        TIMEDIFF(NOW(), tickets.created_at) AS Ticket_time,
        CONCAT(author_details.firstname, ' ', author_details.lastname) AS author_fullname,
        GROUP_CONCAT(assignee_details.firstname, ' ', assignee_details.lastname SEPARATOR ', ') AS assigned_employees
    ", FALSE);

    $this->db->from('tickets');

    // Author chain
    $this->db->join('account AS author_account', 'tickets.author_id = author_account.id', 'left');
    $this->db->join('employee_details AS author_details', 'author_account.emp_id = author_details.id', 'left');

    // Assignee chain
    $this->db->join('ticket_assigned', 'tickets.id = ticket_assigned.ticket_id', 'left');
    $this->db->join('account AS assignee_account', 'ticket_assigned.assigned_to = assignee_account.id', 'left');
    $this->db->join('employee_details AS assignee_details', 'assignee_account.emp_id = assignee_details.id', 'left');

    // Department
    $this->db->join('department', 'tickets.department_id = department.id', 'left');
    $this->db->group_by('tickets.id');
}


    // ─── DEPARTMENTS ────────────────────────────────────────────────────────────

    public function getDprtmnts()
    {
        return $this->db->get('department')->result_array();
    }


    // ─── CREATE TICKET ───────────────────────────────────────────────────────────

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


    // ─── GET ALL TICKETS ─────────────────────────────────────────────────────────

    public function getTickets()
    {
        $this->_baseTicketQuery();
        return $this->db->get()->result_array();
    }


    // ─── GET SINGLE TICKET (view/edit page) ──────────────────────────────────────

    public function getViewTckts($tcktID)
    {
        $this->_baseTicketQuery();
        $this->db->where('tickets.id', $tcktID);
        return $this->db->get()->row_array();
    }


    // ─── GET TICKET DETAILS (detail page) ────────────────────────────────────────

    public function getData_for_ticket_details($id)
    {
        $this->_baseTicketQuery();
        $this->db->where('tickets.id', $id);
        return $this->db->get()->row_array();
    }


    // ─── UPDATE TICKET ───────────────────────────────────────────────────────────

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
        return ['status' => TRUE, 'message' => 'Ticket updated! Code: ' . $ticket_code];
    }


    // ─── FOR APPROVAL TICKETS ────────────────────────────────────────────────────

    public function getForApprovalTickets()
    {
        $this->_baseTicketQuery();
        $this->db->where('tickets.status', 'For Approval');
        return $this->db->get()->result_array();
    }


    // ─── UPDATE STATUS ───────────────────────────────────────────────────────────

    public function updateStatus($status, $id, $priority)
    {   
         $data = [
            'priority' => $priority,
            'status' => $status,
        ];

        
        $this->db->where('id', $id);
        $this->db->update('tickets', $data);
    }

    public function updatedStatusReject($status, $id, $priority)
    {   
         $data = [
            
            'status' => $status,
            'priority' => $priority,
        ];

        $this->db->where('id', $id);
        $this->db->update('tickets', $data);
        // $this->db->update('tickets', ['status' => $status]);
    }


    // ─── COMMENTS ────────────────────────────────────────────────────────────────

    public function get_ticket_comments($ticket_id)
    {
        $this->db->select("
            comment.id,
            comment.comment_body,
            comment.comment_at,
            CONCAT(commenter_emp.firstname, ' ', commenter_emp.lastname) AS commenter_fullname
        ", FALSE);

        $this->db->from('comment');
        $this->db->join('account AS commenter_acc', 'comment.comment_author_id = commenter_acc.id', 'left');
        $this->db->join('employee_details AS commenter_emp', 'commenter_acc.emp_id = commenter_emp.id', 'left');
        $this->db->where('comment.ticket_id', $ticket_id);
        $this->db->order_by('comment.comment_at', 'ASC');

        return $this->db->get()->result_array();
    }

    public function insert_comment($ticket_id)
    {
        $data = [
            'ticket_id'         => $ticket_id,
            'comment_author_id' => $this->session->userdata('user_id'),
            'comment_body'      => $this->input->post('comment_body'),
            'comment_at'        => date('Y-m-d H:i:s')
        ];

        $this->db->insert('comment', $data);
        return $this->db->affected_rows() > 0;
    }


    // ─── ATTACHMENTS ─────────────────────────────────────────────────────────────

    public function get_ticket_attachments($ticket_id)
    {
        $this->db->select('id, file_name, file_path, file_type, uploaded_at');
        $this->db->from('ticket_attachments');
        $this->db->where('ticket_id', $ticket_id);
        $this->db->order_by('uploaded_at', 'DESC');

        return $this->db->get()->result_array();
    }

        // ─── get employee ─────────────────────────────────────────────────────────────

    public function getEmployee($dept_id)
    {
        $this->db->select("
        account.id As account_id,
        CONCAT(employee_details.firstname, ' ' ,employee_details.lastname) AS employee_fullname,
        department.dept_name,
        department.id,
        employee_details.id AS employee_id
        ",
        FALSE);

        $this->db->from('account');
        $this->db->join('employee_details', 'account.emp_id = employee_details.id', 'left');
        $this->db->join('department', 'account.dept_id = department.id', 'left');
        $this->db->where('account.dept_id', $dept_id);
        return $this->db->get()->result_array();
    }


    public function getEmployeeForMDL($dept_id){

        $this->db->select("
        account.id As account_id,
        CONCAT(employee_details.firstname, ' ' ,employee_details.lastname) AS employee_fullname,
        department.dept_name,
        department.id,
        employee_details.id AS employee_id
        ",
        FALSE);

        $this->db->from('account');
        $this->db->join('employee_details', 'account.emp_id = employee_details.id', 'left');
        $this->db->join('department', 'account.dept_id = department.id', 'left');
        $this->db->where('account.dept_id', $dept_id);
        return $this->db->get()->result_array();
    }

    // ─── ASSIGN EMPLOYEE (INSERT) ─────────────────────────────────────────────────
    public function assignEmployee($ticket_id, $employee_id)
    {

        $author_id = $this->session->userdata('user_id');

        foreach($employee_id as $empID){
            $data = [
                'ticket_id'   => $ticket_id,
                'assigned_by' =>  $author_id, 
                'assigned_to' => $empID,
            ];

            $this->db->insert('ticket_assigned', $data);
        }
        
    }

    // ─── REASSIGN EMPLOYEE (UPDATE) ───────────────────────────────────────────────
    public function reassignEmployee($ticket_id, $departmentID)
    {
        // $data = ['assigned_to' => $employee_id];
        // $this->db->where('ticket_id', $ticket_id);
        // $this->db->update('ticket_assigned', $data);


        $this->db->trans_start();

         $data = [
           "department_id" => $departmentID,
           'priority' => null ,
           'status' => "For Approval "
        ];

        $this->db->where('id', $ticket_id);
        $this->db->update('tickets', $data);


        $this->db->where('ticket_id', $ticket_id);
        $this->db->delete('ticket_assigned');

        $this->db->trans_complete();
       
    }



} 