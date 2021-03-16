<?php
    class Item {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        // creates new user in database and then returns true or false
        public function getSearchResults($data) {
            $this->db->query("SELECT * FROM items WHERE item_name LIKE CONCAT('%', :query, '%');");
            $this->db->bind(":query", $data["query"]);

            return $this->db->resultSet();
        }

}