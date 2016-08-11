<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-03-16
 * Time: 02:05 PM
 */
class Item_printer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllItemPrinters($itemUnique = null)
    {
        $this->db->select('item_printer.*, config_station_printers.name, config_station_printers.description,
                    config_station_printers.printer_port, item.Item, item.Description as ItemDescription
                ');
        $this->db->from('item_printer');
        if(!is_null($itemUnique)) {
            $this->db->where(['item_printer.ItemUnique' => $itemUnique]);
        }
        $this->db->where(['item_printer.Status' => 1]);
        $this->db->order_by('item_printer.Unique DESC');
        $this->db->join('item', 'item_printer.ItemUnique = item.Unique');
        $this->db->join('config_station_printers', 'item_printer.PrinterUnique = config_station_printers.unique');
        return $this->db->get()->result_array();
    }

    public function getPrinters() {
        return $this->db->get('config_station_printers')->result_array();
    }

    public function postPrinter($request) {
        $extra_fields = [
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'Createdby' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $status = $this->db->insert('item_printer', $data);
        return $this->db->insert_id();
    }

    public function updatePrinter($id, $request) {
        $extra_fields = [
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $this->db->where('Unique', $id);
        $status = $this->db->update('item_printer', $data);
        return $status;
    }

    public function deletePrinter($id) {
        $this->db->where('Unique', $id);
        $status = $this->db->delete('item_printer');
        return $status;
    }



}