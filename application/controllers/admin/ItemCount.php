<?php

class ItemCount extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_count_model', 'count');
    }

    public function load_allitemcount()
    {
        $result = $this->count->getLists();
        echo json_encode($result);
    }

    public function createCount() {
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $id = $this->count->create($data);
            if ($id) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count created successfully',
                    'id' => $id
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }


}