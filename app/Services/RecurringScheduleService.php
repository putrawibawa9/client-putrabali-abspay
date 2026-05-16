<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class RecurringScheduleService
{
    protected Client $client;
    protected string $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->baseUrl = rtrim(config('services.api.base_url'), '/');
    }

    public function list(array $filters = []): array
    {
        return $this->request('GET', '/scheduling/schedules', [
            'query' => $this->filterEmpty($filters),
        ]);
    }

    public function create(array $payload): array
    {
        return $this->request('POST', '/scheduling/schedules', [
            'json' => $payload,
        ]);
    }

    public function update(int|string $scheduleId, array $payload): array
    {
        return $this->request('PUT', "/scheduling/schedules/{$scheduleId}", [
            'json' => $payload,
        ]);
    }

    public function deleteOrDeactivate(int|string $scheduleId, array $payload): array
    {
        return $this->request('DELETE', "/scheduling/schedules/{$scheduleId}", [
            'json' => $payload,
        ]);
    }

    public function request(string $method, string $uri, array $options = []): array
    {
        try {
            $response = $this->client->request($method, $this->baseUrl . $uri, array_replace_recursive([
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'timeout' => 15,
            ], $options));

            return json_decode($response->getBody()->getContents(), true) ?? [];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $payload = json_decode($response?->getBody()->getContents() ?? '{}', true) ?? [];

            throw new \RuntimeException(
                $payload['message'] ?? 'Permintaan schedule gagal diproses.',
                $response?->getStatusCode() ?? 400,
                $e
            );
        } catch (RequestException $e) {
            Log::error('Recurring schedule API request failed', [
                'message' => $e->getMessage(),
                'uri' => $uri,
                'method' => $method,
            ]);

            throw new \RuntimeException('Gagal terhubung ke server scheduling.', 500, $e);
        }
    }

    protected function filterEmpty(array $data): array
    {
        return array_filter($data, static function ($value) {
            return !($value === null || $value === '');
        });
    }
}
