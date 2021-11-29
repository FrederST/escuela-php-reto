<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    protected $seed = true;

    public function test_get_currencies()
    {
        $response = $this->getJson('/api/currency');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_cant_convert_case1()
    {
        $response = $this->get('/api/currency/convert?from=USD&to=COP&value=1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->where('COP', 4007)->etc()
        );
    }

    public function test_cant_convert_case2()
    {
        $response = $this->get('/api/currency/convert?from=COP&to=USD&value=1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->where('USD', 0.0002495632642874969)->etc()
        );
    }

    public function test_cant_convert_case3()
    {
        $response = $this->get('/api/currency/convert?from=ARS&to=COP&value=1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->where('COP', 403868.062424)->etc()
        );
    }

    public function test_not_found_currency()
    {
        $response = $this->get('/api/currency/convert?from=USD&to=UUU&value=1');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_cant_convert_multiple_currencies()
    {
        $response = $this->get('/api/currency/convertMultiple?from=ARS&to=COP,USD&value=1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->where('0.COP', 403868.062424)
            ->where('1.USD', 0.009921556995495375)
            ->etc()
        );
    }

    public function test_cant_convert_multiple_currencies_null_values()
    {
        $response = $this->get('/api/currency/convertMultiple?from=ARS&to=COP,UUU&value=1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(
            fn (AssertableJson $json) => $json->where('0.COP', 403868.062424)
            ->where('1', null)
            ->etc()
        );
    }

    public function test_validates_request_from(): void
    {
        $response = $this->get('/api/currency/convert?from=SSSD&to=COP&value=1');
        $response->assertSessionHasErrors(['from']);
    }

    public function test_validates_request_value(): void
    {
        $response = $this->get('/api/currency/convert?from=SSS&to=COP&value=uno');
        $response->assertSessionHasErrors(['value']);
    }
}
