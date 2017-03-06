<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 *
 */

$apiKey = isset($argv[1]) ? $argv[1] : null;
if(!$apiKey){
    echo "No api key\n";
    exit();
}

require __DIR__ . "/../src/appsflyer/api/BaseApi.php";
require __DIR__ . "/../src/appsflyer/api/PullApi/BasePullApi.php";
require __DIR__ . "/../src/appsflyer/api/PullApi/RawDataReport.php";

$api = new \appsflyer\api\PullApi\RawDataReport($apiKey);
$file = __DIR__.'/../src/tmp/id1151406354_non_organic_in_app_events_2017-02-27_2017-03-03_IZLPA.csv';

try {
    $api->setLastCurlFile($file);
    $api->setTmpFileName("testname");

    $arr = $api->getCsvAsArray();
    $map = $api->mapCsvArrayToColumns($arr);
    var_dump($map);
    //    var_dump($arr);
    //    $api->resetCurl();
//    var_dump($api->getLastCurlError(), $api->getLastCurlFile());
} catch (\Exception $e) {
    var_dump($api->getLastCurlResponse());
    var_dump($e->getMessage());
}