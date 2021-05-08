<?php
    class Item {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        // searches database for requested item
        public function getSearchResults($data) {
            $this->db->query("SELECT * FROM items WHERE item_name LIKE CONCAT('%', :query, '%');");
            $this->db->bind(":query", $data["query"]);

            return $this->db->resultSet();
        }

        public function getLowStockItems() {
            $this->db->query("SELECT * FROM items WHERE item_quantity < 6 ORDER BY item_quantity ASC;");
            return $this->db->resultSet();
        }


        // gets item by id
        public function getItem($id) {
            $this->db->query("SELECT * FROM items WHERE item_id = :item_id");
            $this->db->bind(":item_id", $id);

            return $this->db->single();
        }

         // gets featured items
         public function getFeaturedItems() {
            $this->db->query("SELECT * FROM items WHERE featured = 'true';");

            return $this->db->resultSet();
        }

        // updates an item's values
        public function updateItem($id, $column, $value) {
            $this->db->query("UPDATE items SET " . $column . " = :value WHERE item_id = :id;");
            $this->db->bind(":value", $value);
            $this->db->bind(":id", $id);
        
            return $this->db->execute();
        }


        // gets specific order by its id
        public function getItemList($orderID) {
            $this->db->query("SELECT * FROM order_details INNER JOIN items ON items.item_id = order_details.item_id HAVING order_id = :order_id;");
            $this->db->bind(":order_id", $orderID);

            return $this->db->resultSet();
        }


        // sets an item's featured value by id
        public function setFeatured($id, $value) {
            $this->db->query("UPDATE items SET featured = :value WHERE item_id = :id;");
            $this->db->bind(":value", $value);
            $this->db->bind(":id", $id);
            
            return $this->db->execute();
        }

}