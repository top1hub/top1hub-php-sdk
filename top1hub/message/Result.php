<?php
namespace top1hub\message;

class Result
{
    private $sueccess;
    private $statusCode;
    private $reason;

    /**
     * @return mixed
     */
    public function getSueccess()
    {
        return $this->sueccess;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }
    public function __construct($success,$statusCode,$reason = null){
        $this->sueccess = $success;
        $this->statusCode = $statusCode;
        $this->reason = $reason;
    }

}