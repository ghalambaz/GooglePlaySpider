<?php
namespace GooglePlaySpider;
use Goutte\Client;

class GooglePlaySpider
{
    private $url = null;
    private $client ;
    private $crawler;
    private $baseUrl = null;
    private $name = "";
    public function __construct($baseUrl="https://play.google.com/store/apps/details?id=")
    {
        $this->baseUrl = $baseUrl;
    }
    public function setName($packageName)
    {
        $this->name =$packageName;
    }
    public function getPackageURL()
    {
        if($this->name != "")
        {
            return $this->baseUrl.$this->name;
        }
        else
            return "please set package name with setName()";
    }
    public function getPackageByPackageName($name)
    {
        $this->setName($name);
        $this->client = new Client();
        $this->crawler = $this->client->request("get",$this->getPackageURL());
        return new Package($this->crawler);
    }

}