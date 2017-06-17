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
            $sql = "
                SELECT config_questions_item.*,
                item.\"Description\", item.\"Item\", item.\"Status\", item.\"price1\" as sprice,
                CASE 
                when config_questions_item.\"PriceLevel\" = '1' then item.price1 when config_questions_item.\"PriceLevel\" = '2' then item.price2
                when config_questions_item.\"PriceLevel\" = '3' then item.price3 when config_questions_item.\"PriceLevel\" = '4' then item.price4
                when config_questions_item.\"PriceLevel\" = '5' then item.price5 when config_questions_item.\"PriceLevel\" = 'M' then item.\"PriceModify\"
                when config_questions_item.\"PriceLevel\" = 'F' then config_questions_item.\"FixedPrice\"
                else item.price1 
                END as \"plPrice\"
                FROM config_questions_item 
                JOIN item ON item.\"Unique\" = config_questions_item.\"ItemUnique\" ".
                (($id != 'null') ?
              ' WHERE config_questions_item."QuestionUnique" = ' . $id :
                " ") .
              " ORDER BY config_questions_item.\"Sort\" ASC, item.\"Description\" ASC "
            ;
            $query = $this->db->query($sql)->result_array();
        } else
            $query = [];
        return $query;
    }

    public function getQuestionPriceByLevel($id = null, $lvl = null) {
        $lvl = (string)$lvl;
        if ($id != null) {
            $select = "
        select price1, price2 , price3, price4, price5, \"PriceModify\", 
        config_questions_item.\"PriceLevel\", config_questions_item.\"FixedPrice\",
        case when \"PriceLevel\" = '1' then price1 when \"PriceLevel\" = '2' then price2
        when \"PriceLevel\" = '3' then price3 when \"PriceLevel\" = '4' then price4
        when \"PriceLevel\" = '5' then price5  when \"PriceLevel\" = 'M' then \"PriceModify\"
        when \"PriceLevel\" = 'F' then \"FixedPrice\" 
        else price1 end as \"Price\"
        from item
        left join config_questions_item 
        on item.\"Unique\" = config_questions_item.\"ItemUnique\"
        where item.\"Unique\" = {$id}
        order by item.\"Unique\" asc
        "; // AND \"PriceLevel\" = '{$lvl}'
        $query = $this->db->query($select)->row_array();
        } else {
            $query = [];
        }
        return $query;
    }

    public function postQuestion($request)
    {
        $request['Status'] = 1;
        $request['Created'] = date('Y-m-d H:i:s');
        $request['CreatedBy'] = $this->session->userdata('userid');

        $status = $this->db->insert($this->question_table, $request);
        $insert_id = $this->db->insert_id();
        return $insert_id;
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