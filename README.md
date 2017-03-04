# appsflyer


#### Documentation

[Documentation](https://support.appsflyer.com/hc/en-us)


#### [Pull API](https://support.appsflyer.com/hc/en-us/articles/207034346-Pull-APIs-Pulling-AppsFlyer-Reports-by-APIs)

 - [getting Raw Report Data](https://support.appsflyer.com/hc/en-us/articles/208387843-Raw-Data-Reports-V5-)
  
  Example:
  
  ```php
  $api = new \appsflyer\api\PullApi\RawDataReport($apiKey);
  try {
      $api->setFilters(['from' => '2017-02-27', 'to' => '2017-03-03'])
          ->addBeforeRunCallback(function ($params) {
              var_dump($params);
          })
          ->getInAppEventsReport($idApp);
 
      $arr = $api->returnAsArray();
      var_dump($api->getLastCurlError(), $api->getLastCurlFile());
  } catch (\Exception $e) {
      var_dump($e->getMessage());
  }
  ```