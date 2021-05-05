<?php

namespace Sfneal\Honeypot\Tests\Feature;

use Sfneal\Honeypot\Responders\HoneyCaughtResponder;
use Sfneal\Honeypot\Tests\TestCase;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class ConfigTest extends TestCase
{
    /** @test */
    public function name_field_name()
    {
        $expected = 'my_name';
        $output = config('honeypot.name_field_name');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function randomize_name_field_name()
    {
        $output = config('honeypot.randomize_name_field_name');

        $this->assertIsBool($output);
        $this->assertTrue($output);
    }

    /** @test */
    public function valid_from_field_name()
    {
        $expected = 'valid_from';
        $output = config('honeypot.valid_from_field_name');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function amount_of_seconds()
    {
        $expected = 1;
        $output = config('honeypot.amount_of_seconds');

        $this->assertIsInt($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function respond_to_spam_with()
    {
        $expected = HoneyCaughtResponder::class;
        $output = config('honeypot.respond_to_spam_with');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);

        $responder = new $output();
        $this->assertInstanceOf(HoneyCaughtResponder::class, $responder);
        $this->assertInstanceOf(SpamResponder::class, $responder);
    }

    /** @test */
    public function enabled()
    {
        $output = config('honeypot.enabled');

        $this->assertIsBool($output);
        $this->assertTrue($output);
    }
}
