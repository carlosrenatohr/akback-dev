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
        return $this->db->get_where('notes', $where)->result_array();
    }

}