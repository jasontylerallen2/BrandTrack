<?php

require_once('BrandTrackDao.php');
$action = $_GET["action"];

$dao = new BrandTrackDao();

if ($action == "Alert") {
    $brandId = $_GET["brandId"];
    $alertAndRun = $dao->getLastAlertAndRunTimeByBrandId($brandId);
    $ret = array(
                "alertId" => $alertAndRun['alert_id'],
                 "date" => $alertAndRun['run_date'],
                 "numApps" => $alertAndRun['total_apps']
            );
    echo json_encode($ret);
}
else if ($action == "AlertDetail") {
    $alertId = $_GET["alertId"];
    $alertApps = $dao->getUserAlertAppsByAlertId($alertId);
    
    echo json_encode($alertApps);
}
