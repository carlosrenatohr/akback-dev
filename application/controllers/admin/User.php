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
        $this->load->model('user_model');
    }

    public function index()
    {
        $data['currentuser'] = $this->session->userdata("currentuser");
        $data['page_title'] = "Users administrator";
        $data['storename'] = $this->displaystore();
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
        $values = $positionValues = [];
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
            //
            $values['Status'] = 1;
            $values['Created'] = date('Y-m-d G:i:s');
            $values['CreatedBy'] = $this->session->userdata('userid');
            $status = $this->user_model->store($values);
            $response = [
                'status' => 'success',
                'message' => $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => $validations['message']
            ];
        }

        echo json_encode($response);
    }

    /**
     * @method POST
     * @description Update an exist user
     * @returnType json
     */
    public function update_user()
    {
        $values = $positionValues = [];
        $id = $_POST['Unique'];
        unset($_POST['Unique']);
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
            if (!empty($values['Password'])) {
                $values['Password'] = md5($values['Password']);
            } else {
                unset($values['Password']);
            }
            // Code is not empty?
            $values['Code'] = ($values['Code'] == '******') ? '' : $values['Code'];
            if (!empty($values['Code'])) {
                $values['Code'] = md5($values['Code']);
            } else {
                unset($values['Code']);
            }
            // Rest of values
//            $values['Status'] = 1;
            $values['Updated'] = date('Y-m-d G:i:s');
            $values['UpdatedBy'] = $this->session->userdata('userid');
            $status = $this->user_model->update($values, $id);
            $response = [
                'status' => 'success',
                'message' => 'Updated: ' . $status
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => $validations['message']
            ];
        }
        echo json_encode($response);

    }

    /**
     * @method POST
     * @description Delete an exist user
     * @returnType json
     */
    public function delete_user() {
        $id = $_POST['Unique'];
        $status = $this->user_model->softDelete($id);
        $response = [
            'status' => 'success',
            'message' => $status
        ];

        echo json_encode($response);
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
        $usernameUsed = $this->user_model->validateField('UserName', $data['UserName']);
        if($usernameUsed) {
            $sure = false;
            $message['username'] = 'Selected User Name already in use.  Please input different user name';
        }
        //
        // if (is_numeric($code) && !is_float($code)) {
        if (!preg_match('/^[1-9][0-9]{0,12}$/', $data['Code'])) {
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

        $whereNot = ['UserName !=' => $user[0]['UserName']];
        $usernameUsed = $this->user_model->validateField('UserName', $data['UserName'], $whereNot);
        if($usernameUsed) {
            $sure = false;
            $message['username'] = 'Selected User Name already in use.  Please input different user name';
        }
        // -- Checking Code and password
        $data['Code'] = ($data['Code'] == "******") ? '' : $data['Code'];
        if (!empty($data['Code'])) {
            if (!preg_match('/^[1-9][0-9]{0,12}$/', $data['Code'])) {
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