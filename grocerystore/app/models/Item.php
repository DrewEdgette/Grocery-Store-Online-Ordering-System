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

        // sets an item's quantity
        public function setQuantity($data) {
            if (!($data["new_quantity"] == Null)) {
                $this->db->query("UPDATE items SET item_quantity = :quantity WHERE item_id = :id;");
                $this->db->bind(":quantity", $data["new_quantity"]);
                $this->db->bind(":id", $data["itemID"]);
            
                return $this->db->execute();
            }

            return false;
        }


}