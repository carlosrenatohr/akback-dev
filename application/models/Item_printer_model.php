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
        return $this->db
            ->where('status', 1)
            ->order_by('name ASC')
            ->get('config_station_printers')->result_array();
    }

    public function verifyPrinterByItemToCreate($request) {
        $status = $this->db->select('Unique, PrinterUnique')
                    ->where($request)
                    ->get('item_printer')->row_array();
        if (!count($status)) {
            $printerToUpdate = $this->postPrinter($request);
        } else {
            $printerToUpdate = $status['Unique'];
        }
        //
        $this->restartPrimaryPrintersByItem($request);
        //
        $this->db->trans_start();
        $this->db->where('Unique', $printerToUpdate);
        $this->db->update('item_printer', ['Primary' => 1]);
        $this->db->trans_complete();
    }

    public function restartPrimaryPrintersByItem($req) {
        $this->db->trans_start();
        $this->db->where('ItemUnique', $req['ItemUnique']);
        $this->db->update('item_printer', ['Primary' => NULL]);
        $this->db->trans_complete();
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
        $status = true;
        if (!is_null($id) && $id != 'null') {
            $this->db->where('Unique', $id);
            $status = $this->db->delete('item_printer');
        }
        return $status;
    }

    public function getCustomCompletePrinters() {
        $this->db->select("item_printer.*, item.Description as ItemDescription, item.Item, item.Unique as ItemUnique,
                        item.price1 as \"Price\", category_main.\"MainName\" as \"Category\",
                        category_sub.\"Name\" as \"SubCategory\",
                        config_station_printers.\"name\",
                        config_station_printers.\"description\""
                        );
        $this->db->from('item');
        $this->db->where('item.Status', 1);
        $this->db->order_by("item.\"Unique\" DESC, config_station_printers.\"description\" ASC");
        $this->db->join('category_sub', 'item.CategoryUnique = category_sub.Unique', 'left');
        $this->db->join('category_main', 'category_sub.CategoryMainUnique = category_main.Unique', 'left');
        $this->db->join('item_printer', 'item.Unique = item_printer.ItemUnique', 'left');
        $this->db->join('config_station_printers', 'config_station_printers.unique = item_printer.PrinterUnique', 'left');
        return $this->db->get()->result_array();
    }

    public function getPrimaryPrinterByItem($item) {
        $this->db->select('PrinterUnique as PrimaryPrinter');
        $this->db->from('item_printer');
        $this->db->where('ItemUnique', $item);
        $this->db->where('Primary', 1);
        return $this->db->get()->row_array();
    }


}