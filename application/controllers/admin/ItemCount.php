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

}