<?php

namespace TRS\RestResponse\jsend;

class Response
{
    private $response;

    public function __construct($parameters = array(), $statusCode = 200)
    {
        $this->init();

        if (!empty($parameters) && is_array($parameters))
            $this->response->setParameters($parameters);

        $this->response->setStatusCode($statusCode);
    }

    private function init()
    {
        $oauth2service = \Yii::$app->getModule('oauth2');

        $this->response = $oauth2service->getServer()->getResponse();

        if (!$this->response)
            $this->response = new \filsh\yii2\oauth2server\Response();
    }

    /**
     * @return string
     */
    protected function getResponseFormat()
    {
        return 'json';
    }

    /**
     * @param string $name
     * @param string $value
     * @return void
     */
    public function addHeader($name, $value)
    {
        $this->response->addHttpHeaders([$name => $value]);
    }

    /**
     * @return void
     */
    public function clearHeaders()
    {
        $this->response->setHttpHeaders([]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function removeHeader($name)
    {
        $headers = $this->getHeaders();

        if (isset($headers[$name]))
            delete($headers[$name]);

        $this->response->setHttpHeaders($headers);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->response->getHttpHeaders();
    }

    /**
     * @return \filsh\yii2\oauth2server\Response
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param mixed $data
     * @return \filsh\yii2\oauth2server\Response
     */
    public static function success($data)
    {
        return (new Response([
            'status' => 'success',
            'data'   => $data
        ], 200))->getResponse();
    }

    /**
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return \filsh\yii2\oauth2server\Response
     */
    public static function error($message, $data, $code = 500)
    {
        return (new Response([
            'status'  => 'error',
            'message' => $message,
            'code'    => $code,
            'data'    => $data,
        ], 500))->getResponse();
    }

    /**
     * @param mixed $data
     * @param int $code
     * @return \filsh\yii2\oauth2server\Response
     */
    public static function fail($data, $code = 400)
    {
        return (new Response([
            'status' => 'fail',
            'data'   => $data
        ], $code))->getResponse();
    }
}

