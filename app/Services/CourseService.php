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

     public function getAllCourses($page)
    {
        
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . "/courses?page=$page", [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() === 200) {
                // Decode the JSON response into an associative array
                $data = json_decode($response->getBody()->getContents(), true);
                    // dd($data);
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
     public function getCourseBySubject($subject)
    {
    
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . "/courses-search?subject=$subject", [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() === 200) {
                // Decode the JSON response into an associative array
                $data = json_decode($response->getBody()->getContents(), true);
                    // dd($data);
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
    public function search($data, $page){
    // Extract and filter out null or empty values
   
    $queryParams = array_filter([
        'level' => $data['level'] ?? null,
        'section' => $data['section'] ?? null,
        'subject' => $data['subject'] ?? null,
        'page' => $page
    ]);
    // dd($queryParams);

        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . "/courses-search?".http_build_query($queryParams), [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
             
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

        } catch (RequestException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            return $error;
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected Error: ' . $e->getMessage());

            // Return a generic error message
            return [
                'error' => $e->getMessage()
            ];
        }
    }


      public function recapMeetings($id){
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/meetings/recap/' . $id, [
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

     public function updateCourse($id, $data)
    {
       try{
          $data['_method'] = 'PUT'; // Add the method override
         $this->client->post("$this->baseUrl/courses/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => $data
        ]);
       }catch(RequestException $e){
        // dd($e->getResponse()->getBody()->getContents());
        // return error to Controller
        
        $error = $e->getResponse()->getBody()->getContents();
        // get the error message
        $error = json_decode($error, true);
        return $error;
       }
    }


}