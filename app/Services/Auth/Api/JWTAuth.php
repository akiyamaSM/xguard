<?php

namespace xguard\Services\Auth\Api;

class JWTAuth extends \Tymon\JWTAuth\JWTAuth
{
    use ExtendsJwtValidation;
}
