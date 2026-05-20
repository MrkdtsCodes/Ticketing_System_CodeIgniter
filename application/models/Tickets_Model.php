<?php

class Tickets_Model extends CI_Model
{

    // ─── PRIVATE: LOG TICKET HISTORY ─────────────────────────────────────────────
    // Call this after every change to the tickets table.
    // It only inserts if the value actually changed.

    private function _logHistory($ticket_id, $field, $old_value, $new_value)
    {
        // skip if nothing actually changed
        if ((string)$old_value === (string)$new_value) return;

        $data = [
            'ticket_id'     => $ticket_id,
            'field_changed' => $field,
            'old_value'     => $old_value,
            'new_value'     => $new_value,
            'changed_by'    => $this->session->userdata('user_id'),
        ];

        $this->db->insert('tickets_history', $data);
    }


    // ─── PRIVATE: GET OLD TICKET VALUES (read before write) ──────────────────────

    private function _getOldTicket($ticket_id)
    {
        return $this->db
            ->where('id', $ticket_id)
            ->get('tickets')
            ->row_array();
    }


    // ─── BASE QUERY ──────────────────────────────────────────────────────────────

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
            ticket_assigned.date_assigned,
            ticket_assigned.date_update,
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


    // ─── DEPARTMENTS ─────────────────────────────────────────────────────────────

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

        // ── LOG: ticket created ──
        $this->_logHistory($ticket_id, 'status', NULL, 'For Approval');

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
        // ── read OLD values before update ──
        $old = $this->_getOldTicket($tcktID);

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

        // ── LOG: what changed ──
        $this->_logHistory($tcktID, 'status',        $old['status'],        $this->input->post('status'));
        $this->_logHistory($tcktID, 'priority',      $old['priority'],      $this->input->post('priority'));
        $this->_logHistory($tcktID, 'department_id', $old['department_id'], $this->input->post('departments'));

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


    // ─── UPDATE STATUS (approve with priority) ────────────────────────────────────

    public function updateStatus($status, $id, $priority)
    {
        // ── read OLD values before update ──
        $old = $this->_getOldTicket($id);

        $data = [
            'priority' => $priority,
            'status'   => $status,
        ];

        $this->db->where('id', $id);
        $this->db->update('tickets', $data);

        // ── LOG: status and priority changed ──
        $this->_logHistory($id, 'status',   $old['status'],   $status);
        $this->_logHistory($id, 'priority', $old['priority'], $priority);
    }


    // ─── UPDATE STATUS: REJECT ────────────────────────────────────────────────────

