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
          to_char(date_trunc(\'minutes\', item_count."Updated"::timestamp), \'MM/DD/YYYY HH:MI AM\')  as "_Updated",
          to_char(date_trunc(\'minutes\', item_count."CountDate"::timestamp), \'MM/DD/YYYY\') as "CountDateFormatted",
          date_trunc(\'minutes\', item_count."CountDate"::timestamp) as "_CountDate",
          (select count("Unique") from item_count_list icl where icl."CountUnique" = item_count."Unique")
            as "hasCountList",
            case when item_count."Status" = 1 then \'In Progress\'
                 when item_count."Status" = 2 then \'Complete\' 
                 else \'Other\'
            end as "StatusName",
          ', false);
        $this->db->from('item_count');
        $this->db->join('config_location cl', 'cl.Unique = item_count.Location', 'left');
        $this->db->join('config_user cu1', 'cu1.Unique = item_count.CreatedBy', 'left');
        $this->db->join('config_user cu2', 'cu2.Unique = item_count.UpdatedBy', 'left');
        $this->db->where('item_count.Status!=', 0);
        $this->db->order_by('item_count.Created', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getLists($id)
    {
        $where = '';
        if (!is_null($id)) {
            $where = " AND icl.\"CountUnique\" = " . $id;
        }
        $orderby = " ORDER BY icl.\"Unique\" DESC";
        //
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
            WHERE ic.\"Status\" != 0 " . $where . $orderby
        ;

        return $this->db->query($query)->result_array();
    }

    public function create($data, $filters = null) {
        $data['Station'] = $data['Location'];
        $data['Status'] = 1;
        $data['Created'] = date('Y-m-d H:i:s');
        $data['CreatedBy'] = $this->session->userdata('userid');

        $this->db->insert('item_count', $data);
        $id = $this->db->insert_id();
        $this->insert_count_list($id, $data['Location'], $filters);

        return $id;
    }

    public function update($id, $data) {
        $data['Updated'] = date('Y-m-d H:i:s');
        $data['UpdatedBy'] = $this->session->userdata('userid');

        $this->db->where('Unique', $id);
        return $this->db->update('item_count', $data);
    }

    public function delete($id) {
        $updated = date('Y-m-d H:i:s');
        $updatedBy = $this->session->userdata('userid');
        $this->db->trans_start();
        $this->db->where('Unique', $id);
        $status = $this->db->update('item_count',
                ['Status' => 0,
                'Updated' => $updated,
                'UpdatedBy' => $updatedBy,
                ]);
        $this->db->trans_complete();
        //
        $this->db->trans_start();
        $this->db->where('CountUnique', $id);
        $this->db->update('item_count_list', [
            'Updated' => $updated,
            'UpdatedBy' => $updatedBy,
            'Status' => 0
            ]);
        $this->db->trans_complete();
        // UPDATE item_stock_line
        $this->db->trans_start();
        $row = $this->db->query("SELECT \"Status\" from item_count where \"Unique\"={$id}")->row_array();
        if ($row['Status'] == 2) {
            $this->db->where('CountUnique', $id);
//            $status = $this->db->delete('item_stock_line');
            $this->db->update('item_stock_line', [
                'Updated' => $updated,
                'UpdatedBy' => $updatedBy,
                'Status' => 0
            ]);

        }
        $this->db->trans_complete();


        return $status;
    }

    public function insert_count_list($countID, $locationID, $filters = null)    {
        $id = $this->session->userdata('userid');
        //
        $whereInM = $whereInC = $whereInS = '';
        if (!is_null($filters)) {
            if (isset($filters['MainCategory'])) {
                $whereInM .= " AND IT.\"MainCategory\" = ". $filters['MainCategory'];
            }
            if (isset($filters['SubCategory'])) {
                $filters['SubCategory'] = implode(',', $filters['SubCategory']);
                $whereInC .= " AND IT.\"CategoryUnique\" IN (".  $filters['SubCategory'] . ')';
            }
            if (isset($filters['SupplierUnique'])) {
                $filters['SupplierUnique'] = implode(',', $filters['SupplierUnique']);
                $whereInS .= " AND IT.\"SupplierUnique\" IN (". implode(',', $filters['SupplierUnique']) . ')';
            }
            $this->db->trans_start();
            $filters['Status'] = 1;
            $filters['CountUnique'] = $countID;
            $filters['Created'] = date('Y-m-d H:i:s');
            $filters['CreatedBy'] = $id;
            $this->db->insert('item_count_filter', $filters);
            $this->db->trans_complete();
        }
        $query = "
            insert into item_count_list (\"CountUnique\",\"ItemUnique\",\"Item\",\"Part\",\"Description\",\"Category\",     
                        \"SubCategory\",\"Supplier\",\"SupplierPart\",\"Cost\",
                         \"CurrentStock\",\"CountStock\",\"Difference\", \"Status\", \"CreatedBy\")
              (select ". $countID ." as \"CountUnique\", IT.\"Unique\" as \"ItemUnique\", trim(IT.\"Item\") as \"Item\",
               trim(IT.\"Part\") as \"Part\", trim(IT.\"Description\") as \"Description\", 
               trim(CM.\"MainName\") as \"Category\", trim(CS.\"Name\") as \"SubCategory\",
               trim(SU.\"Company\") as \"Supplier\",trim(IT.\"SupplierPart\") as \"SupplierPart\",
               (IT.\"Cost\"::numeric + IT.\"Cost_Extra\"::numeric + IT.\"Cost_Freight\"::numeric + IT.\"Cost_Duty\"::numeric) as \"Cost\",
               ST.\"CurrentStock\" as \"CurrentStock\", null as \"CountStock\", null as \"Difference\",
                1 as \"Status\", ". $id ." as \"CreatedBy\"
              from item IT
              left join category_main CM on CM.\"Unique\" = IT.\"MainCategory\"
              left join category_sub CS on CS.\"Unique\" = IT.\"CategoryUnique\"
              left join supplier SU on SU.\"Unique\" = IT.\"SupplierUnique\"
              left join 
                (select \"ItemUnique\",sum(\"Quantity\") as \"CurrentStock\" from item_stock_line
                    where \"status\" = 1 and \"LocationUnique\" = ". $locationID ." group by \"ItemUnique\") ST
                on ST.\"ItemUnique\" = IT.\"Unique\"
              where IT.\"Status\" = 1
              ". $whereInM.$whereInC.$whereInS.")
        ";
        return $this->db->query($query);
    }

    public function update_count_list($id, $data) {
        $data['Updated'] = date('Y-m-d H:i:s');
        $data['UpdatedBy'] = $this->session->userdata('userid');

        $this->db->where('Unique', $id);
        return $this->db->update('item_count_list', $data);
    }

    public function finalize_count_list($countID) {
        // TODO missing ICL."Cost" as "Cost", after TransactionDate
        $sql = "(
            select ICL.\"ItemUnique\",IC.\"Location\" as \"LocationUnique\", 4 as \"Type\", ICL.\"Difference\" as \"Quantity\",
            ICL.\"CreatedBy\" as \"CreatedBy\", now() as \"Created\", IC.\"CountDate\" as \"TransactionDate\",
            ICL.\"Comment\" as \"Comment\", 
            IC.\"CountDate\"::date as \"trans_date\",
            1 as \"status\", ICL.\"Unique\" as \"CountUnique\"
            from item_count IC
            join item_count_list ICL on IC.\"Unique\" = ICL.\"CountUnique\"
            where ICL.\"CountUnique\" = {$countID}
             and ICL.\"CountStock\" is not null)"; // and "Difference" is not null

        $insert = "
          insert into item_stock_line(\"ItemUnique\",\"LocationUnique\",\"Type\",\"Quantity\",\"CreatedBy\",\"Created\",     
                        \"TransactionDate\",\"Comment\",\"trans_date\", \"status\", \"CountUnique\") " . $sql;
        $this->db->trans_start();
        $status = $this->db->query($insert);
        $this->db->trans_complete();
        if ($status) {
            $this->db->trans_start();
            $this->db->update('item_count', ['Status' => 2,
                'Updated' => date('Y-m-d H:i:s'),
                'UpdatedBy' => $this->session->userdata('userid'),
            ], ['Unique' => $countID]);
            $this->db->trans_complete();
            $this->db->trans_start();
            $this->db->update('item_count_list', ['Status' => 2], ['CountUnique' => $countID]);
            $this->db->trans_complete();
        }
        return $status;
    }

}