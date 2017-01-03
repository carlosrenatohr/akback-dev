<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 01:45 PM
 */
class User extends AK_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user_model');
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Users administrator";
        $data['storename'] = $this->displaystore();
        $user_views_path = "backoffice_admin/users/";
        $data['user_tab_view'] = $user_views_path . "user_tab";
        $data['contact_tab_view'] = $user_views_path . "contact_tab";
        $data['email_tab_view'] = $user_views_path . "email_tab";
        $data['position_tab_view'] = $user_views_path. "position_tab";
        $data['notes_tab_view'] = $user_views_path. "notes_tab";
        $data['metadata_tab_view'] = $user_views_path. "metadata_tab";
        $data['main_content'] = "backoffice_admin/users/index";
        $this->load->view('backoffice_admin/templates/main_layout', $data);
    }

    /**
     * @method GET
     * @description Get all users
     * returnType json
     */
    public function load_users()
    {
        echo json_encode($this->user_model->getLists());
    }

    /**
     * @method GET
     * @description Get all positions to show
     * @returnType json
     */
    public function load_allPositions()
    {
        echo json_encode($this->user_model->getPositions());
    }

    public function load_positionsByUser($id) {
        $positions = $this->user_model->getPositionsByUser($id);
        $new_positions = [];
        foreach($positions as $index => $position) {
            $position['isPosition'] = ($position['PrimaryPosition'] == 1) ? 'YES' : '-';
            $position['PayBasis'] = ucfirst($position['PayBasis']);
            $new_positions[] = $position;
        }

        echo json_encode($new_positions);
    }

    /**
     * @method POST
     * @description Save a new user
     * @returnType json
     */
    public function store_user()
    {
        if (isset($_POST) and !empty($_POST)) {
            $values = $positionValues = [];
            $emailConfig = ($_POST['emailConfig']);
            unset($_POST['emailConfig']);
            foreach ($_POST as $index => $element) {
                $pos = strpos($index, '_');
                if ($pos !== false) {
                    $temp_index = ucfirst(substr($index, $pos + 1));
                    $values[$temp_index] = $element;
                } else {
                    $values[$index] = $element;
                }
            }

            $validations = $this->validationsBeforeSaving($values);
            if ($validations['sure']) {
                $values['Password'] = md5($values['Password']);
                $values['Code'] = md5($values['Code']);
                $lastId = $this->user_model->store($values);
                if ($lastId) {
                    $emailData = [
                        'FullName' => $values['FirstName'] . ' ' . $values['FirstName'],
                        'Email' => $values['Email']
                    ];
                    $this->setEmailStatusOnUser($lastId, $values['EmailEnabled'], $emailData);
                    $response = [
                        'status' => 'success',
                        'message' => $lastId
                    ];
                } else
                    $response = $this->dbErrorMsg();

            } else {
                $response = [
                    'status' => 'error',
                    'message' => $validations['message']
                ];
            }
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Update an exist user
     * @returnType json
     */
    public function update_user()
    {
        if (isset($_POST) && !empty($_POST)) {
            $values = $positionValues = [];
            $id = $_POST['Unique'];
            unset($_POST['Unique']);
            $emailConfig = ($_POST['emailConfig']);
            unset($_POST['emailConfig']);
            foreach ($_POST as $index => $element) {
                $pos = strpos($index, '_');
                if ($pos !== false) {
                    $temp_index = ucfirst(substr($index, $pos + 1));
                    $values[$temp_index] = $element;
                } else {
                    $values[$index] = $element;
                }
            }

            // Valid Code or Password, if it is empty
            $validations = $this->validationsBeforeUpdating($values, $id);
            if ($validations['sure']) {
                // Password is not empty?
                $values['Password'] = ($values['Password'] == '******') ? '' : $values['Password'];
                if (!empty($values['Password']))
                    $values['Password'] = md5($values['Password']);
                else
                    unset($values['Password']);
                // Code is not empty?
                $values['Code'] = ($values['Code'] == '******') ? '' : $values['Code'];
                if (!empty($values[ 'Code']))
                    $values['Code'] = md5($values['Code']);
                else
                    unset($values['Code']);
                // Rest of values
//            $values['Status'] = 1;
                $status = $this->user_model->update($values, $id);
                if ($status) {
                    $emailData = [
                        'FullName' => $values['FirstName'] . ' ' . $values['LastName'],
                        'Email' => $values['Email']
                    ];
                    $emailConfig['SMTPSecure'] = (empty($emailConfig['SMTPSecure'])) ? null : $emailConfig['SMTPSecure'];
                    $this->setEmailStatusOnUser($id, $values['EmailEnabled'], $emailConfig);
                    $response = [
                        'status' => 'success',
                        'message' => 'Updated: ' . $status
                    ];
                } else
                    $response = $this->dbErrorMsg();
            } else {
                $response = [
                    'status' => 'error',
                    'message' => $validations['message']
                ];
            }
        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);

    }

    /**
     * @method POST
     * @description Delete an exist user
     * @returnType json
     */
    public function delete_user() {
        if (isset($_POST) && !empty($_POST)) {
            $id = $_POST['Unique'];
            $status = $this->user_model->softDelete($id);
            if ($status) {
                $response = [
                    'status' => 'success',
                    'message' => $status
                ];
            } else
                $response = $this->dbErrorMsg(0);

        } else
            $response = $this->dbErrorMsg(0);

        echo json_encode($response);
    }

    protected function setEmailStatusOnUser($id, $isEnabled, $data) {
        $isEnabled = ($isEnabled == 'yes') ? true : false;
        $this->user_model->setEmailStatusOnUser($id, $isEnabled, $data);
    }

    /**
     * @method POST
     * @description Add a position for user
     * @returnType json
     */
    public function add_position_user() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $return = [];
        $return['status'] = 'success';
        $return['message'] = $this->user_model->updatePositionByUser($request);

        echo json_encode($return);
    }

    public function delete_position_user($id) {
        $return = [];
        $return['status'] = 'success';
        $return['message'] = $this->user_model->deletePositionByUser($id);

        echo json_encode($return);
    }

    /**
     * @helper
     * @description Backend validations
     * @returnType array
     */
    private function validationsBeforeSaving($data) {
        $sure = true;
        $message = [];
        //
//        $usernameUsed = $this->user_model->validateField('UserName', $data['UserName']);
        $usernameUsed = $this->user_model->validateUsername($data['UserName']);
        if($usernameUsed) {
            $sure = false;
            $message['username'] = 'Selected User Name already in use.  Please input different user name';
        }
        //
        // if (is_numeric($code) && !is_float($code)) {
        if (!preg_match('/^[0-9][0-9]{0,12}$/', $data['Code'])) {
            $sure = false;
            $message['code'] = 'Your code must be number.';
        }
        $codeUsed = $this->user_model->validateField('Code', md5($data['Code']));
        if($codeUsed) {
            $sure = false;
            $message['code'] = 'Selected Code already in use.  Please input different code';
        }
        $return = [
            'sure' => $sure,
            'message' => $message
        ];
        return $return;
    }

    /**
     * @helper
     * @description Backend validations
     * @returnType array
     */
    private function validationsBeforeUpdating($data, $id) {
        $sure = true;
        $message = [];
        // -- Username validation
        $user = $this->user_model->getUsernameByUser($id);

        $whereNot = ['Unique !=' => $id];
//        $usernameUsed = $this->user_model->validateField('UserName', $data['UserName'], $whereNot);
        $usernameUsed = $this->user_model->validateUsername($data['UserName'], $whereNot);
        if($usernameUsed) {
            $sure = false;
            $message['username'] = 'Selected User Name already in use.  Please input different user name';
        }
        // -- Checking Code and password
        $data['Code'] = ($data['Code'] == "******") ? '' : $data['Code'];
        if (!empty($data['Code'])) {
            if (!preg_match('/^[0-9][0-9]{0,12}$/', $data['Code'])) {
                $sure = false;
                $message['code'] = 'Your code must be number.';
            }
            $codeUsed = $this->user_model->validateField('Code', md5($data['Code']));
            if($codeUsed) {
                $sure = false;
                $message['code'] = 'Selected Code already in use.  Please input different code';
            }
        }


        $return = [
            'sure' => $sure,
            'message' => $message
        ];
        return $return;
    }

}