<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

trait TestUtilities
{
    protected $endpoint = null;

    protected function fieldIsPresent(string $field, string $endpoint = null, string $method = 'POST')
    {
        $url = $endpoint ?? $this->endpoint();

        $this
            ->json($method, $url, [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'required']);

        $this
            ->json($method, $url, [$field => null])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'required']);

        $this
            ->json($method, $url, [$field => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'required']);
    }

    protected function fieldIsUnique(string $field, Model $existing, string $databaseField = null, string $endpoint = null, string $method = 'POST')
    {
        $url = $endpoint ?? $this->endpoint();

        if (!$databaseField) $databaseField = $field;

        $this
            ->json($method, $url, [$field => $existing[$databaseField]])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'taken']);
    }

    protected function fieldValueIsInvalid(string $field, $invalidValue, string $endpoint = null, string $method = 'POST')
    {
        $url = $endpoint ?? $this->endpoint();

        $this
            ->json($method, $url, [$field => $invalidValue])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'invalid']);
    }

    private function endpoint()
    {
        if (!$this->endpoint) throw new Exception('Endpoint not provided.');

        return $this->endpoint;
    }
}
