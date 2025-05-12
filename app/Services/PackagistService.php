<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PackagistService
{
    public function getPackage($vendor, $package)
    {
        $cacheKey = "packagist_{$vendor}_{$package}";

        return cache()->remember($cacheKey, 60 * 5, function () use ($vendor, $package) {
            $response = Http::withUserAgent('laravel.starterkits.app/1.0')->get("https://packagist.org/packages/{$vendor}/{$package}.json");
            return $response->json();
        });

        /**
         * returns something like[
  "package" => array:16 [
    "name" => "devdojo/wave"
    "description" => "Wave SaaS Starter Kit"
    "time" => "2025-03-05T19:08:06+00:00"
    "maintainers" => array:1 [▶]
    "versions" => array:22 [▶]
    "type" => "project"
    "repository" => "https://github.com/thedevdojo/wave"
    "github_stars" => 6007
    "github_watchers" => 100
    "github_forks" => 828
    "github_open_issues" => 2
    "language" => "CSS"
    "dependents" => 0
    "suggesters" => 0
    "downloads" => array:3 [▶]
    "favers" => 6008
  ]
]
         */
    }
}
