<?php

namespace App\Services\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class WargamingProvider extends AbstractProvider implements ProviderInterface
{
    protected $baseUrl = 'https://api.worldoftanks.eu';
    
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            $this->baseUrl . '/wot/auth/login/', 
            $state
        );
    }
    
    protected function getTokenUrl()
    {
        return $this->baseUrl . '/wot/auth/prolongate/';
    }
    
    protected function getCodeFields($state = null)
    {
        $fields = [
            'application_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
        ];

        if ($state) {
            $fields['state'] = $state;
        }

        return array_merge($fields, $this->parameters);
    }
    
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get($this->baseUrl . '/wot/account/info/', [
            'query' => [
                'application_id' => $this->clientId,
                'access_token' => $token,
            ],
        ]);
        
        return json_decode($response->getBody(), true);
    }
    
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['account_id'] ?? null,
            'nickname' => $user['nickname'] ?? null,
            'name' => $user['nickname'] ?? null,
            'email' => null,
            'avatar' => null,
        ]);
    }
}