    public function updatedStatusReject($status, $id)
    {
        // ── read OLD values before update ──
        $old = $this->_getOldTicket($id);

        $data = [
            'status'   => $status,
            'priority' => null,
        ];

        $this->db->where('id', $id);
        $this->db->update('tickets', $data);

        // ── LOG: status changed to rejected ──
        $this->_logHistory($id, 'status', $old['status'], $status);
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


    // ─── GET EMPLOYEES ────────────────────────────────────────────────────────────

    public function getEmployee($dept_id)
    {
        $this->db->select("
            account.id AS account_id,
            CONCAT(employee_details.firstname, ' ', employee_details.lastname) AS employee_fullname,
            department.dept_name,
            department.id,
            employee_details.id AS employee_id
        ", FALSE);

        $this->db->from('account');
        $this->db->join('employee_details', 'account.emp_id = employee_details.id', 'left');
        $this->db->join('department', 'account.dept_id = department.id', 'left');
        $this->db->where('account.dept_id', $dept_id);
        return $this->db->get()->result_array();
    }

    public function getEmployeeForMDL($dept_id)
    {
        $this->db->select("
            account.id AS account_id,
            CONCAT(employee_details.firstname, ' ', employee_details.lastname) AS employee_fullname,
            department.dept_name,
            department.id,
            employee_details.id AS employee_id
        ", FALSE);

        $this->db->from('account');
        $this->db->join('employee_details', 'account.emp_id = employee_details.id', 'left');
        $this->db->join('department', 'account.dept_id = department.id', 'left');
        $this->db->where('account.dept_id', $dept_id);
        return $this->db->get()->result_array();
    }


    // ─── ASSIGN EMPLOYEE (first-time INSERT) ─────────────────────────────────────

    public function assignEmployee($ticket_id, $employee_ids)
    {
        // ── read OLD values before update ──
        $old = $this->_getOldTicket($ticket_id);

        $this->db->trans_start();

        $author_id = $this->session->userdata('user_id');

        foreach ($employee_ids as $empID) {
            $data = [
                'ticket_id'   => $ticket_id,
                'assigned_by' => $author_id,
                'assigned_to' => $empID,
            ];
            $this->db->insert('ticket_assigned', $data);
        }

        $this->db->where('id', $ticket_id);
        $this->db->update('tickets', ['status' => 'assigned']);

        // ── LOG: status changed + employees assigned ──
        $this->_logHistory($ticket_id, 'status',   $old['status'], 'assigned');
        $this->_logHistory($ticket_id, 'assignee', 'Unassigned',   implode(', ', $employee_ids));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }


    // ─── REASSIGN DEPARTMENT ──────────────────────────────────────────────────────

    public function reassignDepartment($ticket_id, $department_id)
    {
        // ── read OLD values before update ──
        $old = $this->_getOldTicket($ticket_id);

        $this->db->trans_start();

        $data = [
            'department_id' => $department_id,
            'priority'      => NULL,
            'status'        => 'For Approval',
        ];

        $this->db->where('id', $ticket_id);
        $this->db->update('tickets', $data);

        $this->db->where('ticket_id', $ticket_id);
        $this->db->delete('ticket_assigned');

        // ── LOG: department and status changed ──
        $this->_logHistory($ticket_id, 'department_id', $old['department_id'], $department_id);
        $this->_logHistory($ticket_id, 'status',        $old['status'],        'For Approval');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }


    // ─── REASSIGN EMPLOYEE ONLY ───────────────────────────────────────────────────

    public function reassignEmployeeOnly($ticket_id, $employee_ids, $department_id)
    {
        $author_id = $this->session->userdata('user_id');

        $this->db->trans_start();

        $this->db->where('ticket_id', $ticket_id);
        $this->db->delete('ticket_assigned');

        foreach ($employee_ids as $empID) {
            $data = [
                'ticket_id'   => $ticket_id,
                'assigned_by' => $author_id,
                'assigned_to' => $empID,
            ];
            $this->db->insert('ticket_assigned', $data);
        }

        $this->db->where('id', $ticket_id);
        $this->db->update('tickets', ['status' => 'Assigned']);

        // ── LOG: assignee swapped ──
        $this->_logHistory($ticket_id, 'assignee', 'Previous assignee(s)', implode(', ', $employee_ids));

        $this->db->trans_complete();

        return $this->db->trans_status();
    }


    // ─── START WORKING → On Going ────────────────────────────────────────────────

    public function StrtSts($tckt_id)
    {
        // ── read OLD values before update ──
        $old = $this->_getOldTicket($tckt_id);

        $data = ['status' => 'On Going'];

        $this->db->where('id', $tckt_id);
        $result = $this->db->update('tickets', $data);

        // ── LOG: status changed to On Going ──
        $this->_logHistory($tckt_id, 'status', $old['status'], 'On Going');

        return $result;
    }


    // ─── GET TICKET HISTORY (for modal) ──────────────────────────────────────────

    public function getTicketHistory($ticket_id)
    {
        $this->db->select("
            tickets_history.field_changed,
            tickets_history.old_value,
            tickets_history.new_value,
            tickets_history.changed_at,
            CONCAT(emp.firstname, ' ', emp.lastname) AS changed_by_name
        ", FALSE);

        $this->db->from('tickets_history');
        $this->db->join('account',                'tickets_history.changed_by = account.id',  'left');
        $this->db->join('employee_details emp',   'account.emp_id = emp.id',                  'left');
        $this->db->where('tickets_history.ticket_id', $ticket_id);
        $this->db->order_by('tickets_history.changed_at', 'DESC');

        return $this->db->get()->result_array();
    }

}