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

    public function loginTeacher($data){
       
     try{
    $reponse =  $this->client->request('POST', $this->baseUrl . '/teacher/login', [
            'timeout' => 10, // Set a timeout for the request
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'username' => $data['username'],
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

 
}