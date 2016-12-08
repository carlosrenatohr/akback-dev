<?php

class ItemCount extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_count_model', 'count');
    }

    public function load_itemcount()
    {
        $result = $this->count->mainList();
        echo json_encode($result);
    }

    public function load_allitemcountlist($id)
    {
        $station = $this->session->userdata("station_number");
        $this->getSettingLocation('DecimalsCost', $station);
        $this->getSettingLocation('DecimalsQuantity', $station);
        $dcost = $this->session->userdata('admin_DecimalsCost');
        $dqty = $this->session->userdata('admin_DecimalsQuantity');
//        var_dump($dcost);
//        var_dump($dqty);

        $result = $this->count->getLists($id);
        $nresult = [];
        foreach ($result as $row) {
            $row['Cost'] = number_format($row['Cost'], $dcost);
            $row['AdjustedCost'] = number_format($row['AdjustedCost'], $dcost);
            $row['NewCost'] = number_format($row['NewCost'], $dcost);
            $row['CurrentStock'] = number_format($row['CurrentStock'], $dqty);
            $row['CountStock'] = number_format($row['CountStock'], $dqty);
            $row['Difference'] = number_format($row['Difference'], $dqty);
            $nresult[] = $row;
        }

        echo json_encode($nresult);
    }

    public function createCount() {
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $data['CountDate'] = date('Y-m-d H:i:s', strtotime($data['CountDate']));
            $filters = null;
            if (isset($data['filters'])) {
                $filters = $data['filters'];
                unset($data['filters']);
            }
            $id = $this->count->create($data, $filters);
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

    public function updateCount($id) {
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $data['CountDate'] = date('Y-m-d H:i:s', strtotime($data['CountDate']));
            $status = $this->count->update($id, $data);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count updated successfully',
                    'id' => $status
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function deleteCount($id) {
        $status = $this->count->delete($id);
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

    public function create_countlistById($countID, $location) {
        if (isset($countID) && isset($location)) {
            $status = $this->count->insert_count_list($countID, $location);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count List Built',
                    'id' => $status
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function update_countlistById($id) {
        if (isset($id) && isset($_POST) && !empty($_POST)) {
            $status = $this->count->update_count_list($id, $_POST);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count List row updated'
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function finalizeCount($id) {
        $status = $this->count->finalize_count_list($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Count list was finalized'
            ];
        } else {
            $response = $this->dbErrorMsg();
        }

        echo json_encode($response);
    }


}