<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 *
 */

require __DIR__ . "/../src/appsflyer/api/BaseApi.php";
require __DIR__ . "/../src/appsflyer/api/PullApi/BasePullApi.php";
require __DIR__ . "/../src/appsflyer/api/PullApi/RawDataReport.php";
$apiKey = "b3934228-d9fb-4b64-aefe-992281e4cda0";
$apiKey = "b3934228-d9fb-4b64-aefe-992281e4cda0";
$api = new \appsflyer\api\PullApi\RawDataReport($apiKey);
try {
    $api->setFilters(['from' => '2017-02-27', 'to' => '2017-03-03'])
        ->addBeforeRunCallback(function ($params) {
            var_dump($params);
        })
        ->getInAppEventsReport("id1151406354");

    $arr = $api->returnAsArray();
    var_dump($arr);
    $api->resetCurl();
    var_dump($api->getLastCurlError(), $api->getLastCurlFile());
} catch (\Exception $e) {
    var_dump($e->getMessage());
}

