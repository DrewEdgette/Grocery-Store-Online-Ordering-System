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

}
