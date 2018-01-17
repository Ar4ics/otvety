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
        $client = new Client();
        $crawler = $client->request(
            'GET',
            'https://otvety-test.herokuapp.com/part1'
        );
        $data = $crawler->filter('table > tr > td')->each(function (Crawler $node) {
            $q = trim($node->filter('b')->html());
            $answers = $node->filter('ol li')->each(function (Crawler $node) {
                return trim($node->text());
            });
            return ['question' => $q, 'answers' => $answers, 'correct' => 1];
        });
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        Storage::put('questions.json', $json_data);
        return $data;
    }
}
