<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 03:54 PM
 */
class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getLists()
    {
        $this->db->select(
            "config_user.*,
            config_user_position.\"ConfigPositionUnique\" as \"PrimaryPosition\",
            config_position.\"PositionName\" as \"PrimaryPositionName\",
            cuc.\"UserName\" as \"CreatedByName\", cuu.\"UserName\" as \"UpdatedByName\",
            to_char(date_trunc('minutes', config_user.\"Created\" ::timestamp), 'MM/DD/YYYY HH:MI AM') as \"Created\", 
            to_char(date_trunc('minutes', config_user.\"Updated\" ::timestamp), 'MM/DD/YYYY HH:MI AM') as \"Updated\" 
            ", false
        );
        $this->db->from('config_user');
        $this->db->join('config_user_position', 'config_user.Unique = config_user_position.ConfigUserUnique', 'left');
        $this->db->join(
            'config_position',
            'config_position.Unique = config_user_position.ConfigPositionUnique'
        );
        $this->db->join('config_user cuc', 'cuc.Unique = config_user.CreatedBy', 'left');
        $this->db->join('config_user cuu', 'cuu.Unique = config_user.UpdatedBy', 'left');
        $query = $this->db
            ->where('config_user_position.PrimaryPosition', 1)
            ->where('config_user.Status', 1)
            ->where('config_user.Suppress', 0)
            ->or_where('config_user.Suppress', null)
            ->order_by('config_user.Unique', 'DESC')
            ->get();
//        var_dump($this->db->last_query());exit;
        return $query->result_array();
    }

    public function getPositions()
    {
        $query = $this->db
            ->select('Unique, PositionName')
            ->where('Status', 1)
            ->where('Suppress', 0)
            ->or_where('Suppress', null)
            ->from("config_position")
            ->get();
        return $query->result_array();
    }

    public function getPositionsByUser($id) {
        $where = [
            'config_user_position.Status' => 1,
            'config_user_position.ConfigUserUnique' => $id];
        $query = $this->db
            ->select('config_user_position.*,
                    config_position.PositionName'
                    )
            ->where($where)
            ->join(
                'config_position',
                'config_position.Unique = config_user_position.ConfigPositionUnique'
            )
            ->from("config_user_position")
            ->get();
        return $query->result_array();
    }

    public function getUsernameByUser($id) {
        return $this->db->get_where('config_user', ['Unique'=> $id])->result_array();
    }

    public function store($data)
    {
        $position_id = $data['position'];
        unset($data['position']);
//        $data['Status'] = 1;
        $data['Created'] = date('Y-m-d H:i:s');
        $data['CreatedBy'] = $this->session->userdata('userid');
        $data['Suppress'] = 0;
        $result = $this->db->insert('config_user', $data);
        $insert_id = $this->db->insert_id();
        //
        $user_position = [
            'ConfigPositionUnique' => $position_id,
            'ConfigUserUnique' => $insert_id,
            'PrimaryPosition' => 1,
//            'PayBasis' => 1,
//            'Payrate' => 1,
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $this->db->insert('config_user_position', $user_position);
        return $insert_id;
    }

    public function update($data, $id) {
        $position_id = $data['position'];
        unset($data['position']);
        $data['Updated'] = date('Y-m-d H:i:s');
        $data['UpdatedBy'] = $this->session->userdata('userid');
        $query = $this->db->update('config_user', $data, "Unique = {$id}");
        //
        $this->createOrUpdatePositionUser($position_id, $id);
        return $query;
    }

    public function setEmailStatusOnUser($id, $isEnabled, $data) {
        $this->db->trans_start();
        $exists = $this->db->where('UserUnique', $id)->get('config_user_email')->row_array();
        $this->db->trans_complete();
        $this->db->trans_start();
        if ($isEnabled) {
            if (count($exists)) {
                $req['ReplyToEmail'] = (empty($data)) ? '' : $data['Email'];
                $req['ReplyToName'] = (empty($data)) ? '' : $data['FullName'];
                $req['Updated'] = date('Y-m-d H:i:s');
                $req['UpdatedBy'] = $this->session->userdata('userid');
                $req['Status'] = 1;
                $this->db->where('UserUnique', $id);
                $this->db->update('config_user_email', $req);
            } else {
                $sql = "SELECT * FROM config_user_email WHERE \"UserUnique\" = 0";
                $defaults = $this->db->query($sql)->row_array();
                $req['ReplyToEmail'] = (empty($data)) ? '' : $data['Email'];
                $req['ReplyToName'] = (empty($data)) ? '' : $data['FullName'];
                $req['Host'] = $defaults['Host'];
                $req['SmtpServer'] = $defaults['SmtpServer'];
                $req['UserName'] = $defaults['UserName'];
                $req['Password'] = $defaults['Password'];
                $req['SMTPSecure'] = $defaults['SMTPSecure'];
                $req['Port'] = $defaults['Port'];
                $req['FromEmail'] = $defaults['FromEmail'];
                $req['FromName'] = $defaults['FromName'];
                $req['Created'] = date('Y-m-d H:i:s');
                $req['CreatedBy'] = $this->session->userdata('userid');
                $req['UserUnique'] = $id;
                $req['Status'] = 1;

                $this->db->insert('config_user_email', $req);
            }
        }
        else {
            $this->db->where('UserUnique', $id);
            $this->db->delete('config_user_email');
        }
        $this->db->trans_complete();
    }

    public function createOrUpdatePositionUser($position_id, $user_id) {
        $user_position = [
            'PrimaryPosition' => 1,
            'Status' => 1,
        ];
        $where = ['ConfigPositionUnique' => $position_id,
            'ConfigUserUnique' => $user_id];
        $exists = $this->db->where($where)
            ->get('config_user_position')->result_array();
        if (count($exists)) {
            $user_position['Updated'] = date('Y-m-d H:i:s');
            $user_position['UpdatedBy'] = $this->session->userdata('userid');
            $this->db->where('ConfigUserUnique', $user_id);
            $this->db->update('config_user_position', ['PrimaryPosition' => 0]);

            $this->db->where($where);
            $this->db->update('config_user_position', $user_position);
        } else {
            $user_position['Created'] = date('Y-m-d H:i:s');
            $user_position['CreatedBy'] = $this->session->userdata('userid');

            $this->db->where('ConfigUserUnique', $user_id);
            $this->db->update('config_user_position', ['PrimaryPosition' => 0]);

            $user_position = array_merge($user_position, $where);
            $this->db->insert('config_user_position', $user_position);
        }
    }

    public function softDelete($id) {
        $values = [
            'Status' => 0,
            'EmailEnabled' => 'no',
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $query = $this->db->update('config_user', $values);
        // config_user_email
        $this->db->where('UserUnique', $id)->delete('config_user_email');

        return $query;
    }

    public function updatePositionByUser($values)
    {
        $where = [
            'ConfigPositionUnique' => $values['ConfigPositionUnique'],
            'ConfigUserUnique' => $values['ConfigUserUnique']
        ];
        $updateValues = [
            'PayRate' => $values['PayRate'],
            'PayBasis' => $values['PayBasis'],
            'PrimaryPosition' => $values['PrimaryPosition'] ? 1 : 0,
            'Status' => 1,
        ];
        $this->db->trans_start();
        $exists = $this->db->where($where)
            ->get('config_user_position')->row_array();
        $wasPrimary = $exists['PrimaryPosition'];
        $this->db->trans_complete();
        // Primary position
        if ($values['PrimaryPosition']) {
            $this->db->trans_start();
            $this->db->where('ConfigUserUnique', $values['ConfigUserUnique']);
            $this->db->update('config_user_position', ['PrimaryPosition' => 0]);
            $this->db->trans_complete();
        }
        // Update-Create position
        $this->db->trans_start();
        if (count($exists)) {
            $updateValues['Updated'] = date('Y-m-d H:i:s');
            $updateValues['UpdatedBy'] = $this->session->userdata('userid');
            if($wasPrimary == 1) {
                $updateValues['PrimaryPosition'] = $wasPrimary;
            }
            $this->db->where($where);
            $return = $this->db->update('config_user_position', $updateValues);
        }
        else {
//            $updateValues['PrimaryPosition'] = 0;
            $updateValues['Created'] = date('Y-m-d H:i:s');
            $updateValues['CreatedBy'] = $this->session->userdata('userid');
            $updateValues = array_merge($updateValues, $where);
            $return = $this->db->insert('config_user_position', $updateValues);
        }
        $this->db->trans_complete();

        return $return;
    }

    public function deletePositionByUser($id) {
        $this->db->where('Unique', $id);
        $return = $this->db->update('config_user_position',
            ['Status' => 0,
             'Updated' => date('Y-m-d H:i:s'),
             'UpdatedBy' => $this->session->userdata('userid')
            ]);
        return $return;
    }

    public function validateField($field, $value, $whereNot = null)
    {

        $this->db->where('Status', 1);
        $this->db->where($field, $value);
        if (!is_null($whereNot)) {
            $this->db->where($whereNot);
        }
        $query = $this->db->get('config_user')->result_array();
        return count($query);
    }

    public function validateUsername($value, $whereNot = null) {
        $this->db->where('Status', 1);
        $this->db->where(" LOWER(\"UserName\") LIKE LOWER('%". $value . "%')", NULL, false);
        if (!is_null($whereNot))
            $this->db->where($whereNot);
        $query = $this->db->get('config_user')->result_array();
        return count($query);
    }

}