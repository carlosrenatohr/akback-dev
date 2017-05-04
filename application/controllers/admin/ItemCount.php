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
            // Scan filenames, empty is any was uploaded
            $filename = $data['filename'];
            unset($data['filename']);
            //
            $ids = $this->count->create($data, $filters, $filename);
            if ($ids['countID']) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count created successfully',
                    'id' => $ids['countID'],
                    'scanID' => $ids['scanID']
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
            // Scan filenames, empty is any was uploaded
            if (isset($data['filename'])) {
                $filename = $data['filename'];
                unset($data['filename']);
            } else {
                $filename = null;
            }
            $ids = $this->count->update($id, $data, $filename);
            if ($ids['status']) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count updated successfully',
                    'updated' => $ids['status'],
                    'scanID' => $ids['scanID']
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

    public function load_itemscanInCount($id = null) {
        echo json_encode($this->count->getScanListInCount($id));
    }

    public function addScanFileToCurrentCount($countID, $scanSelected = null) {
        if (!is_null($scanSelected)) {
            $status = $this->count->addToCountSelectedScan($countID, $scanSelected);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Count Updated on Selected Items'
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    public function closeScanFileToImport($scanSelected = null) {
        if (!is_null($scanSelected)) {
            $status = $this->count->closeScanFileToImport($scanSelected);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => 'Scan File Selected marked as completed'
                ];
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    /**
     * ITEM COUNT LIST ACTIONS
     * @param $countID
     * @param $location
     */
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

    public function setZeroAllCount($id) {
        $status = $this->count->setZero_AllList($id);
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
        $orderBy = null;
        if (isset($_GET['orderBy'])) {
            $orderBy = $_GET['orderBy'] . ' ' . $_GET['orderType'];
        }
        $result = $this->count->itemCountScan($status, $orderBy);
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
                $response = array(
                    "status" => "success",
                    "message" => "Item Scan created successfully",
                    "id" => $id,
                );
            } else
                $response = $this->dbErrorMsg();
        } else
            $response = $this->dbErrorMsg(0);
        echo json_encode($response);} //JSON_PRETTY_PRINT

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

    // UPLOAD CSV ON ITEM SCAN IMPORT
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
        $maxSize = (500)*(1000); // 5Mb
        if (file_exists($target_file)) {
            $msg = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // File size validation
        else if ($_FILES["file"]["size"] == 0) {
            $msg = "File is Empty, cannot import";
            $uploadOk = 0;
        }
        else if ($_FILES["file"]["size"] > $maxSize) {
            $msg = "File is too large. Maximum 5Mb to upload.";
            $uploadOk = 0;
        }

        // File format validation
        else if(!in_array($imageFileType, ["csv", "txt"])) {
            $msg = "Sorry, only CSV and TXT files are accepted.";
            $uploadOk = 0;
        }
        else {
            $validation = $this->excelValidated($_FILES["file"]["tmp_name"]);
            if (!$validation['isOk']) {
                $msg = "Validation Error: Line {$validation['line']} Quantity greater than 6 digits.";
                $uploadOk = 0;
            }
        }
        // Was there an error?
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $msg = "The file ". $target_name. " has been uploaded successfully.";
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

    private function excelValidated($file) {
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        try {
            $inputFileType = IOFactory::identify($file);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
            //
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray(
                    'A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    FALSE,
                    TRUE
                );
                $rowData = $rowData[0];
                $qty = $rowData[1];
                if (!is_null($qty)) {
                    $qty = explode('.', (string)$qty);
                    if (strlen($qty[0]) > 6) {
                        return [
                            'isOk' => false,
                            'line' => $row
                        ];
                    }
                }
            }
            return [
                'isOk' => true
            ];
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
    }

}