<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GitHubService
{
    private const GITHUB_API_BASE = 'https://api.github.com';

    /**
     * Convert a GitHub repository URL to a repository API URL
     *
     * @param string $githubUrl The GitHub repository URL
     * @return string The repository API URL
     */
    public function getRepositoryApiUrl(string $githubUrl): string
    {
        // Remove trailing slash if present
        $githubUrl = rtrim($githubUrl, '/');

        // Extract owner and repo from the URL
        $parts = explode('/', $githubUrl);
        $owner = $parts[count($parts) - 2];
        $repo = $parts[count($parts) - 1];

        return self::GITHUB_API_BASE . "/repos/{$owner}/{$repo}";
    }

    /**
     * Get the default branch of a repository
     *
     * @param string $githubUrl The GitHub repository URL
     * @return string|null The default branch name or null if not found
     */
    public function getDefaultBranch(string $githubUrl): ?string
    {
        try {
            $response = Http::get($this->getRepositoryApiUrl($githubUrl));

            if ($response->successful()) {
                return $response->json('default_branch');
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Fetch the README content from a GitHub repository
     *
     * @param string $githubUrl The GitHub repository URL
     * @return string|null The README content as markdown, or null if not found
     */
    public function getReadmeContent(string $githubUrl): ?string
    {
        try {
            $defaultBranch = $this->getDefaultBranch($githubUrl) ?? 'main';

            // Remove trailing slash if present
            $githubUrl = rtrim($githubUrl, '/');

            // Extract owner and repo from the URL
            $parts = explode('/', $githubUrl);
            $owner = $parts[count($parts) - 2];
            $repo = $parts[count($parts) - 1];

            $response = Http::get(
                self::GITHUB_API_BASE . "/repos/{$owner}/{$repo}/readme",
                [
                    'ref' => $defaultBranch
                ]
            );

            if ($response->successful()) {
                return base64_decode($response->json('content'));
            }

            return null;
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error fetching README content: ' . $e->getMessage());
            return null;
        }
    }
}
