<?php

namespace App\Http\Controllers;

class FrontController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function privacy()
    {
        return view('front.privacy', [
            'title' => 'Privacy Policy',
            'description' => 'Privacy Policy',
        ]);
    }

    public function terms()
    {
        return view('front.terms', [
            'title' => 'Terms of Service',
            'description' => 'Terms of Service',
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
