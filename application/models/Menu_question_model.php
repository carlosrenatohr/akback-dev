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
//        $this->db->order_by('QuestionName', 'ASC');
        $this->db->order_by('Created DESC');
        $query = $this->db->get_where($this->question_table, ['Status!=' => 0]);
        return $query->result_array();
    }

    public function getQuestionItemData($id = null) {
        if (!is_null($id)) {
            $this->db->select(
                "{$this->question_items_table}.*,
                item.Description, item.Item, item.Status, item.price1 as sprice");
            if ($id != 'null') {
                $this->db->where("{$this->question_items_table}.QuestionUnique", $id);
            }
            $this->db->join('item', "item.Unique = {$this->question_items_table}.ItemUnique");
            $this->db->order_by("Sort", 'ASC');
            $query = $this->db->get($this->question_items_table)->result_array();
        } else
            $query = [];
        return $query;
    }

    public function postQuestion($request)
    {
        $request['Status'] = 1;
        $request['Created'] = date('Y-m-d H:i:s');
        $request['CreatedBy'] = $this->session->userdata('userid');

        $status = $this->db->insert($this->question_table, $request);
        $insert_id = $this->db->insert_id();
        return $status;
    }

    public function postQuestionItem($request)
    {
        $request['Status'] = 1;
        $request['Created'] = date('Y-m-d H:i:s');
        $request['CreatedBy'] = $this->session->userdata('userid');

        $status = $this->db->insert($this->question_items_table, $request);
        $insert_id = $this->db->insert_id();
        return $status;
    }

    public function updateQuestion($id, $request)
    {
        $request['Updated'] = date('Y-m-d H:i:s');
        $request['UpdatedBy'] = $this->session->userdata('userid');

        $this->db->where('Unique', $id);
        $query = $this->db->update($this->question_table, $request);
        return $query;
    }

    public function updateQuestionItem($id, $request)
    {
        $request['Updated'] = date('Y-m-d H:i:s');
        $request['UpdatedBy'] = $this->session->userdata('userid');

        $this->db->where('Unique', $id);
        $query = $this->db->update($this->question_items_table, $request);
        return $query;
    }

    public function deleteQuestion($id) {
        $deletingValues = [
            'Status' => 0,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $query = $this->db->update($this->question_table, $deletingValues);
        return $query;
    }

    public function deleteQuestionItem($id) {
        $this->db->where('Unique', $id);
        $query = $this->db->delete($this->question_items_table);
        return $query;
    }

}