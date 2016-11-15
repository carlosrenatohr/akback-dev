<?php

class Item_count_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLists()
    {
        // 1 as "CountUnique", 1 as "Status"
        $query = "
            SELECT ic.*,  
               it.\"Unique\" as \"ItemUnique\", trim(it.\"Item\") as \"Item\",
               trim(it.\"Part\") as \"Part\", trim(it.\"Description\") as \"Description\",
               trim(cm.\"MainName\") as \"Category\", trim(cs.\"Name\") as \"SubCategory\", trim(su.\"Company\") as \"Supplier\",
               trim(it.\"SupplierPart\") as \"SupplierPart\",
               (it.\"Cost\" + it.\"Cost_Extra\" + it.\"Cost_Freight\" + it.\"Cost_Duty\") as \"Cost\",
                ST.\"CurrentStock\" as \"CurrentStock\"
            FROM item_count ic
            left join item_count_list icl on icl.\"CountUnique\" = ic.\"Unique\"
            left join item it on it.\"Unique\" = icl.\"ItemUnique\"
            left join category_main cm on cm.\"Unique\" = IT.\"MainCategory\"
            left join category_sub cs on cs.\"Unique\" = IT.\"CategoryUnique\"
            left join supplier su on su.\"Unique\" = IT.\"SupplierUnique\"
            left join
                (select \"ItemUnique\",sum(\"Quantity\") as \"CurrentStock\"
                 from item_stock_line 
                 where \"status\" = 1 and \"LocationUnique\" = 1
                 group by \"ItemUnique\") ST
                on ST.\"ItemUnique\" = it.\"Unique\"
                where it.\"Status\" = 1
        ";

        $query = "
            SELECT icl.*, ic.\"Location\", ic.\"Station\", trim(ic.\"Comment\"),
              ic.\"Location\", ic.\"Status\" as \"StatusCount\" 
            FROM item_count ic
            left join item_count_list icl on icl.\"CountUnique\" = ic.\"Unique\"
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