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
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function updateBrand($id)
    {
        $post = $_POST;
        $status = $this->brand->updateBrand($id, $post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function update_Brand_item($id)
    {
        $post = $_POST;
        $status = $this->brand->updateBrandItem($id, $post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function deleteBrand($id)
    {
        $status = $this->brand->deleteBrand($id);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function post_Brand_item()
    {
        $post = $_POST;
        $status = $this->brand->postBrandItem($post);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

    public function delete_Brand_item($id)
    {
        $status = $this->brand->deleteBrandItem($id);
        echo json_encode(
            [
                'status' => 'success',
                'message' => $status
            ]
        );
    }

}