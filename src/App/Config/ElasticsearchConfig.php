<?php

namespace Appcheap\SearchEngine\App\Config;

class ElasticsearchConfig
{
    private $hosts;

    public function __construct($hosts)
    {
        $this->hosts = $hosts;
    }

    public function getHosts()
    {
        return $this->hosts;
    }
}
