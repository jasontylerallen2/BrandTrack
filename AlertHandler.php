<?php

require_once('BrandTrackDao.php');
$action = $_GET["action"];

$dao = new BrandTrackDao();

if ($action == "Alert") {
    $brandId = $_GET["brandId"];
    $alerts = $dao->getUserBrandAlertsByBrandId($brandId);
    foreach ($alerts as $alert) {
        $alert['run_date'] = date("m/d/Y h:i:s", strtotime($alert['run_date']));
    }
    echo json_encode($alerts);
}
else if ($action == "AlertDetail") {
    $alertId = $_GET["alertId"];
    $alertApps = $dao->getUserAlertAppsByAlertId($alertId);
    
    echo json_encode($alertApps);
}
