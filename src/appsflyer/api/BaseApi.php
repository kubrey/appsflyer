<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 *
 */

namespace appsflyer\api;


class BaseApi
{
    protected $lastCurlInfo = [];
    protected $lastCurlError;
    protected $lastCurlResponse;
    protected $lastCurlOptions;
    protected $lastCurlFile = null;
    protected $tmpFolder;

    protected $curl;

    protected $curlOptions;
    protected $tmpFilePointer;
    protected $tmpFileName;

    /**
     * @param $url
     * @return null|string path to file
     * @throws \Exception
     */
    public function prepareCurlFileRequest($url) {
        $this->resetCurl();
        if (!$this->tmpFileName) {
            throw  new \Exception("No temporary file name is set");
        }
        $this->curl = curl_init();
        $destination = dirname(__FILE__) . "/../../tmp/" . $this->tmpFileName;
        $this->tmpFilePointer = fopen($destination, 'w+');
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $url,
            CURLOPT_FILE => $this->tmpFilePointer
        ];
        $this->curlOptions = $options;
        $this->lastCurlFile = $destination;

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setAdditionalCurlOptions($options = []) {
        if ($options && is_array($options)) {
            foreach ($options as $key => $val) {
                $this->curlOptions[$key] = $val;
            }
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function runCurl() {

        curl_setopt_array($this->curl, $this->curlOptions);
        $this->lastCurlResponse = curl_exec($this->curl);
        $this->lastCurlError = curl_error($this->curl);
        $this->lastCurlInfo = curl_getinfo($this->curl);
        curl_close($this->curl);
        if (is_resource($this->tmpFilePointer)) {
            fclose($this->tmpFilePointer);
        }
        if ($this->lastCurlError) {
            throw  new \Exception($this->lastCurlError);
        }
        if (!isset($this->lastCurlInfo['http_code']) || $this->lastCurlInfo['http_code'] != "200") {
            throw new \Exception("Curl Http Code is " . (isset($this->lastCurlInfo['http_code']) ?
                    $this->lastCurlInfo['http_code'] : "empty"));
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function resetCurl() {
        if ($this->lastCurlFile) {
            @unlink($this->lastCurlFile);
        }
        $this->lastCurlInfo = [];
        $this->lastCurlResponse = null;
        $this->lastCurlError = null;
        $this->lastCurlFile = null;
        return $this;
    }

    public function getLastCurlFile() {
        return $this->lastCurlFile;
    }

    public function setLastCurlFile($path) {
        if (!is_file($path) || !is_readable($path)) {
            throw  new \Exception("Path is not valid or readable");
        }
        $this->lastCurlFile = $path;
        return $this;
    }

    public function getLastCurlInfo() {
        return $this->lastCurlInfo;
    }

    public function getLastCurlError() {
        return $this->lastCurlError;
    }

    public function getLastCurlResponse() {
        return $this->lastCurlResponse;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setTmpFileName($name) {
        $this->tmpFileName = $name;
        return $this;
    }

    public function __destruct() {
        if (is_file($this->lastCurlFile)) {
            unlink($this->lastCurlFile);
        }
    }

}