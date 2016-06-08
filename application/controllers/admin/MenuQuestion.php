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
        foreach($result as $row) {
            $row['Sort'] = $row['sort'];
            $return[] = $row;
        }
        echo json_encode($return);
    }

    public function load_questions_items($id) {
        $result = $this->question->getQuestionItemData($id);
        $return = [];
        foreach($result as $row) {
            $row['Sort'] = $row['sort'];
            $return[] = $row;
        }
        echo json_encode($return);
    }

    public function postQuestion() {
        $post = $_POST;
        $status = $this->question->postQuestion($post);
        echo json_encode([
            'status' => 'success',
            'message' => $status
        ]);
    }

    public function updateQuestion($id) {
        $post = $_POST;
        $status = $this->question->updateQuestion($id, $post);
        echo json_encode([
            'status' => 'success',
            'message' => $status
        ]);
    }

    public function deleteQuestion($id) {
        $status = $this->question->deleteQuestion($id);
        echo json_encode([
            'status' => 'success',
            'message' => $status
        ]);
    }

}