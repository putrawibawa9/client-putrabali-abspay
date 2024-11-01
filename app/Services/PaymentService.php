<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class PaymentService
{
    protected $client;
    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }

    public function store($data)
    {
        try {
            // Make the API request
            $response = $this->client->request('POST', $this->baseUrl . '/payments', [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $data,
            ]);

            // Check if the response status code is 201 (Created)
            if ($response->getStatusCode() === 201) {
                // Decode the JSON response into an associative array
                $data = json_decode($response->getBody()->getContents(), true);
                
                return $data;
            }

            // Handle unexpected status codes
            return [
                'error' => 'Unexpected response status code: ' . $response->getStatusCode(),
            ];
        } catch (RequestException $e) {
            // Log the error details
            Log::error('API Request Failed: ' . $e->getMessage());

            // Return a user-friendly error message
            return [
                'error' => 'Failed to process payment. Please try again later.',
            ];
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected Error: ' . $e->getMessage());

            // Return a generic error message
            return [
                'error' => 'An unexpected error occurred. Please try again later.',
            ];
        }

    }

    public function getStudentPayment($id){
        try{
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/student/payment/' . $id, [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() === 200) {
                // Decode the JSON response into an associative array
                $data = json_decode($response->getBody()->getContents(), true);

                return $data;
            }

            // Handle unexpected status codes
            return [
                'error' => 'Unexpected response status code: ' . $response->getStatusCode(),
            ];
        } catch (RequestException $e) {
            // Log the error details
            Log::error('API Request Failed: ' . $e->getMessage());

            // Return a user-friendly error message
            return [
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected Error: ' . $e->getMessage());

            // Return a generic error message
            return [
              'error' => $e->getMessage(),
            ];
        }
    }
}