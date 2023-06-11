<?php

namespace App\Http\Controllers;

use Illuminate\Mail\Markdown;
use League\CommonMark\Parser\MarkdownParser;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.welcome');
    }

    public function privacy()
    {
        $html= Markdown::parse(file_get_contents(resource_path('markdown/policy.md')));
        return view('front.markdown', [
            'title' => 'Política de Privacidade',
            'text' => $html,
        ]);
    }

    public function terms()
    {
       $html= Markdown::parse(file_get_contents(resource_path('markdown/terms.md')));
        return view('front.markdown', [
            'title' => 'Termos de serviço',
            'text' => $html,
        ]);
    }

    public function pricing()
    {
        return view('front.pricing', [
            'title' => 'Pricing',
            'description' => 'Pricing',
        ]);
    }

    public function faq()
    {
        return view('front.faq', [
            'title' => 'FAQ',
            'description' => 'FAQ',
        ]);
    }
}
