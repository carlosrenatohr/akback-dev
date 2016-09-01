<?php

class Item_model extends CI_Model
{

    public function update($id, $request)
    {
        $this->db->where('Unique', $id);
        return $this->db->update('item', $request);
    }

    public function getItemsData() {
        $this->db->select("item.Unique, item.Description, item.Item, item.Part, item.SupplierUnique AS SupplierId, supplier.Company AS Supplier, item.SupplierPart, item.BrandUnique AS BrandId, brand.Name AS Brand,
			item.ListPrice, item.price1, item.price2, item.price3, item.price4, item.price5,
			category_main.Unique AS CatMainId, category_sub.Name AS Category, category_sub.Unique AS SubCategory,
			(item.\"Cost\" + item.\"Cost_Extra\" + item.\"Cost_Freight\" + item.\"Cost_Duty\"   ) AS \"CostLanded\",
			item.Cost, item.Cost_Extra, item.Cost_Freight, item.Cost_Duty,
			SUM(isl.\"Quantity\") AS Quantity");
        $this->db->from('item');
        $this->db->join("supplier", "item.SupplierUnique = supplier.Unique", 'left');
        $this->db->join("brand", "item.BrandUnique = brand.Unique", 'left');
        $this->db->join("category_sub", "item.CategoryUnique = category_sub.Unique", 'left');
        $this->db->join("category_main", "category_main.Unique = category_sub.CategoryMainUnique", 'left');
        $this->db->join("item_stock_line isl", "isl.ItemUnique=item.Unique", 'left');
        $this->db->where("item.\"Status\"", 1);
        $this->db->group_by("item.\"Unique\", item.\"Description\", item.\"Item\", item.\"Part\", item.\"SupplierUnique\", supplier.\"Company\", item.\"SupplierPart\", item.\"BrandUnique\", brand.\"Name\",
            category_main.\"Unique\", category_sub.\"Name\", category_sub.\"Unique\", \"CostLanded\", item.\"Cost_Duty\"");
        $this->db->order_by("item.\"Unique\" DESC");
        return $this->db->get()->result_array();

        $sql =
            "SELECT item.\"Unique\", item.\"Description\", item.\"Item\", item.\"Part\", item.\"SupplierUnique\" AS \"SupplierId\", supplier.\"Company\" AS \"Supplier\", item.\"SupplierPart\", item.\"BrandUnique\" AS \"BrandId\", brand.\"Name\" AS \"Brand\",
			item.\"ListPrice\", item.price1, item.price2, item.price3, item.price4, item.price5,
			category_main.\"Unique\" AS \"CatMainId\", category_sub.\"Name\" AS \"Category\", category_sub.\"Unique\" AS \"SubCategory\",
			item.\"Cost\" + item.\"Cost_Extra\" + item.\"Cost_Freight\" + item.\"Cost_Duty\" AS \"CostLanded\",
			item.\"Cost\", item.\"Cost_Extra\", item.\"Cost_Freight\", item.\"Cost_Duty\",
			SUM(isl.\"Quantity\") AS \"Quantity\"
			FROM item
			LEFT JOIN supplier ON item.\"SupplierUnique\" = supplier.\"Unique\"
			LEFT JOIN brand ON item.\"BrandUnique\" = brand.\"Unique\"
			LEFT JOIN category_sub ON item.\"CategoryUnique\" = category_sub.\"Unique\"
			LEFT JOIN category_main on category_main.\"Unique\"=category_sub.\"CategoryMainUnique\"
			LEFT JOIN item_stock_line isl ON isl.\"ItemUnique\"=item.\"Unique\"
			WHERE item.\"Status\"=1
			GROUP BY item.\"Unique\", item.\"Description\", item.\"Item\", item.\"Part\", item.\"SupplierUnique\", supplier.\"Company\", item.\"SupplierPart\", item.\"BrandUnique\", brand.\"Name\",
            category_main.\"Unique\", category_sub.\"Name\", category_sub.\"Unique\", \"CostLanded\", item.\"Cost_Duty\"
			ORDER BY item.\"Unique\" DESC ";

        return $this->db->query($sql)->result_array();
    }

}