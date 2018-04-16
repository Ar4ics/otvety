<?php

namespace App\Http\Controllers;

use Exception;
use Goutte\Client;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\SplFileInfo;

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
            'https://otvert.herokuapp.com/questions/' . $part
        );
        $data = $crawler->filter('body > table > tr > td')->each(function (Crawler $node) {
            try {
                $q = trim($node->filter('b')->html());
            } catch (Exception $e) {
                $q = 'not found';
            }
            $answers = $node->children()->last()->filter('li')->each(function (Crawler $node) {
                return trim($node->html());
            });
            return ['question' => $q, 'answers' => $answers, 'correct' => 0, 'comment' => ''];
        });
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        Storage::put($part . '/questions.json', $json_data);
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

    public function allAnswers()
    {
        try {
            $answers = json_decode(Storage::get('all.json'));
            return view('answers', ['answers' => $answers, 'part' => 'итог']);
        } catch (FileNotFoundException $e) {
            return $e;
        }
    }

    public function search(Request $request)
    {
        $searchString = $request->input('question');
        $files = File::allFiles(public_path() . '/training');
        $targetFiles = [];
        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $content = mb_convert_encoding($file->getContents(), 'utf-8', 'windows-1251');
            if (mb_stripos($content, $searchString) !== false) {
                $targetFiles[] = $file->getFilename();
            }
        }
        return view('results', ['results' => $targetFiles]);
    }

    public function searchPage()
    {
        return view('search');
    }

    public function getVariant($title)
    {
        try {
            $filename = public_path() . '/training/' . $title;
            $extension = File::extension($filename);
            $file = File::get($filename);
            $content = mb_convert_encoding($file, 'utf-8', 'windows-1251');
            if ($extension === 'txt') {
                return '<pre style="word-wrap: break-word; white-space: pre-wrap;">' . e($content) . '</pre>';
            }
            if ($extension === 'htm') {
                return $content . '<pre>' . e($content) . '</pre>';
            }
            return $content;
        } catch (FileNotFoundException $e) {
            return 'file not found';
        }
    }

}
