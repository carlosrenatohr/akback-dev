<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 04-25-16
 * Time: 03:54 PM
 */
class user_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getLists()
    {
        $this->db->select(
            'config_user.*,
            config_user_position.ConfigPositionUnique as PrimaryPosition,
            config_position.PositionName as PrimaryPositionName
            '
        );
        $this->db->from('config_user');
        $this->db->join('config_user_position', 'config_user.Unique = config_user_position.ConfigUserUnique', 'left');
        $this->db->join(
            'config_position',
            'config_position.Unique = config_user_position.ConfigPositionUnique',
            'left'
        );
        $query = $this->db/*->where('config_user_position.PrimaryPosition', 1)*/
        ->where('config_user.Status', 1)
            ->order_by('config_user.Unique', 'DESC')
            ->get();
        return $query->result_array();
    }

    public function getPositions()
    {
        $query = $this->db
            ->select('Unique, PositionName, PositionLevel as level')
            ->where('Status', 1)
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
                    config_position.PositionName,
                    config_position.PositionLevel,
                        ')
            ->where($where)
            ->join(
                'config_position',
                'config_position.Unique = config_user_position.ConfigPositionUnique'
            )
            ->from("config_user_position")
            ->get();
        return $query->result_array();
    }

    public function store($data)
    {
        $position_id = $data['position'];
        unset($data['position']);
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
        return $result;
    }

    public function update($data, $id) {
        $position_id = $data['position'];
        unset($data['position']);
        //
        $query = $this->db
                    ->update('config_user', $data, "Unique = {$id}");
        //
        $user_position = [
            'PrimaryPosition' => 1,
            'Status' => 1,
        ];
        $where = ['ConfigPositionUnique' => $position_id,
                  'ConfigUserUnique' => $id];
        $exists = $this->db->where($where)
            ->get('config_user_position')->result_array();
        if (count($exists)) {
            $user_position['Updated'] = date('Y-m-d H:i:s');
            $user_position['UpdatedBy'] = $this->session->userdata('userid');
            $this->db->where('ConfigUserUnique', $id);
            $this->db->update('config_user_position', ['PrimaryPosition' => 0, 'Status' => 0]);

            $this->db->where($where);
            $this->db->update('config_user_position', $user_position);
        } else {
            $user_position['Created'] = date('Y-m-d H:i:s');
            $user_position['CreatedBy'] = $this->session->userdata('userid');

            $this->db->where('ConfigUserUnique', $id);
            $this->db->update('config_user_position', ['PrimaryPosition' => 0, 'Status' => 0]);

            $user_position = array_merge($user_position, $where);
            $this->db->insert('config_user_position', $user_position);
        }

        return $query;
    }

    public function softDelete($id) {
        $values = [
            'Status' => 0,
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $this->db->where('Unique', $id);
        $query = $this->db->update('config_user', $values);

        return $query;
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

}