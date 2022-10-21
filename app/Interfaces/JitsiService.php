<?php

namespace App\Interfaces;

use Carbon\CarbonImmutable;

interface JitsiService
{

    public function getBaseUrl();

    public function getToken($name, CarbonImmutable $expiracion, $room, $esMedico);


}
