<?php

namespace Mvc\VO;

class DbHost
{
    private $host;

    public function __construct(string $host)
    {
        $this->host = $host;
    }

    public function getHost()
    {
        return $this->host;
    }
}