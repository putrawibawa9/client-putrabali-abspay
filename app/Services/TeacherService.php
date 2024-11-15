<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class TeacherService{

    protected $client;
    protected $baseUrl;

     public function __construct(Client $client)
    {
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }

         public function getAllTeachers()
    {
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/teachers', [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
                // Optional: Add query parameters if needed
                'query' => [
                    // 'param1' => 'value1',
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
                'error' => 'Failed to fetch students. Please try again later.',
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

    public function addNewTeacher($data){
        // dd($data);
        // Implement the logic to add a new teacher
     $response = $this->client->request('POST', $this->baseUrl . '/teachers', [
            'timeout' => 10, // Set a timeout for the request
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'name' => $data['name'],
                'alias' => $data['alias'],
            ],
        ]);

        // Check if the response status code is 201 (Created)
        if ($response->getStatusCode() === 201) {
            // Decode the JSON response into an associative array
            $data = json_decode($response->getBody()->getContents(), true);
            return $data;
        }else{
            return [
                'error' => 'Unexpected response status code: ' . $response->getStatusCode(),
            ];
        }
    }

    public function deleteTeacher($id){
          try {
            // dd($this->client);
            // Make the API request
            $response = $this->client->request('DELETE', $this->baseUrl . '/teachers/'.$id, [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() === 204) {
              return true;
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