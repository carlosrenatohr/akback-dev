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

        return $this->db->query($query)->result_array();
    }

}