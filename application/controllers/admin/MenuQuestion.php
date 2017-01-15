<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-03-16
 * Time: 01:40 PM
 */
class MenuQuestion extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_question_model', 'question');
    }

    public function load_allquestions()
    {
        $result = $this->question->getAllQuestions();
        $return = [];
        foreach ($result as $row) {
//            $row['Sort'] = $row['sort'];
            $bpc = explode('#', $row['ButtonPrimaryColor']);
            $row['ButtonPrimaryColor'] = (!is_null($row['ButtonPrimaryColor'])) ? $bpc[1] : null;
            $bpc = explode('#', $row['ButtonSecondaryColor']);
            $row['ButtonSecondaryColor'] = (!is_null($row['ButtonPrimaryColor'])) ? $bpc[1]: null;
            $bpc = explode('#', $row['LabelFontColor']);
            $row['LabelFontColor'] = (!is_null($row['LabelFontColor'])) ? $bpc[1]: null;
            $return[] = $row;
        }
        echo json_encode($return);
    }

    public function load_questions_items($id)
    {
        $result = $this->question->getQuestionItemData($id);
        $return = [];
        foreach ($result as $row) {
            $row['sprice'] = number_format($row['sprice'], (int)$this->session->userdata("DecimalsPrice"));
//            $row['Sort'] = $row['sort'];
            $return[] = $row;
        }
        echo json_encode($return);
    }

    public function postQuestion()
    {
        $post = $_POST;
        $status = $this->question->postQuestion($post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function updateQuestion($id)
    {
        $post = $_POST;
        $status = $this->question->updateQuestion($id, $post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function update_question_item($id)
    {
        $post = $_POST;
        $status = $this->question->updateQuestionItem($id, $post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function deleteQuestion($id)
    {
        $status = $this->question->deleteQuestion($id);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function post_question_item()
    {
        $post = $_POST;
        $status = $this->question->postQuestionItem($post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function delete_question_item($id)
    {
        $status = $this->question->deleteQuestionItem($id);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

}