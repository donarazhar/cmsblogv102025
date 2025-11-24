<?php

namespace App\Http\Controllers;

class RobotsController extends Controller
{
    public function index()
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /login\n";
        $robots .= "Disallow: /register\n";
        $robots .= "\n";
        $robots .= "Sitemap: " . url('sitemap.xml') . "\n";

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
