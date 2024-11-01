<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class StudentService
{
    protected $client;
    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }

    public function getStudentById($id){
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/students/' . $id, [
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
                'error' => 'Failed to fetch student. Please try again later.',
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


     public function getAllStudents()
    {
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/students', [
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

   public function addNewStudent($data)
    {

     $response = $this->client->request('POST', $this->baseUrl . '/students', [
            'timeout' => 10, // Set a timeout for the request
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'name' => $data['name'],
                'wa_number' => $data['wa_number'],
                'gender' => $data['gender'],
                'school' => $data['school'],
                'enroll_date' => $data['enroll_date'],
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

    public function updateStudent($id, $data)
    {
       try{
         $response = $this->client->patch("$this->baseUrl/students/{$id}", [
            'json' => $data
        ]);

        return true;
       }catch(RequestException $e){
           // Handle any errors
        return response()->json([
            'error' => 'Failed to update student',
            'message' => $e->getMessage()
        ], 500);
       }
    }

}