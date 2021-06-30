<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    abstract public function getUrl();
    abstract public function setJsonStructure();

    public function setCorrectData($url, $data)
    {
        $this->json('GET', $url)
            ->assertStatus(200)
            ->assertJson(["status" => "success"])
            ->assertJsonStructure($data)
            ->dump();
    }

    public function setIncorrectData($url, $data)
    {
        $this->json('GET', $url)
            ->assertStatus(422)
            ->assertJson(["status" => "error"])
            ->assertJsonStructure($data)
            ->dump();
    }
}
