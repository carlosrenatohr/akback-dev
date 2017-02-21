<?php

/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 05-19-16
 * Time: 02:59 PM
 */
class Menu_item_model extends CI_Model
{
    private $itemTable = 'item';
    private $menuItemTable = 'config_menu_items';
    private $questionsItemTable = 'item_questions';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function getItems($sort = null, $search = null)
    {
        $this->db->select('item.Unique, item.Description, item.Item, item.Status, item.ListPrice, item.price1,
                        category_sub.Name as SubCategory, category_main.MainName as Category');
        $this->db->from($this->itemTable);
        $this->db->where(['item.Status!=' => 0]);
        $this->db->where(['item.Description!=' => '']);
        if (!is_null($search)) {
            if(empty($search)) {
                $this->db->limit(1000);
            } else {
                $this->db->where('LOWER("item"."Description") like \'%' . strtolower($search) . '%\'', null);
            }
        }
        $this->db->join("category_sub", "item.CategoryUnique = category_sub.Unique", 'left');
        $this->db->join("category_main", "category_main.Unique = item.MainCategory", 'left');
        $this->db->order_by('item.Description', (!is_null($sort)) ? $sort : 'DESC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getItemByPosition($request)
    {
        $this->db->select('item.*, item.Label as ItemLabelVal, config_menu_items.Status as LayoutStatus,
                    config_menu_items.Unique as MenuItemUnique,
                    config_menu_items.MenuCategoryUnique, config_menu_items.Label,
                    config_menu_items.Sort, config_menu_items.Column,config_menu_items.Row,
                    config_menu_items.ButtonPrimaryColor, config_menu_items.ButtonSecondaryColor,
                    config_menu_items.LabelFontColor, config_menu_items.LabelFontSize');
        $this->db->from('config_menu_items');
        $this->db->where('config_menu_items.Status>', 0);
        $this->db->where($request);
        $this->db->join('item', 'config_menu_items.ItemUnique = item.Unique');

        $result = $this->db->get()->row_array();
        return $result;
    }

    public function getItemsByCategoryMenu($id)
    {
        $this->db->select('item.Description, item.price1 as SellPrice, config_menu_items.*');
        $this->db->from($this->menuItemTable);
        $this->db->join('item', 'item.Unique = config_menu_items.ItemUnique');
        $this->db->where('config_menu_items.MenuCategoryUnique', $id);
//        $this->db->where('config_menu_items.Status!=', 0);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function postItemByMenu($request)
    {
        $posRow = (isset($request['posRow'])) ? $request['posRow'] : $request['Row'];
        $posCol = (isset($request['posCol'])) ? $request['posCol'] : $request['Column'];
        if (isset($request['posCol']) && isset($request['posRow'])) {
            unset($request['posRow']);
            unset($request['posCol']);
        }
        $where = [
            'MenuCategoryUnique' => $request['MenuCategoryUnique'],
            'Column' => $posCol,
            'Row' => $posRow
        ];
        $exists = $this->db->where($where)
            ->get($this->menuItemTable)->result_array();
        if (count($exists) || isset($request['posRow'])) {
            $request['Updated'] = date('Y-m-d H:i:s');
            $request['UpdatedBy'] = $this->session->userdata('userid');
            $this->db->where($where);
            $return = $this->db->update($this->menuItemTable, $request);
        } else {
//            $request['Status'] = 1;
            $request['Created'] = date('Y-m-d H:i:s');
            $request['CreatedBy'] = $this->session->userdata('userid');
            $return = $this->db->insert($this->menuItemTable, $request);
        }
        return $return;
    }

    public function deleteMenuItem($request)
    {
        $this->db->where($request);
        $return = $this->db->delete($this->menuItemTable);
        return $return;
    }

    public function verifyBusyPosition($row, $column, $category)
    {
        $this->db->where(
            [
                'Row' => $row,
                'Column' => $column,
                'MenuCategoryUnique' => $category,
                'Status>' => 0,
                'ItemUnique!=' => null
            ]
        );
        $count = $this->db->get($this->menuItemTable)->result_array();
        return count($count);
    }

    public function setNewPosition($category, $element, $target)
    {
        //
        $this->db->trans_start();
        $exists = $this->db->where('MenuCategoryUnique', $category)
            ->where($target)
            ->get($this->menuItemTable)->result_array();
        $this->db->trans_complete();
        //
        $targetValues = array_merge(
            [
                'Updated' => date('Y-m-d H:i:s'),
                'UpdatedBy' => $this->session->userdata('userid')
            ],
            $target
        );
        $elementValues = array_merge(
            [
                'Updated' => date('Y-m-d H:i:s'),
                'UpdatedBy' => $this->session->userdata('userid')
            ],
            $element
        );
        //
        $this->db->trans_start();
        $query = $this->db->where('MenuCategoryUnique', $category)
            ->where($element)
            ->update($this->menuItemTable, $targetValues);
        $this->db->trans_complete();
        /**
         * Target
         */
        if (count($exists)) {
            $target_id = $exists[0]['Unique'];
            $this->db->trans_start();
            $this->db->where('Unique', $target_id)
                ->update($this->menuItemTable, $elementValues);
            $this->db->trans_complete();
        }
        return count($exists);
    }

    /**
     * Queries for item_questions table
     */
    public function getAllItemQuestions($itemId = null)
    {
        $this->db->select("{$this->questionsItemTable}.*, item.Description as ItemName, config_questions.QuestionName");
        $this->db->join('config_questions', "config_questions.Unique = {$this->questionsItemTable}.QuestionUnique");
        $this->db->join($this->itemTable, "{$this->questionsItemTable}.ItemUnique = item.Unique");
        if (!is_null($itemId)) {
            $this->db->where('ItemUnique', $itemId);
        }
        $this->db->order_by('Sort', 'ASC');
        $query = $this->db->get($this->questionsItemTable);
        return $query->result_array();
    }

    public function postItemQuestion($request)
    {
        $request['Created'] = date('Y-m-d H:i:s');
        $request['CreatedBy'] = $this->session->userdata('userid');
        $status = $this->db->insert($this->questionsItemTable, $request);
        $insert_id = $this->db->insert_id();
        //
        $this->countQuestionsByItem($request['ItemUnique']);
        return $status;
    }

    public function updateItemQuestion($id, $request)
    {
        $request['Updated'] = date('Y-m-d H:i:s');
        $request['UpdatedBy'] = $this->session->userdata('userid');
        $this->db->where('Unique', $id);
        $query = $this->db->update($this->questionsItemTable, $request);
        //
        $this->countQuestionsByItem($request['ItemUnique']);
        return $query;
    }

    public function deleteItemQuestion($id)
    {
        $this->db->trans_start();
        $questionItem = $this->db->get_where($this->questionsItemTable, ['Unique' => $id])->result_array();
        $this->db->trans_complete();
        $itemUnique = $questionItem[0]['ItemUnique'];
        //
        $this->db->trans_start();
        $this->db->where('Unique', $id);
        $query = $this->db->delete($this->questionsItemTable);
        $this->db->trans_complete();
        //
        $this->countQuestionsByItem($itemUnique);
        return $query;
    }

    private function countQuestionsByItem($itemId) {
        $this->db->where('ItemUnique', $itemId);
        $count = $this->db->get($this->questionsItemTable)->result_array();
        if (count($count)) {
            $hasQuestions = ['Question' => '1'];
        } else {
            $hasQuestions = ['Question' => null];
        }
        $this->db->trans_start();
        $this->db->where('Unique', $itemId);
        $this->db->update($this->itemTable, $hasQuestions);
        $this->db->trans_complete();
    }

    public function getPicturesByItem($itemID) {
        $this->db->select('File, Description, Primary, Sort');
        $this->db->from('item_picture');
        $this->db->where('ItemUnique', $itemID);
        $this->db->where('Status', 1);
        return $this->db->get()->result_array();
    }

    public function savePicturesByItem($pictures_str, $itemID) {
        if (!empty($pictures_str)) {
            $pictures = explode(',', $pictures_str);
            $this->db->update('item_picture',
                ['Status' => 0],
                ['ItemUnique' => $itemID]);
            foreach ($pictures as $idx => $picture) {
                $request = [
                    'ItemUnique' => $itemID,
                    'File' => $picture,
                    'Description' => '',
                    'Primary' => ($idx == 0) ? 1 : 0,
                    'Sort' => $idx + 1,
                    'Created' => date('Y-m-d H:i:s'),
                    'CreatedBy' => $this->session->userdata('userid')
                ];
                $this->db->insert('item_picture', $request);
            }
        } else {
            $this->db->delete('item_picture', ['ItemUnique' => $itemID]);
        }
    }


}