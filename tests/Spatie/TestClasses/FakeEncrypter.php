<?php

namespace Sfneal\Honeypot\Tests\Spatie\TestClasses;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Support\Str;

class FakeEncrypter implements Encrypter
{
    public function encrypt($value, $serialize = true)
    {
        return $value.'-encrypted';
    }

    public function decrypt($payload, $unserialize = true)
    {
        return Str::before($payload, '-encrypted');
    }
}
