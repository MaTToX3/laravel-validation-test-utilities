<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;

trait TestUtilities
{
    protected $endpoint;

    protected function fieldIsPresent(string $field, string $method = 'POST')
    {
        $this
            ->json($method, $this->endpoint, [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'required']);

        $this
            ->json($method, $this->endpoint, [$field => null])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'required']);

        $this
            ->json($method, $this->endpoint, [$field => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'required']);
    }

    protected function fieldIsUnique(string $field, Model $existing, string $databaseField = null, string $method = 'POST')
    {
        if (!$databaseField) $databaseField = $field;

        $this
            ->json($method, $this->endpoint, [$field => $existing[$databaseField]])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'taken']);
    }

    protected function fieldValueIsInvalid(string $field, $invalidValue, string $method = 'POST')
    {
        $this
            ->json($method, $this->endpoint, [$field => $invalidValue])
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field => 'invalid']);
    }
}
