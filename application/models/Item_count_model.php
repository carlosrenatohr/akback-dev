<?php

class Item_count_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function mainList() {
        $this->db->select('item_count.*, cl."LocationName",
          cu1."UserName" as "CreatedByName", cu2."UserName" as "UpdatedByName",
          to_char(date_trunc(\'minutes\', item_count."Created"::timestamp), \'MM/DD/YYYY HH:MI AM\') as Created,
          to_char(date_trunc(\'minutes\', item_count."Updated"::timestamp), \'MM/DD/YYYY HH:MI AM\') as Updated,
          (select count("Unique") from item_count_list icl where icl."CountUnique" = item_count."Unique")
            as "hasCountList"
          ', false);
        $this->db->from('item_count');
        $this->db->join('config_location cl', 'cl.Unique = item_count.Location', 'left');
        $this->db->join('config_user cu1', 'cu1.Unique = item_count.CreatedBy', 'left');
        $this->db->join('config_user cu2', 'cu2.Unique = item_count.UpdatedBy', 'left');
        $this->db->where('item_count.Status', 1);
        $this->db->order_by('item_count.Created', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getLists()
    {
        $query = "
            SELECT icl.*, ic.\"Location\", cl.\"LocationName\", ic.\"Station\", trim(ic.\"Comment\"),
              ic.\"Location\", ic.\"Status\" as \"StatusCount\",
              cu1.\"UserName\" as CreatedByName, cu2.\"UserName\" as UpdatedByName,
              to_char(date_trunc('minutes', ic.\"Created\"::timestamp), 'MM/DD/YYYY HH:MI AM') as \"Created\",
              to_char(date_trunc('minutes', ic.\"Updated\"::timestamp), 'MM/DD/YYYY HH:MI AM') as \"Updated\"
            FROM item_count ic
            left join item_count_list icl on icl.\"CountUnique\" = ic.\"Unique\"
            left join config_location cl on cl.\"Unique\" = ic.\"Location\"
            left join config_user cu1 on cu1.\"Unique\" = ic.\"CreatedBy\"
            left join config_user cu2 on cu2.\"Unique\" = ic.\"UpdatedBy\"
            WHERE ic.\"Status\" = 1
        ";

        return $this->db->query($query)->result_array();
    }

    public function create($data) {
        $data['Station'] = $data['Location'];
        $data['Status'] = 1;
        $data['Created'] = date('Y-m-d H:i:s');
        $data['CreatedBy'] = $this->session->userdata('userid');

        $this->db->insert('item_count', $data);
        $id = $this->db->insert_id();
//        $this->insert_count_list($id, $data['Location']);

        return $id;
    }

    public function update($id, $data) {
        $data['Updated'] = date('Y-m-d H:i:s');
        $data['UpdatedBy'] = $this->session->userdata('userid');

        $this->db->where('Unique', $id);
        return $this->db->update('item_count', $data);
    }

    public function insert_count_list($countID, $locationID) {
        $query = "
            insert into item_count_list (\"CountUnique\",\"ItemUnique\",\"Item\",\"Part\",\"Description\",\"Category\",     
                        \"SubCategory\",\"Supplier\",\"SupplierPart\",\"Cost\", \"CurrentStock\",\"CountStock\",\"Status\")
              (select ". $countID ." as \"CountUnique\", IT.\"Unique\" as \"ItemUnique\", trim(IT.\"Item\") as \"Item\",
               trim(IT.\"Part\") as \"Part\", trim(IT.\"Description\") as \"Description\", 
               trim(CM.\"MainName\") as \"Category\", trim(CS.\"Name\") as \"SubCategory\",
               trim(SU.\"Company\") as \"Supplier\",trim(IT.\"SupplierPart\") as \"SupplierPart\",
               (IT.\"Cost\"::numeric + IT.\"Cost_Extra\"::numeric + IT.\"Cost_Freight\"::numeric + IT.\"Cost_Duty\"::numeric) as \"Cost\",
               ST.\"CurrentStock\" as \"CurrentStock\", 0 as \"CountStock\", 1 as \"Status\"
              from item IT
              left join category_main CM on CM.\"Unique\" = IT.\"MainCategory\"
              left join category_sub CS on CS.\"Unique\" = IT.\"CategoryUnique\"
              left join supplier SU on SU.\"Unique\" = IT.\"SupplierUnique\"
              left join 
                (select \"ItemUnique\",sum(\"Quantity\") as \"CurrentStock\" from item_stock_line
                    where \"status\" = 1 and \"LocationUnique\" = ". $locationID ." group by \"ItemUnique\") ST
                on ST.\"ItemUnique\" = IT.\"Unique\"
                where IT.\"Status\" = 1)
        ";

        $this->db->query($query);
    }

}