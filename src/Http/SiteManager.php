<?php
namespace Light\Http;

use Light\Config\Config;

class SiteManager
{
    protected $siteMap;
    protected $hostMap = [];

    public function __construct(Config $config)
    {
        $this->siteMap = $config->get('site');
    }

    public function getSite($host)
    {
        $hostMap = $this->getHostMap();

        if (!isset($hostMap[$host])) {
            throw new \Exception("cannot find host $host");
        }

        return $hostMap[$host];
    }

    public function getHostMap()
    {
        if ($this->hostMap) {
            return $this->hostMap;
        }

        foreach ($this->siteMap as $site => $opts) {
            $this->hostMap[$opts['host']] = $site;
        }

        return $this->hostMap;
    }

    public function getHost($site)
    {
        return $this->siteMap[$site]['host'];
    }
}
