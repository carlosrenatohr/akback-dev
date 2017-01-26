<?php

class ItemCount extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Item_count_model', 'count');
    }

    public function load_itemcount($status)
    {
        $result = $this->count->mainList($status);
        echo json_encode($result);
    }

    public function load_allitemcountlist($id)
    {
        $result = $this->count->getLists($id);
        echo json_encode($result);
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
                    'id' => $id,
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

    public function massDeleteItemCountList() {
        if (isset($_POST)  && !empty($_POST)) {
            $ids = $_POST['ids'];
            $status = true;
            if (!empty($ids))
                $status = $this->count->delete_count_list($ids);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count item list item deleted!',
                ];
            } else {
                $response = $this->dbErrorMsg();
            }
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

    public function setZeroCount($id) {
        $status = $this->count->setZero_NotCounted_list($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Set successfully!',
                'data' => $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }

        echo json_encode($response);
    }

    /**
     * ITEM COUNT SCAN
     */
    public function load_itemcountscan($status = '') {
        $result = $this->count->itemCountScan($status);
        echo json_encode($result);
    }

    public function load_itemcountscanlist($id) {
        $result = $this->count->itemCountScanList($id);
        echo json_encode($result);
    }

    public function createItemScan() {
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $this->getSettingLocation('DecimalsQuantity', $this->session->userdata("station_number"));
            $id = $this->count->createScan($data);
            if ($id) {
                $response = [
                    'status' => 'success',
                    'message' => 'Item  Scan created successfully',
                    'id' => $id,
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function updateItemScan($id) {
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $status = $this->count->updateScan($id, $data);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Item Scan updated successfully',
                    'id' => $status
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function deleteItemScan($id) {
        if (isset($_POST)) {
                    $status = $this->count->deleteScan($id);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Scan deleted!',
                ];
            } else {
                $response = $this->dbErrorMsg();
            }
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function itemMatchScan($id) {
        if (isset($_POST)) {
            $status = $this->count->itemMatchScan($id);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Item Scan updated successfully.',
                    'id' => $status
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function updateItemScanList($id) {
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $status = $this->count->update_scan_list($id, $data);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Scan list updated successfully',
                    'id' => $status
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function massDeleteItemScanList() {
        if (isset($_POST)  && !empty($_POST)) {
            $ids = $_POST['ids'];
            $status = true;
            if (!empty($ids))
                $status = $this->count->delete_scan_list($ids);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Scan list item deleted!',
                ];
            } else {
                $response = $this->dbErrorMsg();
            }
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    // UPLOAD FILES
    public function upload() {
        $target_dir = "./assets/csv/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir);
        }
        $imageFileType = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
        $name = explode('.', basename($_FILES["file"]["name"]));
        $target_name =  $name[0] . '_' . time() . ".{$imageFileType}";
        $target_file = $target_dir . $target_name;
        $uploadOk = 1;
        // Current file exists
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // File size validation
        $maxSize = (500)*(1000); // 5Mb
        if ($_FILES["file"]["size"] > $maxSize) {
            $msg = "File is too large. Maximum 5Mb to upload.";
            $uploadOk = 0;
        }
        // File format validation
        if($imageFileType != "csv") {
            $msg = "Sorry, only CSV files are accepted.";
            $uploadOk = 0;
        }
        // Was there an error?
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $msg = "The file ". $target_name. " has been uploaded.";
            } else {
                $msg = "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
            }
        }

        echo json_encode([
            'success' => ($uploadOk == 1) ? true : false,
            'message' => $msg,
            'path' => $target_file,
            'name' => $target_name,
            'original_name' => basename($_FILES["file"]["name"])
        ]);
    }

}