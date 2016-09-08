<?php

class Item_model extends CI_Model
{

    public function update($id, $request)
    {
        $this->db->where('Unique', $id);
        return $this->db->update('item', $request);
    }

    public function getItemsData() {
        $this->db->select("item.Unique, item.Description, item.Item, item.Part,
            item.SupplierUnique AS SupplierId, supplier.Company AS Supplier, item.SupplierPart,
            item.BrandUnique AS BrandId, brand.Name AS Brand,
			item.ListPrice, item.price1, item.price2, item.price3, item.price4, item.price5,
			category_main.Unique AS CategoryId, category_main.MainName AS Category,
			category_sub.Name AS SubCategory, category_sub.Unique AS SubCategoryId,
			item.Cost, item.Cost_Extra, item.Cost_Freight, item.Cost_Duty,
			(item.\"Cost\" + item.\"Cost_Extra\" + item.\"Cost_Freight\" + item.\"Cost_Duty\") AS \"CostLanded\",
			SUM(isl.\"Quantity\") AS Quantity,
			item.PromptPrice, item.PromptDescription, item.EBT, item.GiftCard, item.Group,
			item.MinimumAge, item.CountDown, item.Points");
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
            "SELECT item.\"Unique\", item.\"Description\", item.\"Item\", item.\"Part\",
            item.\"SupplierUnique\" AS \"SupplierId\", supplier.\"Company\" AS \"Supplier\", item.\"SupplierPart\",
            item.\"BrandUnique\" AS \"BrandId\", brand.\"Name\" AS \"Brand\",
			item.\"ListPrice\", item.price1, item.price2, item.price3, item.price4, item.price5,
			category_main.\"Unique\" AS \"CategoryId\", category_sub.\"Unique\" AS \"SubCategoryId\",
			category_main.\"MainName\" AS \"Category\", category_sub.\"Name\" AS \"SubCategory\",
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
			GROUP BY item.\"Unique\", item.\"Description\", item.\"Item\", item.\"Part\", item.\"SupplierUnique\",
			  supplier.\"Company\", item.\"SupplierPart\", item.\"BrandUnique\", brand.\"Name\",
              category_main.\"Unique\", category_sub.\"Name\", category_sub.\"Unique\",
              \"CostLanded\", item.\"Cost_Duty\"
			ORDER BY item.\"Unique\" DESC ";

        return $this->db->query($sql)->result_array();
    }

    public function getSupplierList() {
        $this->db->select("Unique, Company");
        $this->db->from("supplier");
        $this->db->where(["Company!=" => '', 'Status!=' => null]);
        $this->db->order_by("Company ASC");
        return $this->db->get()->result_array();
    }

    public function getBrandList() {
        $this->db->select("Unique, Name");
        $this->db->order_by("Name ASC");
        return $this->db->get("brand")->result_array();
    }

    public function getCategoryList() {
        $this->db->select("Unique, MainName");
        $this->db->order_by("MainName ASC");
        return $this->db->get("category_main")->result_array();
    }

    public function getSubcategoryList($id = null) {
        $this->db->select("Unique, Name");
        if (!is_null($id))
            $this->db->where("CategoryMainUnique", $id);
        $this->db->order_by("Name asc");
        return $this->db->get("category_sub")->result_array();
    }

    public function saveItem($request) {
        $extra_fields = [
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $status = $this->db->insert('item', $data);
        return $this->db->insert_id();
    }

    public function updateItem($id, $request) {
        $extra_fields = [
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $this->db->where('Unique', $id);
        $status = $this->db->update('item', $data);
        return $status;
    }

    /**
     * @description Barcode list
     * @param null $id
     * @return mixed
     */
    public function getBarcodesByItem($id = null) {
        $this->db->select('Unique, Barcode');
        $this->db->from('item_barcode');
        if (!is_null($id))
            $this->db->where('ItemUnique', $id);
        $this->db->where('Barcode!=', '');
        $this->db->where('Status', 1);
        $this->db->order_by('Created DESC');
        return $this->db->get()->result_array();
    }

    public function saveItemBarcode($request) {
        $extra_fields = [
            'Status' => 1,
            'Created' => date('Y-m-d H:i:s'),
            'CreatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $status = $this->db->insert('item_barcode', $data);
        return $this->db->insert_id();
    }

    public function updateItemBarcode($id, $request) {
        $extra_fields = [
            'Updated' => date('Y-m-d H:i:s'),
            'UpdatedBy' => $this->session->userdata('userid')
        ];
        $data = array_merge($request, $extra_fields);
        $this->db->where('Unique', $id);
        return $this->db->update('item_barcode', $data);
    }

    public function deleteItemBarcode($id) {
        $this->db->where('Unique', $id);
        return $this->db->delete('item_barcode');
    }

    /**
     * @description Taxes item actions
     * @return mixed
     */
    public function getTaxList() {
        return $this->db->get_where("config_tax", ["Status" => "1"])->result_array();
    }

    public function verifyTaxByItem($itemId, $taxId) {
        $isTaxed = $this->db->get_where('item_tax',
            ['ItemUnique' => $itemId, 'TaxUnique' => $taxId, 'Status' => 1])->result_array();

        return count($isTaxed);
    }

    public function updateTaxesByItem($taxesArray = []) {
        foreach($taxesArray as $group) {
            $this->db->trans_start();
            $itemTaxFound = $this->db->get_where('item_tax',
                ['ItemUnique' => $group['ItemUnique'], 'TaxUnique' => $group['TaxUnique']])
                ->row_array();
            $this->db->trans_complete();
            //
            $this->db->trans_start();
            if(!is_null($itemTaxFound['Unique'])) {
                $extra_fields = [
                    'Status' => ($group['Status'] == 'true') ? 1 : 0,
                    'Updated' => date('Y-m-d H:i:s'),
                    'UpdatedBy' => $this->session->userdata('userid')
                ];
                $this->db->where('Unique', $itemTaxFound['Unique']);
                $this->db->update('item_tax', $extra_fields);
            } else {
                $extra_fields = [
                    'Status' => ($group['Status'] == 'true') ? 1 : 0,
                    'Created' => date('Y-m-d H:i:s'),
                    'CreatedBy' => $this->session->userdata('userid')
                ];
                $data = array_merge($group, $extra_fields);
                $this->db->insert('item_tax', $data);
            }
            $this->db->trans_complete();
        }
    }

    public function getStockItemByLocation($id, $location = null) {
        $locationQuery = ($location == 0) ? "" : " AND a.\"LocationUnique\"=".$location;
        $sql = "SELECT  a.\"Unique\", a.\"ItemUnique\", a.\"LocationUnique\",  a.\"Quantity\", a.\"TransactionDate\", a.\"Comment\", b.\"LocationName\", c.\"Description\",
			SUM(a.\"Quantity\") OVER (PARTITION BY a.\"LocationUnique\" ORDER BY a.\"TransactionDate\",a.\"Unique\") as \"Total\"
			FROM item_stock_line a, config_location b, item_types c
			WHERE a.\"LocationUnique\"=b.\"Unique\"
			AND a.\"Type\"=c.\"Unique\"
			AND a.\"ItemUnique\" = ".$id." {$locationQuery}
			ORDER BY a.\"TransactionDate\" DESC, a.\"Unique\" DESC";
        return $this->db->query($sql)->result_array();
    }

}