<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="BrandTrack.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="BrandAlert.js"></script>
        <title>BrandTrack</title>
    </head>
    <body>
        <?php
            const CLIENT_ID = 1;
            
            require_once("BrandTrackDao.php");
            $dao = new BrandTrackDao();
            
            $clientName = $dao->getClientNameById(CLIENT_ID);
        ?>
        <h1 class="title"> <?php echo $clientName ?> </h1>
        
        <div id="main_content">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Brand</th>
                        <th>Last Run Date/Time</th>
                        <th>Last Run Duration</th>
                        <th>Last Run # Added Apps</th>
                        <th>Last Run # Removed Apps</th>
                        <th>Last Run Total Apps</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $brands = $dao->getBrandsByClientParentId(0);
                    
                    foreach ($brands as $brand) {

                        $brandName = $brand['title'];

                        $alertAndRun = $dao->getLastAlertAndRunTimeByBrandId($brand['brand_id']);
                        $runDate = $alertAndRun['run_date'];
                        $formattedDate = date("m/d/Y h:i:s", strtotime($runDate));
                        
                        $appsAdded = $alertAndRun['apps_added_num'];
                        $appsRemoved = $alertAndRun['apps_removed_num'];
                        $totalApps = $alertAndRun['total_apps'];

                        $endTimeSeconds = strtotime($alertAndRun['end_time']);
                        $startTimeSeconds = strtotime($alertAndRun['start_time']);
                        $runDurationMinutes = ($endTimeSeconds - $startTimeSeconds) / 60;

                        $overviewHTML = <<<HTML
                            <tr>
                                <td>{$clientName}</td>
                                <td><button type="button" id="brand_link_{$brand['brand_id']}" class="btn btn-link brand_link">{$brandName}</button></td>
                                <td>{$formattedDate}</td>
                                <td>{$runDurationMinutes} min</td>
                                <td>{$appsAdded}</td>
                                <td>{$appsRemoved}</td>
                                <td>{$totalApps}</td>
                            </tr>
HTML;
                        echo $overviewHTML;
                    }
                ?>
                </tbody>
            </table>
            
            <div id="alert_and_detail_content">
                <h3 id="alert_and_detail_content_header" class="title"></h3>
                <table id="alert_table" class="table table-hover table-striped alert_table"></table>
            </div>
            
        </div>
    </body>
</html>
