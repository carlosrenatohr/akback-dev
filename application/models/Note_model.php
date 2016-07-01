<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-30-16
 * Time: 05:20 PM
 */
class Note_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getNotesByType($type, $referenceID)
    {
        $where = ['Type' => $type, 'Status' => 1, 'ReferenceUnique' => $referenceID];
        $this->db->order_by('Unique');
        return $this->db->get_where('notes', $where)->result_array();
    }

    public function postNote($request)
    {
        $values = [
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid'),
            'Status' => 1
        ];
        $toInsert = array_merge($values, $request);
        $this->db->insert('notes', $toInsert);
        return $this->db->insert_id();
    }

    public function updateNote($id, $request) {
        $toUpdate = [
            'Status' => 1,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $toUpdate);
        //
        $this->db->where('Unique', $id);
        $status = $this->db->update('notes', $data);
        return $status;
    }

    public function deleteNote($id)
    {
        $toUpdate = [
            'Status' => 0,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $status = $this->db->update('notes', $toUpdate);
        return $status;
    }

}