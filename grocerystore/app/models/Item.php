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
            $this->db->query("SELECT * FROM items WHERE item_quantity > 0 ORDER BY RAND() LIMIT 5;");

            return $this->db->resultSet();
        }

        // updates an item's values
        public function updateItem($id, $column, $value) {
            $this->db->query("UPDATE items SET " . $column . " = :value WHERE item_id = :id;");
            $this->db->bind(":value", $value);
            $this->db->bind(":id", $id);
        
            return $this->db->execute();
        }

}