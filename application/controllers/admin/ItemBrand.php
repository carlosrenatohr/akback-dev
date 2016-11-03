<?php

class ItemBrand extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_brand_model', 'brand');
    }

    public function load_allbrands()
    {
        $result = $this->brand->getLists();
        echo json_encode($result);
    }

    public function postBrand()
    {
        $post = $_POST;
        $status = $this->brand->postBrand($post);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Brand created successfully',
                'id' => $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }

        echo json_encode($response);
    }

    public function updateBrand($id)
    {
        $post = $_POST;
        $status = $this->brand->updateBrand($id, $post);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }

        echo json_encode($response);
    }

    public function deleteBrand($id)
    {
        $status = $this->brand->deleteBrand($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }

        echo json_encode($response);
    }

}