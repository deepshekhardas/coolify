<?php

use App\Models\GitlabApp;
use Illuminate\Support\Facades\Http;

function gitlabApi(GitlabApp $source, string $endpoint, string $method = 'get', ?array $data = null, bool $throwError = true): array
{
    $url = $source->api_url . $endpoint;

    if ($source->is_public) {
        $response = Http::accept('application/json')->$method($url, $data);
    } else {
        $token = $source->deploy_token;
        if ($data && in_array(strtolower($method), ['post', 'patch', 'put'])) {
            $response = Http::withToken($token)->accept('application/json')->$method($url, $data);
        } else {
            $response = Http::withToken($token)->accept('application/json')->$method($url);
        }
    }

    if (! $response->successful() && $throwError) {
        $errorMessage = data_get($response->json(), 'message', data_get($response->json(), 'error', 'no error message found'));
        throw new \Exception(
            'GitLab API call failed:<br>' .
            "Error: {$errorMessage}<br>" .
            "Endpoint: {$endpoint}"
        );
    }

    return [
        'data' => collect($response->json()),
    ];
}
