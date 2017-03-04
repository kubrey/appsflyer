<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 * Set api key as cli argument
 * eg >php api_pull_raw_data_report.php api_key
 */
$apiKey = isset($argv[1]) ? $argv[1] : null;
if(!$apiKey){
    echo "No api key\n";
    exit();
}
var_dump($apiKey);
require __DIR__ . "/../src/appsflyer/api/BaseApi.php";
require __DIR__ . "/../src/appsflyer/api/PullApi/BasePullApi.php";
require __DIR__ . "/../src/appsflyer/api/PullApi/RawDataReport.php";

$api = new \appsflyer\api\PullApi\RawDataReport($apiKey);
try {
    $api->setFilters(['from' => '2017-02-27', 'to' => '2017-03-03'])
        ->addBeforeRunCallback(function ($params) {
            var_dump($params);
        })
        ->getInAppEventsReport("id1151406354");

    $arr = $api->returnAsArray();
//    var_dump($arr);
//    $api->resetCurl();
    var_dump($api->getLastCurlError(), $api->getLastCurlFile());
} catch (\Exception $e) {
    var_dump($api->getLastCurlResponse());
    var_dump($e->getMessage());
}

