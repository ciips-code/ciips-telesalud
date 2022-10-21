<?php

namespace App\Services;

use App\Interfaces\JitsiService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Firebase\JWT\JWT;

class JitsiSelfHostedService implements JitsiService
{
    protected $baseUrl;
    protected $appID;
    protected $appSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.jitsi.base_url');
        $this->appID = config('services.jitsi.app_id');
        $this->appSecret = config('services.jitsi.app_secret');

        if(!$this->baseUrl || !$this->appID || !$this->appSecret)
            throw new \Exception('Missing Jitsi settings, check your .env and/or run php artisan config:cache');
    }


    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getToken($name, Carbon|CarbonImmutable $expiracion, $room, $esMedico)
    {
        //https://github.com/jitsi/lib-jitsi-meet/blob/master/doc/tokens.md
        $payload = [
            'context' => [
                'user' => [
                    'name' => $name
                ]
            ],
            'iss' => $this->appID,
            'room' => $room,
            'exp' => $expiracion->timestamp,
            'sub' => '*',
            'aud' => 'jitsi',
            'moderator' => $esMedico,
        ];

        return JWT::encode($payload, $this->appSecret, 'HS256');
    }
}
