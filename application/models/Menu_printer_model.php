<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 06-03-16
 * Time: 02:05 PM
 */
class Menu_printer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllPrinters()
    {
        $this->db->select('item_printer.*, config_station_printers.name, config_station_printers.description,
                    config_station_printers.printer_port, item.Item
                ');
        $this->db->from('item_printer');
        $this->db->where(['item_printer.Status' => 1]);
        $this->db->order_by('item_printer.Unique DESC');
        $this->db->join('item', 'item_printer.ItemUnique = item.Unique');
        $this->db->join('config_station_printers', 'item_printer.PrinterUnique = config_station_printers.unique');
        return $this->db->get()->result_array();
    }

}