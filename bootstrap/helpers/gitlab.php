<?php

use App\Models\GitlabApp;
use Illuminate\Support\Facades\Http;

function gitlabApi(GitlabApp $source, string $endpoint, string $method = 'get', ?array $data = null, bool $throwError = true)
{
    if ($source->is_public) {
        $response = Http::GitLab($source->api_url)->$method($endpoint);
    } else {
        $response = Http::GitLab($source->api_url, $source->app_token)->$method($endpoint, $data);
    }

    if (! $response->successful() && $throwError) {
        throw new \Exception("GitLab API error: {$response->body()}");
    }

    return [
        'data' => collect($response->json()),
    ];
}
