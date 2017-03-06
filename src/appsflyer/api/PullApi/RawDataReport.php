<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 *
 */

namespace appsflyer\api\PullApi;

/**
 * @see https://support.appsflyer.com/hc/en-us/articles/208387843-Raw-Data-Reports-V5-
 * Class RawDataReport
 * @package appsflyer\api\PullApi
 */
class RawDataReport extends BasePullApi
{
    const IN_APP_EVENTS_REPORT = 'in_app_events_report';

    public function getInAppEventsReport($applicationId) {
        $this->setApplicationId($applicationId)
            ->setAction(static::IN_APP_EVENTS_REPORT)
            ->setFileMethod()
            ->setTmpFileName(static::IN_APP_EVENTS_REPORT . "_" . uniqid() . ".csv")
            ->run();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getCsvAsArray() {
        if (!$this->tmpFileName || !$this->lastCurlFile) {
            throw new \Exception("No file");
        }

        $csvRows = [];
        if (($handle = fopen($this->lastCurlFile, "r")) !== false) {
            while (($row = fgetcsv($handle, 0, ",")) !== false) {
                $csvRows[] = $row;
            }
            fclose($handle);
        }
        return $csvRows;
    }

    /**
     * @param $csvArray
     * @return array
     */
    public function mapCsvArrayToColumns($csvArray) {
        if (!$csvArray) {
            return [];
        }
        $columns = static::getColumns();
        $headRow = $csvArray[0];
        $mappedArray = [];
        foreach ($csvArray as $index => $row) {
            $mappedRow = [];
            if ($index == 0) {
                //passing through titles
                continue;
            }
            foreach ($row as $cellIndex => $value) {
                $columnTitle = $headRow[$cellIndex];
                if (!$columnTitle) {
                    //this should not happen
                    continue;
                }
                $innerTitle = array_search($columnTitle, $columns);
                if (!$innerTitle) {
                    //this should not happen either
                    continue;
                }
                $mappedRow[$innerTitle] = $value;

            }
            $mappedArray[] = $mappedRow;
        }
        return $mappedArray;
    }

    /**
     * @param int $version
     * @return array
     */
    public static function getColumns($version = 5) {
        $columns['v5'] = [
            'attributed_touch_type' => 'Attributed Touch Type',
            'attributed_touch_time' => 'Attributed Touch Time',
            'install_time' => 'Install Time',
            'af_prt' => 'Partner',
            'media_source' => 'Media Source',
            'is_retargeting' => 'Is Retargeting',
            'retargeting_conversion_type' => 'Retargeting Conversion Type',
            'af_channel' => 'Channel',
            'af_keywords' => 'Keywords',
            'campaign' => 'Campaign',
            'af_c_id' => 'Campaign ID',
            'af_adset' => 'Adset',
            'af_adset_id' => 'Adset ID',
            'af_ad' => 'Ad',
            'af_ad_id' => 'Ad ID',
            'af_ad_type' => 'Ad Type',
            'af_site_id' => 'Site ID',
            'af_sub1' => 'Sub Param 1',
            'af_sub2' => 'Sub Param 2',
            'af_sub3' => 'Sub Param 3',
            'af_sub4' => 'Sub Param 4',
            'af_sub5' => 'Sub Param 5',
            'http_referrer' => 'HTTP Referrer',
            'original_url' => 'Original URL',
            'user_agent' => 'User Agent',
            'af_cost model' => 'Cost Model',
            'af_cost_value' => 'Cost Value',
            'af_cost currency' => 'Cost Currency',
            'contributor1_af_prt' => 'Contributor 1 Partner',
            'contributor1_media_source' => 'Contributor 1 Media Source',
            'contributor1_campaign' => 'Contributor 1 Campaign',
            'contributor1_touch_type' => 'Contributor 1 Touch Type',
            'contributor1_touch_time' => 'Contributor 1 Touch Time',
            'contributor2_af_prt' => 'Contributor 2 Partner',
            'contributor2_media_source' => 'Contributor 2 Media Source',
            'contributor2_campaign' => 'Contributor 2 Campaign',
            'contributor2_touch_type' => 'Contributor 2 Touch Type',
            'contributor2_touch_time' => 'Contributor 2 Touch Time',
            'contributor3_af_prt' => 'Contributor 3 Partner',
            'contributor3_media_source' => 'Contributor 3 Media Source',
            'contributor3_campaign' => 'Contributor 3 Campaign',
            'contributor3_touch_type' => 'Contributor 3 Touch Type',
            'contributor3_touch_time' => 'Contributor 3 Touch Time',
            'country_code' => 'Country Code',
            'ip' => 'IP',
            'region' => 'Region',
            'state' => 'State',
            'city' => 'City',
            'wifi' => 'WIFI',
            'operator' => 'Operator',
            'carrier' => 'Carrier',
            'language' => 'Language',
            'appsflyer_id' => 'AppsFlyer ID',
            'advertising_id' => 'Advertising ID',
            'idfa' => 'IDFA',
            'android_id' => 'Android ID',
            'customer_user_id' => 'Customer User ID',
            'imei' => "IMEI",
            'idfv' => 'IDFV',
            'platform' => 'Platform',
            'device_type' => 'Device Type',
            'os_version' => 'OS Version',
            'app_version' => 'App Version',
            'sdk_version' => 'SDK Version',
            'app_id' => 'App ID',
            'app_name' => 'App Name',
            'bundle_id' => 'Bundle ID',
            'af_attribution_lookback' => 'Attribution Lookback',
            'event_time' => 'Event Time',
            'event_name' => 'Event Name',
            'event_value' => 'Event Value',
            'event_revenue' => 'Event Revenue',
            'event_revenue_usd' => 'Event Revenue USD',
            'event_revenue_currency' => 'Event Revenue Currency',
            'is_receipt_validated' => 'Is Receipt Validated',
            'postal_code' => 'Postal Code',
            'dma' => 'DMA',
            'af_reengagement_window' => 'Reengagement window',
            'event_source' => 'Event source',
            'is_primary_attribution' => 'Is Primary Attribution',
            'af_sub_site_id' => 'Sub Site ID'
        ];

        return isset($columns['v' . $version]) ? $columns['v' . $version] : [];
    }
}