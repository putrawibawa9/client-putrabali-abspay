<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class CourseService
{
    protected $client;
    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }

     public function getAllCourses()
    {
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/courses', [
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
                'error' => 'Failed to fetch courses. Please try again later.',
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
    public function search($data){
        // dd($data);
        try {
            // Make the API request
            $response = $this->client->request('POST', $this->baseUrl . '/courses/search', [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
                // Optional: Add query parameters if needed
                'json' => [
                    'level' => $data['level'],
                    'section' => $data['section'],
                    'subject' => $data['subject'],
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
           
        } catch (RequestException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            return $error;
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected Error: ' . $e->getMessage());

            // Return a generic error message
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

   public function getCourseWithStudentsbyID($id)
    {
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/courses/' . $id, [
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
                'error' => 'Failed to fetch course data. Please try again later.',
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

   public function addNewCourse($data)
    {

        // dd($data);
        try {
            // Make the API request to add a new student
            $response = $this->client->request('POST', $this->baseUrl . '/courses', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'level' => $data['level'],
                    'section' => $data['section'],
                    'subject' => $data['subject'],
                    'alias' => $data['alias'],
                    'payment_rate' => $data['payment_rate'],
                ]
            ]);

            // Check if the response status code is 201 (Created)
            if ($response->getStatusCode() === 201) {
                // Decode the JSON response into an associative array
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
                'error' => $e->getMessage()
            ];
        }
    }


    public function getCoursebyId($id){
        try{
            $response = $this->client->request('GET', $this->baseUrl . '/courses/' . $id, [
                'timeout' => 10,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                return $data;
            }
            return [
                'error' => 'Unexpected response status code: ' . $response->getStatusCode(),
            ];
        } catch (RequestException $e) {
            Log::error('API Request Failed: ' . $e->getMessage());
            return [
                'error' => 'Failed to fetch course data. Please try again later.',
            ];
        } catch (\Exception $e) {
            Log::error('Unexpected Error: ' . $e->getMessage());
            return [
                'error' => 'An unexpected error occurred. Please try again later.',
            ];
        }
    }


}