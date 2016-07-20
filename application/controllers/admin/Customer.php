<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-17-16
 * Time: 06:34 PM
 */
class Customer extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model', 'customer');
        $this->load->model('Note_model', 'notes');
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Customer Dashboard";
        $data['storename'] = $this->displaystore();
        $data['contacts_tab_view'] = "backoffice_admin/customers/contacts_tab";
        $data['notes_tab_view'] = "backoffice_admin/customers/notes_tab";
        $data['purchases_tab_view'] = "backoffice_admin/customers/purchases_tab";
        $data['main_content'] = "backoffice_admin/customers/index";
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
//        $customers = $this->customer->getAllCustomers($parentUnique, $formName);
        $customers = $this->customer->getAllCustomers($parentUnique, $formName, false, $pageNum, $perPage, $whereQuery, $sortData);
        // Counting
        $total = $this->customer->getAllCustomers($parentUnique, $formName, true, null, null, $whereQuery, $sortData);
        echo json_encode([
            'Rows' => $customers,
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
                            $where .= " " . $filterdatafield . " <> '" . $filtervalue . "'";
                            break;
                        case "GREATER_THAN":
                            $where .= " " . $filterdatafield . " > '" . $filtervalue . "'";
                            break;
                        case "LESS_THAN":
                            $where .= " " . $filterdatafield . " < '" . $filtervalue . "'";
                            break;
                        case "GREATER_THAN_OR_EQUAL":
                            $where .= " " . $filterdatafield . " >= '" . $filtervalue . "'";
                            break;
                        case "LESS_THAN_OR_EQUAL":
                            $where .= " " . $filterdatafield . " <= '" . $filtervalue . "'";
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

    /**
     * @helper
     * @description group fields with their sub-fields
     * @returnType array
     */
    private function customerFieldsWithOptions()
    {
        $new_fields = [];
        $fields = $this->customer->getAttributesByForm('Customer', 'ParentUnique, Column'); //Tab, Sort, Row, Column
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
            $note['Created'] = date('d/m/Y h:iA', strtotime($note['Created']));
            $note['Updated'] = date('d/m/Y h:iA', strtotime($note['Updated']));
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

    /**
     * @helper
     * @description in error case
     * @returnType array
     */
    private function dbErrorMsg()
    {
        return $response = [
            'status' => 'error',
            'message' => 'Database error'
        ];
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
            $purchase['ReceiptDate_'] = date('d/m/Y h:iA', strtotime($purchase['ReceiptDate'])); //d-m-Y H:i:sA
            $purchase['created'] = date('d/m/Y h:iA', strtotime($purchase['created'])); //d-m-Y H:i:sA
            $purchase['created_by'] = !empty($createdUser) ? $createdUser[0]['UserName'] : '' ;
            $purchase['updated'] = date('d/m/Y h:iA', strtotime($purchase['updated'])); //d-m-Y H:i:sA
            $purchase['updated_by'] = !empty($updatedUser) ? $updatedUser[0]['UserName'] : '';
            $purchase['location_unique'] = !empty($locationName) ? $locationName[0]['Name'] : '';
            $purchase['Quantity'] = number_format($purchase['Quantity'], $this->session->userdata('DecimalsQuantity'));
            $purchase['ListPrice'] = number_format($purchase['ListPrice'], $this->session->userdata('DecimalsQuantity'));
            $purchase['Discount'] = number_format($purchase['Discount'], $this->session->userdata('DecimalsQuantity'));
            $purchase['Tax'] = number_format($purchase['Tax'], $this->session->userdata('DecimalsQuantity'));
            $purchase['Total'] = number_format($purchase['Total'], $this->session->userdata('DecimalsQuantity'));
            $formatPurchases[] = $purchase;
        }
        echo json_encode($formatPurchases);
    }

}