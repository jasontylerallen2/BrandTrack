<?php

class BrandTrackDao {

    private $host = "localhost";
    private $db = "brandwatch";
    private $user = "jallen";
    private $pass = "password";

    public function getConnection() {
        return new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
    }
    
    public function getClientNameById($id) {
        $conn = $this->getConnection();
        $getQuery = "SELECT name FROM clients WHERE client_id = :id";
        $q = $conn->prepare($getQuery);
        $q->execute(array(":id" => $id));
        return $q->fetchColumn();
    }
    
    public function getBrandsByClientParentId($parentId) {
        $conn = $this->getConnection();
        $getQuery = "SELECT * FROM user_brand WHERE asset_id = :parent_id";
        $q = $conn->prepare($getQuery);
        $q->execute(array(":parent_id" => $parentId));
        return $q->fetchAll();
    }
    
    public function getLastAlertAndRunTimeByBrandId($brandId) {
        $conn = $this->getConnection();
        $getQuery = <<<SQL
                SELECT * FROM user_brand_alert alert
                JOIN user_brandwatch_run run
                WHERE alert.alert_id = run.alert_id
                AND alert.brand_id = :brand_id
                ORDER BY end_time DESC LIMIT 1
SQL;
        $q = $conn->prepare($getQuery);
        $q->execute(array(":brand_id" => $brandId));
        return $q->fetch();
    }
    
    public function getUserAlertAppsByAlertId($alertId)
    {
        $conn = $this->getConnection();
        $getQuery = "SELECT app_url, status FROM user_brand_alert_apps WHERE alert_id = :alert_id";
        $q = $conn->prepare($getQuery);
        $q->execute(array(":alert_id" => $alertId));
        return $q->fetchAll();
    }

}
