<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Session;

class AuthenticationService
{
    protected $client;
    protected $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
         $this->baseUrl = config('services.api.base_url');
    }

   public function login($data){
;
     try{
    $reponse =  $this->client->request('POST', $this->baseUrl . '/admin/login', [
            'timeout' => 10, // Set a timeout for the request
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'name' => $data['name'],
                'password' => $data['password'],
            ],
        ]);
        // return user data as json
        $user = json_decode($reponse->getBody()->getContents(), true);
        // dd($user);
        return $user;
     }catch(RequestException $e){
        // dd($e->getResponse()->getBody()->getContents());
            return false;
     }
    }


   public function register($credentials){
    // dd($credentials);
        try {
            // Make the API request
            $response = $this->client->request('POST', $this->baseUrl . '/admin/register', [
                'timeout' => 10, // Set a timeout for the request
                'headers' => [
                    'Accept' => 'application/json',
                ],
              'json' => [
                    'name' => $credentials['name'],
                    'email' => $credentials['email'],
                    'password' => $credentials['password']
                    ]
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
             $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            dd($error);
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected Error: ' . $e->getMessage());
            dd($e->getMessage());
            // Return a generic error message
            return [
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Unexpected Error: ' . $e->getMessage());
        dd($e->getMessage());
            // Return a generic error message
            return [
                'error' => $e->getMessage(),
            ];
        }

   }
}