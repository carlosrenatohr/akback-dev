<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-03-16
 * Time: 02:05 PM
 */
class Menu_question_model extends CI_Model
{
    private $question_table = 'config_questions';
    private $question_items_table = 'config_questions_item';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllQuestions()
    {
        $query = $this->db->get_where($this->question_table, ['Status!=' => 0]);
        return $query->result_array();
    }

    public function postQuestion($request)
    {
        $request['Status'] = 1;
        $status = $this->db->insert($this->question_table, $request);
        $insert_id = $this->db->insert_id();
        return $status;
    }

}