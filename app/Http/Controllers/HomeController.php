<?php

namespace App\Http\Controllers;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Storage;
use Symfony\Component\DomCrawler\Crawler;

class HomeController extends Controller
{
    public function part1()
    {
        $client = new Client([
            'base_uri' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);
        $crawler = $client->request(
            'GET',
            '/'
        );
        return $crawler->html();
        $data = $crawler->filter('table > tr')->each(function (Crawler $node) {
            $q = $node->filter('td')->text();
            $answers = trim($node->filter('td OL LI')->text());
            return ['question' => $q, 'answers' => $answers];
        });
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        Storage::put('questions.json', $json_data);
        return $data;
    }
}
