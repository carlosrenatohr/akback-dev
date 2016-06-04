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

    public function postQuestion() {
        $post = $_POST;
        $status = $this->question->postQuestion($post);
        echo json_encode([
            'status' => 'success',
            'message' => $status
        ]);

    }

}