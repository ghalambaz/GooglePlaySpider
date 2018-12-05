<?php

namespace GooglePlaySpider;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Author : Ali Ghalambaz<a.ghalambaz@gmail.com>
 * Date: 2018/12/03
 * Time: 12:56 PM
 */
class Package
{
    private $crawler = "";

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function getTitle()
    {
        return $this->crawler->filter("h1[class=AHFaub]")->text();
    }

    public function getFeaturedImageAddress()
    {
        return $this->crawler->filter("div[class=dQrBL] > img")->attr("src");
    }

    public function getDeveloper()
    {
        //T32cc UAO9ie
        $main_tag = $this->crawler->filter('div[class="ZVWMWc"]')->filter("a")->eq(0);
        $item['title'] = $main_tag->text();
        $item['link'] = $main_tag->attr("href");
        return $item;
    }

    public function getPackageCategory()
    {
        $main_tag = $this->crawler->filter('div[class="ZVWMWc"]')->filter("a")->eq(1);
        $item['title'] = $main_tag->text();
        $item['link'] = $main_tag->attr("href");
        return $item;
    }

    public function isEditorChoice()
    {
        try {
            $this->crawler->filter('span[class="giozf"]')->text();
            return true;
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }

    public function getESRB()
    {
        $main_tag = $this->crawler->filter('img[class="T75of E1GfKc"]');
        $item['link'] = $main_tag->attr("src");
        $item['title'] = $main_tag->attr("alt");
        return $item;
    }

    public function getScreenshots()
    {

        $main_tag = $this->crawler->filter('div[class="FaSaxe Eg31qe"]')->filter("img");

        $scs = $main_tag->each(function (Crawler $node, $i) {
            if ($node->nodeName() == "img") {
                $sc['height'] = $node->attr('height');
                $sc['width'] = $node->attr('width');
                if (!empty($node->attr('data-src')))
                    $sc['link'] = $node->attr('data-src');
                else
                    $sc['link'] = $node->attr('src');
                $sc['type'] = $node->attr('itemprop');
            }
            if ($sc) return $sc;
            return null;
        });

        return $scs;
    }

    public function getDescription()
    {
        return $this->crawler->filter('div[class="DWPxHb"]')->eq(0)->html();
    }

    public function getWhatsNew()
    {
        return $this->crawler->filter('div[class="DWPxHb"]')->eq(0)->html();
    }

    public function getRating()
    {
        $item['rate'] = $this->crawler->filter('div[class="BHMmbe"]')->text();
        $total = $this->crawler->filter('span[class="EymY4b"]')->text();
        preg_match_all('!\d+!', $total, $matches);
        $item['total'] = implode("", $matches[0]);
        return $item;
    }

    public function getAdditionalInfo()
    {
        $d = $this->crawler->filter('div[class="xyOfqd"] > div[class=hAyfc]')->each(function (Crawler $node, $i) {
            $index = $node->filter('div[class="BgcNfc"]')->text();
            $item[$index] = $node->filter('div[class="IQ1z0d"]')->text();
            return $item;
        });
        return $d;
    }

    public function getSimilar()
    {
        return $this->crawler->filter('div[class="Vpfmgd"]')->each(function (Crawler $node,$i)
        {
            $similar['image'] = $node->filter("img")->attr("src");
            $main_tag =  $node->filter('div[class="kCSSQe"]');
            $similar['title'] =$main_tag->filter('div[class="b8cIId ReQCgd Q9MA7b"]')->text();
            $similar['link'] = $main_tag->filter('div[class="b8cIId ReQCgd Q9MA7b"]')->filter("a")->attr("href");
            $developer_tag = $main_tag->filter('div[class="b8cIId ReQCgd KoLSrc"]');
            $similar['developer'] = $developer_tag->text();
            $similar['developer_link'] = $developer_tag->filter("a")->attr("href");
            $similar['description'] = $main_tag->filter('div[class="b8cIId f5NCO"]')->text();
            return $similar;
        });
    }

}