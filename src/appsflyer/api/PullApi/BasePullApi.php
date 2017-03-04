<?php
/**
 * @author Sergey Kubrey <kubrey.work@gmail.com>
 *
 */

namespace appsflyer\api\PullApi;

use appsflyer\api\BaseApi;

class BasePullApi extends BaseApi
{
    protected $apiKey = null;
    protected $version = 5;
    protected $baseUrl = "hq.appsflyer.com/export";
    protected $scheme = "https";
    protected $filters = [];
    protected $action;
    protected $applicationId;

    protected $resultUrl;
    protected $response;

    protected $afterRunCallbacks = [];
    protected $beforeRunCallbacks = [];

    protected $method = null;

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_FILE = 'FILE';
    const METHOD_PUT = 'PUT';

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    public function setFilters($filters = []) {
        if (!is_array($filters)) {
            throw  new \Exception("Filters should be an array");
        }
        $this->filters = $filters;
        return $this;
    }

    public function setAction($action) {
        if (!$action) {
            throw new \Exception("No action");
        }
        $this->action = trim($action, " /");
        return $this;
    }

    public function setApplicationId($applicationId) {
        if (!$applicationId) {
            throw new \Exception("No application id");
        }
        $this->applicationId = $applicationId;
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function run() {
        $fn = null;
        switch ($this->method) {
            case static::METHOD_FILE:
                $fn = "prepareCurlFileRequest";
                break;
            case static::METHOD_GET:

                break;
        }
        if (!$fn && !method_exists($this, $fn)) {
            throw new \Exception("Invalid method is set");
        }

        $this->composeResultUrl()
            ->callBeforeRunCallbacks()
            ->$fn($this->resultUrl)
            ->runCurl()
            ->callAfterRunCallbacks();

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function composeResultUrl() {
        $url[] = $this->scheme . "://" . $this->baseUrl;
        $url[] = $this->applicationId;
        $url[] = $this->action;
        $url[] = "v" . $this->version;

        $queryParts = [];
        $queryParts['api_token'] = $this->apiKey;
        foreach ($this->filters as $key => $filterVal) {
            $queryParts[$key] = $filterVal;
        }

        foreach ($url as $urlPart) {
            if (!$urlPart) {
                throw  new \Exception("Url is not filled properly");
            }
        }
        $this->baseUrl = implode(DIRECTORY_SEPARATOR, $url);
        $getParams = http_build_query($queryParts);
        $this->resultUrl =$this->baseUrl."?" . $getParams;

        return $this;
    }

    /**
     * @param $callback
     * @return $this
     * @throws \Exception
     */
    public function addBeforeRunCallback($callback) {
        if (!is_callable($callback)) {
            throw  new \Exception("Before run callback is invalid");
        }
        $this->beforeRunCallbacks[] = $callback;
        return $this;
    }

    /**
     * @param $callback
     * @return $this
     * @throws \Exception
     */
    public function addAfterRunCallback($callback) {
        if (!is_callable($callback)) {
            throw  new \Exception("After run callback is invalid");
        }
        $this->afterRunCallbacks[] = $callback;
        return $this;
    }

    /**
     * @return $this
     */
    public function callBeforeRunCallbacks() {
        foreach ($this->beforeRunCallbacks as $cb) {
            if (!is_callable($cb)) {
                continue;
            }
            $params = [
                'url' => $this->resultUrl,
                'time' => time(),
                'timezone' => date_default_timezone_get(),
                'action' => $this->action
            ];
            call_user_func_array($cb, ['params' => $params]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function callAfterRunCallbacks() {
        foreach ($this->afterRunCallbacks as $cb) {
            if (!is_callable($cb)) {
                continue;
            }
            $params = [
                'url' => $this->resultUrl,
                'time' => time(),
                'timezone' => date_default_timezone_get(),
                'action' => $this->action,
                'curl' => [
                    'error' => $this->lastCurlError,
                    'info' => $this->lastCurlInfo,
                    'file' => $this->lastCurlFile
                ]
            ];
            call_user_func_array($cb, ['params' => $params]);
        }

        return $this;
    }

    public function setPostMethod() {
        $this->method = static::METHOD_POST;
        return $this;
    }

    public function setGetMethod() {
        $this->method = static::METHOD_GET;
        return $this;
    }

    /**
     * Get request and downloading file
     * @return $this
     */
    public function setFileMethod() {
        $this->method = static::METHOD_FILE;
        return $this;
    }


}