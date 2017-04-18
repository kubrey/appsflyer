<?php

namespace appsflyer\api\PushApi;

use appsflyer\api\BaseApi;

/**
 * test push event:
 * [re_targeting_conversion_type] =>
 * [is_retargeting] => false
 * [app_id] => id1151406354
 * [platform] => ios
 * [event_type] => install
 * [attribution_type] => regular
 * [event_time] => 2017-04-18 09:12:03
 * [event_time_selected_timezone] => 2017-04-18 05:12:03.892-0400
 * [event_name] =>
 * [event_value] =>
 * [currency] =>
 * [selected_currency] => USD
 * [cost_in_selected_currency] =>
 * [cost_per_install] =>
 * [click_time] => 2017-04-18 09:10:53
 * [click_time_selected_timezone] => 2017-04-18 05:10:53.000-0400
 * [install_time] => 2017-04-18 09:12:03
 * [install_time_selected_timezone] => 2017-04-18 05:12:03.892-0400
 * [agency] =>
 * [media_source] => Apple Search Ads
 * [af_sub1] =>
 * [af_sub2] =>
 * [af_sub3] =>
 * [af_sub4] =>
 * [af_sub5] =>
 * [af_siteid] =>
 * [click_url] =>
 * [campaign] => iFax Free US
 * [fb_campaign_id] =>
 * [fb_campaign_name] =>
 * [fb_adset_id] =>
 * [fb_adset_name] =>
 * [fb_adgroup_id] =>
 * [fb_adgroup_name] =>
 * [country_code] => US
 * [city] => Bellevue
 * [ip] => 172.58.41.13
 * [wifi] => false
 * [language] => en-US
 * [appsflyer_device_id] => 1492481495387-4794096
 * [customer_user_id] =>
 * [idfa] => 6A0FBA75-AECF-45AD-96E5-8FA9A0D24BB5
 * [mac] =>
 * [device_name] => Alfonsl^B<EF><BF><BD><EF><BF><BD>s iPhone
 * [device_type] => iPhone 6 Plus
 * [os_version] => 10.3.1
 * [sdk_version] => v4.4.5.9
 * [app_version] => 1.5
 * [http_referrer] =>
 * [idfv] => 52F29A86-85D3-4CC3-AB39-E6CBE91005B3
 * [app_name] => Fax from iPhone - Send Fax App.
 * [download_time] => 2017-04-18 09:11:35
 * [download_time_selected_timezone] => 2017-04-18 05:11:35.000-0400
 * [af_cost_currency] =>
 * [af_cost_value] =>
 * [af_cost_model] =>
 * [af_c_id] => 9856893
 * [af_adset] => <D1><82><D0><80><D1><87><D0><BD><D0><80><D0><B5> <D0><B2><D1><85><D0><80><D0><B6><D0><B4><D0><B5><D0><BD><D0><B8><D0><B5> <D1><81><D0><BB><D0><BE><D0><B2>
 * [af_adset_id] => 16249136
 * [af_ad] =>
 * [af_ad_id] =>
 * [af_ad_type] =>
 * [af_channel] =>
 * [af_keywords] => free iphone fax
 * [bundle_id] => ifax.fr
 * [attributed_touch_type] => click
 * [attributed_touch_time] => 2017-04-18 09:10:53
 * )
 */

/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 * Getting events from appsflyer
 * @link https://support.appsflyer.com/hc/en-us/articles/207034386-Push-API-Data-Structure-iOS
 */
class BasePushApi extends BaseApi
{

    /**
     * @return array
     */
    public static function getColumns() {
        $map = [
            'attributed_touch_type' => 'Attributed Touch Type',
            'attributed_touch_time' => 'Attributed Touch Time',
            'event_type' => 'Event Type',
            'attribution_type'=>'Attribute Type',//Organic or Regular
            'click_time' => 'Click Time',
            'download_time' => 'Download Time',
            'install_time' => 'Install Time',
            'media_source' => 'Media Source',
            'agency' => 'Agency',
            'af_channel' => 'Channel',
            'af_keywords' => 'Keywords',
            'campaign' => 'Campaign',
            'af_c_id' => 'Campaign ID',
            'af_adset' => 'Adset',
            'af_adset_id' => 'Adset ID',
            'af_ad' => 'Ad',
            'af_ad_id' => 'Ad ID',
            'fb_campaign_name' => 'Campaign Name',
            'fb_campaign_id' => 'Campaign ID',
            'fb_adset_name' => 'Adset Name',
            'fb_adset_id' => 'FB Adset ID',
            'fb_adgroup_name' => 'FB AdGroup Name',
            'fb_adgroup_id' => 'FB AdGroup ID',
            'af_ad_type' => 'Ad Type',
            'af_siteid' => 'Site ID',
            'af_sub1' => 'Sub 1',
            'af_sub2' => 'Sub 2',
            'af_sub3' => 'Sub 3',
            'af_sub4' => 'Sub 4',
            'af_sub5' => 'Sub 5',
            'http_referrer' => 'Http Referer',
            'click_url' => 'Click Url',
            'af_cost_model' => 'Cost Model',
            'af_cost_value' => 'COst Value',
            'af_cost_currency' => 'Cost Currency',
            'cost_per_install' => 'Cost per install',
            'is_retargeting' => 'Is Retargeting',
            're_targeting_conversion_type' => 'Targeting Conversion Type',
            'country_code' => 'Country Code',
            'city' => 'City',
            'ip' => 'IP',
            'wifi' => 'WiFi',
            'mac' => 'Mac',
            'language' => 'Language',
            'appsflyer_device_id' => 'Appsflyer Device ID',
            'idfa' => 'Id FA',
            'customer_user_id' => 'Customer User ID',
            'idfv' => 'ID FV',
            'platform' => 'Platform',
            'device_type' => 'Device Type',
            'device_name' => 'Device name',
            'os_version' => 'OS Version',
            'app_version' => 'App Version',
            'sdk_version' => 'SDK Version',
            'app_id' => 'App ID',
            'app_name' => 'App Name',
            'bundle_id' => 'Bundle ID',
            'event_time' => 'Event Time',
            'event_name' => 'Event Name',
            'event_value' => 'Event Value',
            'currency' => 'Currency',
            'download_time_selected_timezone' => 'Download Time SelectedTimezone',
            'click_time_selected_timezone' => 'Click Time Selected Timezone',
            'install_time_selected_timezone' => 'Install Time Selected Timezone',
            'event_time_selected_timezone' => 'Event Time Selected Timezone',
            'selected_currency' => 'Selected Currency',
            'revenue_in_selected_currency' => 'Revenue In Selected Currency',
            'cost_in_selected_currency' => 'Cost In Selected Currency'];

        return $map;
    }
    

}

