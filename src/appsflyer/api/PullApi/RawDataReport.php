<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 *
 */

namespace appsflyer\api\PullApi;


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
    public function returnAsArray() {
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
}