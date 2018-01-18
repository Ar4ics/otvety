<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Storage;
use Symfony\Component\DomCrawler\Crawler;

class HomeController extends Controller
{
    public function questions($part)
    {
        return view('questions.' . $part);
    }

    public function parse($part)
    {
        $client = new Client();
        $crawler = $client->request(
            'GET',
            'https://otvety-test.herokuapp.com/questions/' . $part
        );
        $data = $crawler->filter('table > tr > td')->each(function (Crawler $node) {
            $q = trim($node->filter('b')->html());
            $answers = $node->filter('ol li')->each(function (Crawler $node) {
                return trim($node->html());
            });
            return ['question' => $q, 'answers' => $answers, 'correct' => 1];
        });
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        Storage::put('questions.json', $json_data);
        return $data;
    }

    public function answers($part)
    {
        try {
            $answers = json_decode(Storage::get($part . '/answers.json'));
            return view('answers', ['answers' => $answers, 'part' => $part]);
        } catch (FileNotFoundException $e) {
            return $e;
        }
    }

}
