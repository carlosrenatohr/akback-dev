<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 07-26-16
 * Time: 05:41 PM
 */
class CustomerCheckin extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'customer');
        $this->load->model('User_model', 'user');
    }

    public function setCustomerAsCheckin() {
        $request = $_POST;
        $days = $this->customer->getCheckinDaysSetting($request['LocationUnique']);
        $newId = $this->customer->setCheckin($request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Checked in successfully!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    public function load_checkInCustomersByLocation($status, $location) {
        // pagination
        $pageNum = (isset($_GET['pagenum'])) ? $_GET['pagenum'] : 1;
        $perPage = (isset($_GET['pagesize'])) ? $_GET['pagesize'] : 20;

        // Sorting
        $sortData = null;
        if (isset($_GET['sortdatafield']))
        {
            $sortData = [
                'sortdatafield' => $_GET['sortdatafield'],
                'sortorder' => $_GET['sortorder'],
            ];
        }
        // Filtering
        $whereQuery = '';
        if (isset($_GET['filterscount']))
        {
            $filterscount = $_GET['filterscount'];
            if ($filterscount > 0)
            {
                $whereQuery = $this->filterCustomerTable($_GET);
            }
            // *Default showing only checked out customers
            else {
//                if ($status == 2 && $location == 0) {
//                    $today = date('Y-m-d');
//                    $tomorrow = date('Y-m-d H:i:s', strtotime($today . ' +1 day'));
//                    $_GET["CheckOutDateoperator"] =  "and";
//                    $_GET["filtervalue0"] = $today;
//                    $_GET["filtercondition0"] =  "GREATER_THAN_OR_EQUAL";
//                    $_GET["filteroperator0"] = "0";
//                    $_GET["filterdatafield0"] = "CheckOutDate";
//                    $_GET["filtervalue1"] =  $tomorrow;
//                    $_GET["filtercondition1"] = "LESS_THAN_OR_EQUAL";
//                    $_GET["filteroperator1"] = "0";
//                    $_GET["filterdatafield1"]= "CheckOutDate";
//                    $_GET["filterscount"] = "2";
//                    $whereQuery = $this->filterCustomerTable($_GET);
//                }
            }
        }
        $newCustomers = [];
        // Counting
        $total = $this->customer->getCustomersWithVisits($status, $location, true, null, null, $whereQuery, $sortData);
        $customers = $this->customer->getCustomersWithVisits($status, $location, false, $pageNum, $perPage, $whereQuery, $sortData);
        foreach($customers as $customer) {
            $locationName = $this->customer->getLocationName($customer['LocationUnique']);
            $customer['LocationName'] = !empty($locationName) ? $locationName[0]['Name'] : '';
            $customer['_CheckInDate'] = (!is_null($customer['CheckInDate'])) ? date('m/d/Y h:i:sA', strtotime($customer['CheckInDate'])) : '';
            $customer['_CheckOutDate'] = (!is_null($customer['CheckOutDate'])) ? date('m/d/Y h:i:sA', strtotime($customer['CheckOutDate'])) : '';
            $newCustomers[] = $customer;
        }

        echo json_encode([
            'Rows' => $newCustomers,
            'TotalRows' => $total
        ]);
    }

    public function total_allCustomers() {
        $parentUnique = (isset($_GET['parent'])) ? $_GET['parent'] : null;
        $formName = (isset($_GET['form'])) ? $_GET['form'] : null;
        echo json_encode([
                'total' => $this->customer->getAllCustomers($parentUnique, $formName, true)
            ]
        );
    }

    private function filterCustomerTable($filterData) {
        $where = null;
//        var_dump($filterData);exit;
        if (!is_null($filterData['filterscount'])) {
            $filterscount = $filterData['filterscount'];

            if ($filterscount > 0) {
                $where = "(";
                $tmpdatafield = "";
                $tmpfilteroperator = "";
                $filterscount = $filterData['filterscount'];
                for ($i = 0; $i < $filterscount; $i++) {
                    // get the filter's value.
                    $filtervalue = $filterData["filtervalue" . $i];
                    // get the filter's condition.
                    $filtercondition = $filterData["filtercondition" . $i];
                    // get the filter's column.
                    $filterdatafield = $filterData["filterdatafield" . $i];
                    // get the filter's operator.
                    $filteroperator = $filterData["filteroperator" . $i];
                    if ($tmpdatafield == "") {
                        $tmpdatafield = $filterdatafield;
                    } else {
                        if ($tmpdatafield <> $filterdatafield) {
                            $where .= ") AND (";
                        } else {
                            if ($tmpdatafield == $filterdatafield) {
                                if ($tmpfilteroperator == 0) {
                                    $where .= " AND ";
                                } else {
                                    $where .= " OR ";
                                }
                            }
                        }
                    }
                    // Build the "WHERE" clause depending on the filter's condition, value and datafield.
                    if ($filterdatafield == 'FirstName')
                        $filterdatafield = "customer_visit\".\"FirstName";
                    if ($filterdatafield == 'LastName')
                        $filterdatafield = "customer_visit\".\"LastName";
                    if ($filterdatafield == 'Unique')
                        $filterdatafield = "customer\".\"Unique";
                    if ($filterdatafield == 'CheckOutDate') {
                        $filterdatafield = "customer_visit\".\"CheckOutDate";
                        $filtervalue = date('Y-m-d', strtotime(str_replace('-', '/', $filtervalue)));
                    }
                    switch ($filtercondition) {
                        case "CONTAINS":
                            $where .= " \"" . $filterdatafield . "\" LIKE '%" . $filtervalue . "%'";
                            break;
                        case "DOES_NOT_CONTAIN":
                            $where .= " \"" . $filterdatafield . "\" NOT LIKE '%" . $filtervalue . "%'";
                            break;
                        case "EQUAL":
                            $where .= " \"" . $filterdatafield . "\" = '" . $filtervalue . "'";
                            break;
                        case "NOT_EQUAL":
                            $where .= " \"" . $filterdatafield . " <> '" . $filtervalue . "'";
                            break;
                        case "GREATER_THAN":
                            $where .= " " . $filterdatafield . " > '" . $filtervalue . "'";
                            break;
                        case "LESS_THAN":
                            $where .= " " . $filterdatafield . " < '" . $filtervalue . "'";
                            break;
                        case "GREATER_THAN_OR_EQUAL":
                            if ($filterdatafield == 'LastVisit')
                                $filtervalue = date('Y-m-d', strtotime($filtervalue));
                            $where .= " \"" . $filterdatafield . "\" >= '" . $filtervalue . "'";
                            break;
                        case "LESS_THAN_OR_EQUAL":
                            if ($filterdatafield == 'LastVisit')
                                $filtervalue = date('Y-m-d', strtotime($filtervalue));
                            $where .= " \"". $filterdatafield . "\" <= '" . $filtervalue . "'";
                            break;
                        case "STARTS_WITH":
                            $where .= " \"" . $filterdatafield . "\" LIKE '" . $filtervalue . "%'";
                            break;
                        case "ENDS_WITH":
                            $where .= " \"" . $filterdatafield . "\" LIKE '%" . $filtervalue . "'";
                            break;
                    }
                    if ($i == $filterscount - 1) {
                        $where .= ")";
                    }
                    $tmpfilteroperator = $filteroperator;
                    $tmpdatafield = $filterdatafield;
                }
            }
        }
        return $where;
    }

    public function updateStatusCheckin($id) {
        $request = $_POST;
        $status = $this->customer->updateCustomerVisit($id, $request);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer visit success!',
//                'status' => $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);

    }

}