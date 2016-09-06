<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-17-16
 * Time: 06:34 PM
 */
class Customer extends AK_Controller
{

    protected $decimalQuantity, $decimalPrice, $decimalTax;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'customer');
        $this->load->model('Note_model', 'notes');
        $this->load->model('User_model', 'user');
        $this->decimalQuantity = (int)$this->session->userdata('DecimalsQuantity');
        $this->decimalPrice = (int)$this->session->userdata("DecimalsPrice");
        $this->decimalTax = (int)$this->session->userdata("DecimalsTax");
    }

    public function index()
    {
        // data to send
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Customer Dashboard";
        $data['storename'] = $this->displaystore();
//        if (!$this->session->has_userdata('admin_CustomerCheckInEnabled')) {
        $this->isCustomerCheckedInEnabled(
            'CustomerCheckInEnabled',
            $this->session->userdata("station_number"),
            'stationunique'
        );
        $this->isCustomerCheckedInEnabled(
            'CustomerPurchasesEnabled',
            $this->session->userdata("station_number"),
            'stationunique'
        );
        $data['checkinEnabled'] = $this->session->userdata('admin_CustomerCheckInEnabled');
        $data['CustomerPurchasesEnabled'] = $this->session->userdata('admin_CustomerPurchasesEnabled');
//        }
        $data['decimalQuantitySetting'] = $this->decimalQuantity;
        $data['decimalPriceSetting'] = $this->decimalPrice;
        $data['locations'] = $this->customer->getLocations();
        // Partial Views
        $data['contacts_tab_view'] = "backoffice_admin/customers/contacts_tab";
        $data['contacts_form'] = "backoffice_admin/customers/contacts_form";
        $data['notes_tab_view'] = "backoffice_admin/customers/notes_tab";
        $data['purchases_tab_view'] = "backoffice_admin/customers/purchases_tab";
        $data['options_tab_view'] = "backoffice_admin/customers/options_tab";
        $data['visits_tab_view'] = "backoffice_admin/customers/visits_tab";
        $data['checkout_form'] = "backoffice_admin/customers/checkout_form";
        $data['main_content'] = "backoffice_admin/customers/index";
        // Main view
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    /**
     * @method GET
     * @description Load all customers
     * @returnType json
     */
    public function load_allCustomers()
    {
        $parentUnique = (isset($_GET['parent'])) ? $_GET['parent'] : null;
        $formName = (isset($_GET['form'])) ? $_GET['form'] : null;
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
        }
        //
        $newCustomers = [];
        $customers = $this->customer->getAllCustomers($parentUnique, $formName, false, $pageNum, $perPage, $whereQuery, $sortData);
        foreach($customers as $customer) {
            $customer['AccountStatus'] = trim($customer['AccountStatus']);
            if ($customer['AccountStatus'] == 'On Hold' || $customer['AccountStatus'] == 'Suspended') {
                $customer['readyToCheckIn'] = false;
            } else {
                $customer['readyToCheckIn'] = true;
                //
                $customer['checkedOut'] = $this->customer->isCustomerCheckedOut($customer['Unique']);
                if (!is_null($customer['LastVisit'])) {
                    if (!is_null($customer['VisitDays']) && $customer['VisitDays'] > 0) {
                        //------------
                        $lv_exclude = (explode('-', $customer['LastVisit']));
                        if(isset($lv_exclude[3]))  unset($lv_exclude[3]);
                        $customer['LastVisit'] = (implode('-', $lv_exclude));
                        //------------
                        $lv = $customer['LastVisit'];
                        $customer['_LastVisit'] = date('M d Y h:iA', strtotime($lv));
                        $now = new DateTime();
                        $days = $customer['VisitDays'];

                        $customer['strtotimeToday'] = date('Y-m-d h:i:sA', time());
                        $customer['strtotime7Days'] = date('Y-m-d h:i:sA', strtotime($lv . " +{$days} day"));
                        $checkInDaysLimit = new DateTime(date('Y-m-d', strtotime($lv . "+{$days} day")));
                        $customer['diffSinceLastVisit'] = $checkInDaysLimit->diff($now)->format("%d");

                        $customer['readyToCheckIn'] = (time() >= strtotime($lv . " +{$days} day") || $customer['diffSinceLastVisit'] == 0);
                    } else {
                        if ($customer['checkedOut'] > 0) {
                            $customer['readyToCheckIn'] = true;
                        } else
                            $customer['readyToCheckIn'] = false;
                    }
                }
            }
            $newCustomers[] = $customer;
        }
        // Counting
        $total = $this->customer->getAllCustomers($parentUnique, $formName, true, null, null, $whereQuery, $sortData);
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
                    // $filterdatafield = "\"".$filterdatafield."\"";
                    switch ($filtercondition) {
                        case "CONTAINS":
                            $where .= " LOWER(customer.\"" . $filterdatafield . "\") LIKE LOWER('%" . $filtervalue . "%')";
                            break;
                        case "CONTAINS_CASE_SENSITIVE":
                            $where .= " customer.\"" . $filterdatafield . "\" LIKE '%" . $filtervalue . "%'";
                            break;
                        case "DOES_NOT_CONTAIN":
                            $where .= " LOWER(customer.\"" . $filterdatafield . "\") NOT LIKE LOWER('%" . $filtervalue . "%')";
                            break;
                        case "DOES_NOT_CONTAIN_CASE_SENSITIVE":
                            $where .= " customer.\"" . $filterdatafield . "\" NOT LIKE '%" . $filtervalue . "%'";
                            break;
                        case "EQUAL":
                            $where .= " LOWER(customer.\"" . $filterdatafield . "\") = LOWER('" . $filtervalue . "')";
                            break;
                        case "EQUAL_CASE_SENSITIVE":
                            $where .= " customer.\"" . $filterdatafield . "\" = '" . $filtervalue . "'";
                            break;
                        case "NOT_EQUAL":
                            $where .= " customer.\"" . $filterdatafield . "\" <> '" . $filtervalue . "'";
                            break;
                        case "GREATER_THAN":
                            $where .= " customer.\"" . $filterdatafield . "\" > '" . $filtervalue . "'";
                            break;
                        case "LESS_THAN":
                            $where .= " customer.\"" . $filterdatafield . "\" < '" . $filtervalue . "'";
                            break;
                        case "GREATER_THAN_OR_EQUAL":
                            if ($filterdatafield == 'LastVisit')
                                $filtervalue = date('Y-m-d', strtotime($filtervalue));
                            $where .= " customer.\"" . $filterdatafield . "\" >= '" . $filtervalue . "'";
                            break;
                        case "LESS_THAN_OR_EQUAL":
                            if ($filterdatafield == 'LastVisit')
                                $filtervalue = date('Y-m-d', strtotime($filtervalue));
                            $where .= " customer.\"". $filterdatafield . "\" <= '" . $filtervalue . "'";
                            break;
                        case "STARTS_WITH":
                            $where .= " LOWER(customer.\"" . $filterdatafield . "\") LIKE LOWER('" . $filtervalue . "%')";
                            break;
                        case "STARTS_WITH_CASE_SENSITIVE":
                            $where .= " customer.\"" . $filterdatafield . "\" LIKE '" . $filtervalue . "%'";
                            break;
                        case "ENDS_WITH":
                            $where .= " LOWER(customer.\"" . $filterdatafield . "\") LIKE ('%" . $filtervalue . "')";
                            break;
                        case "ENDS_WITH_CASE_SENSITIVE":
                            $where .= " customer.\"" . $filterdatafield . "\" LIKE '%" . $filtervalue . "'";
                            break;
                        case "EMPTY":
                            $where .= " customer.\"" . $filterdatafield . "\" = ''";
                            break;
                        case "NOT_EMPTY":
                            $where .= " customer.\"" . $filterdatafield . "\" <> ''";
                            break;
                        case "NULL":
                            $where .= " customer.\"" . $filterdatafield . "\" IS NULL";
                            break;
                        case "NOT_NULL":
                            $where .= " customer.\"" . $filterdatafield . "\" IS NOT NULL";
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

    /**
     * @helper
     * @description group fields with their sub-fields
     * @returnType array
     */
    private function customerFieldsWithOptions()
    {
        $new_fields = [];
        $fields = $this->customer->getAttributesByForm('Customer', 'ParentUnique, Row, Column, Sort'); //Tab, Sort, Row, Column
        foreach ($fields as $field) {
            if ($field['ParentUnique'] == 0) {
                $field['classForm'] = strtolower($field['Form']);
                $new_fields[$field['Unique']] = $field;
            } else {
                $new_fields[$field['ParentUnique']]['options'][] = $field;
            }
        }
        return $new_fields;
    }

    /**
     * @method GET
     * @description Load all customers attributes
     * @returnType json
     */
    public function load_customerAttributes()
    {
        echo json_encode($this->customerFieldsWithOptions());
    }

    /**
     * @method GET
     * @description Load customers attributes to show on grid
     * @returnType json
     */
    public function load_customerGridAttributes()
    {
        echo json_encode($this->customer->getAttributesByForm('CustomerGrid', 'Sort ASC'));
    }

    /**
     * @method POST
     * @description Create new customer by custom attributes
     * @returnType json
     */
    public function createCustomer()
    {
        $request = $_POST;
        $newId = $this->customer->postCustomer($request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Customer success!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Update customer
     * @returnType json
     */
    public function updateCustomer($id)
    {
        $request = $_POST;
        $status = $this->customer->updateCustomer($request, $id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer update: ' . $status
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Delete customer
     * @returnType json
     */
    public function deleteCustomer($id)
    {
        $status = $this->customer->deleteCustomer($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer deleted!'
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    //
    /**
     * @method GET
     * @description Load all customers Contacts attributes
     * @returnType json
     */
    public function load_customerContactsAttributes()
    {
        echo json_encode($this->customerContactsAttrsWithOptions());
    }

    /**
     * @helper
     * @description group fields with their sub-fields
     * @returnType array
     */
    private function customerContactsAttrsWithOptions()
    {
        $new_fields = [];
        $fields = $this->customer->getAttributesByForm('CustomerContact', 'ParentUnique, Sort');
        foreach ($fields as $field) {
            if ($field['ParentUnique'] == 0) {
                $new_fields[$field['Unique']] = $field;
            }
            else {
                $new_fields[$field['ParentUnique']]['options'][] = $field;
            }
        }
        return $new_fields;
    }

    // --- CUSTOMER NOTES
    /**
     * @method GET
     * @description Load all notes by customer
     * @returnType json
     */
    public function load_customerNotes($customerID = null)
    {
        $newNotes = [];
        $notes = $this->notes->getNotesByType('customer', $customerID);
        foreach($notes as $note) {
            $note['Created'] = date('m/d/Y', strtotime($note['Created'])); //m/d/Y h:iA
            $note['Updated'] = date('m/d/Y', strtotime($note['Updated']));
            $newNotes[] = $note;
        }

        echo json_encode($newNotes);
    }

    /**
     * @method POST
     * @description Create Customer note
     * @returnType json
     */
    public function createCustomerNote()
    {
        $request = $_POST;
        $newId = $this->notes->postNote($request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Customer Note success!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Update Customer note
     * @returnType json
     */
    public function updateCustomerNote($id)
    {
        $request = $_POST;
        $newId = $this->notes->updateNote($id, $request);
        if ($newId) {
            $response = [
                'status' => 'success',
                'message' => 'Customer Note success!',
                'new_id' => $newId
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Delete customer note
     * @returnType json
     */
    public function deleteCustomerNote($id)
    {
        $status = $this->notes->deleteNote($id);
        if ($status) {
            $response = [
                'status' => 'success',
                'message' => 'Customer Note deleted!'
            ];
        } else {
            $response = $this->dbErrorMsg();
        }
        echo json_encode($response);
    }

    // --- CUSTOMER PURCHASES
    /**
     * @method GET
     * @description Load all customers purchases
     * @returnType json
     */
    public function load_purchasesCustomer($customerID = null)
    {
        $formatPurchases = [];
        $purchases = $this->customer->purchasesBasedByCustomer($customerID);
        foreach($purchases as $purchase) {
            $createdUser = $this->user->getUsernameByUser($purchase['created_by']);
            $updatedUser = $this->user->getUsernameByUser($purchase['updated_by']);
            $locationName = $this->customer->getLocationName($purchase['location_unique']);
            $purchase['ReceiptDate_'] = (!is_null($purchase['ReceiptDate'])) ? date('m/d/Y h:iA', strtotime($purchase['ReceiptDate'])) : ''; //d-m-Y H:i:sA
            //
            $purchase['created'] = (!is_null($purchase['created'])) ? date('m/d/Y h:iA', strtotime($purchase['created'])) : '';
            $purchase['created_by'] = !empty($createdUser) ? $createdUser[0]['UserName'] : '' ;
            $purchase['updated'] = (!is_null($purchase['updated'])) ? date('m/d/Y h:iA', strtotime($purchase['updated'])) : ''; //d-m-Y H:i:sA
            $purchase['updated_by'] = !empty($updatedUser) ? $updatedUser[0]['UserName'] : '';
            $purchase['location_unique'] = !empty($locationName) ? $locationName[0]['Name'] : '';
            //
            $purchase['SellPrice'] = (!is_null($purchase['SellPrice'])) ? number_format($purchase['SellPrice'], $this->decimalPrice) : '';
            $purchase['Quantity'] = (!is_null($purchase['Quantity'])) ? number_format($purchase['Quantity'], $this->decimalQuantity) : '';
            $purchase['ListPrice'] = (!is_null($purchase['ListPrice'])) ? number_format($purchase['ListPrice'], $this->decimalPrice) : '';
            $purchase['Discount'] = (!is_null($purchase['Discount'])) ? number_format($purchase['Discount'], $this->decimalPrice) : '';
            $purchase['Tax'] = (!is_null($purchase['Tax'])) ? number_format($purchase['Tax'], $this->decimalTax) : '';
            $purchase['Total'] = (!is_null($purchase['Total'])) ? number_format($purchase['Total'], $this->decimalPrice) : '';
            $formatPurchases[] = $purchase;
        }
        echo json_encode($formatPurchases);
    }

    public function getLocationName($unique)
    {
        $location = $this->customer->getLocationName($unique);
        echo $location[0]['Name'];
    }

}