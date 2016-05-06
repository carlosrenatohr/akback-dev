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
            ->select('Unique as id, PositionName as name, PositionLevel as level')
            ->where('Status', 1)
            ->from("config_position")
            ->get();
        return $query->result_array();
    }

    public function store($data)
    {
        $position_id = $data['position'];
        unset($data['position']);
        $result = $this->db->insert('config_user', $data);
        $insert_id = $this->db->insert_id();
        $user_position = [
            'ConfigPositionUnique' => $position_id,
            'ConfigUserUnique' => $insert_id,
            'PrimaryPosition' => 1,
//            'PayBasis' => 1,
//            'Payrate' => 1,
            'Status' => 1,
            'Created' => date('Y-m-d G:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $this->db->insert('config_user_position', $user_position);
        return $result;
    }

    public function update($data, $id) {
        $query = $this->db
            ->where('Unique', $id)->get('config_user')->result_array();
        return count($query);
    }

    public function validateField($field, $value)
    {
        $query = $this->db->where($field, $value)->get('config_user')->result_array();
        return count($query);
    }

}