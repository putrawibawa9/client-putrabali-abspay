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

         public function getAllTeachers($page)
    {
        try {
            // dd($page);
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . "/teachers?page=$page", [
                'timeout' => 10, // Set a timeout for the request
                
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
     try{
 $this->client->request('POST', $this->baseUrl . '/teachers', [
            'timeout' => 10, // Set a timeout for the request
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'name' => $data['name'],
                'alias' => $data['alias'],
                'username' => $data['username'],
                'password' => $data['password'],
            ],
        ]);
     }catch(RequestException $e){
  $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            return $error;
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

    public function getTeacherByID($id){
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . '/teachers/'.$id, [
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

     public function updateTeacher($id, $data)
    {

        // dd($data);
       try{
          $data['_method'] = 'PUT'; // Add the method override
         $response = $this->client->post("$this->baseUrl/teachers/{$id}", [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => $data
        ]);
       }catch(RequestException $e){

        // return error to Controller
        
        $error = $e->getResponse()->getBody()->getContents();
        // get the error message
        $error = json_decode($error, true);
        return $error;
       }
    }

       public function searchTeacherByNameOrAlias($search, $page){
      
        try {
            // Make the API request
            $response = $this->client->request('GET', $this->baseUrl . "/teachers-search?search=$search&page=$page", [
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