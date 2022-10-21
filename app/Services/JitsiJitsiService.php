<?php

namespace App\Services;

use App\Interfaces\JitsiService;
use Carbon\CarbonImmutable;

class JitsiJitsiService implements JitsiService
{


    public function getBaseUrl()
    {
        return 'https://meet.jit.si/';
    }


    public function getToken($name, CarbonImmutable $expiracion, $room, $esMedico)
    {
        return null;
    }
}
