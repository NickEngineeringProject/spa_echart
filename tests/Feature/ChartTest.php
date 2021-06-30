<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChartTest extends TestCase
{
    /**
     * 1. объявляем входные параметры
     * @return string[]
     */
    public function getUrl(): array
    {
        return [
            "correct" => "api/v1/fusion/overdue/1",
            "incorrect" => "api/v1/fusion/overdue/0"
        ];
    }

    /**
     * и выходные параметры т.е. ожидаемый результат
     * @return array[]
     */
    public function setJsonStructure(): array
    {
        return [
            "correct" => ['status', 'data' => ['*' => ['NAME', 'REQ_OVERDUE_CNT', 'REQ_DONE_NA', 'REQ_CLOSED']]],
            "incorrect" => ['status', 'data' => []]
        ];
    }

    /**
     * 2. проводим тестирование
     * 3. сравниваем на 2 шаге результат с ожидаемым на 1
     */
    public function testSettingCorrectData() {
        parent::setCorrectData($this->getUrl()["correct"], $this->setJsonStructure()["correct"]);
    }

    public function testSettingInCorrectData() {
        parent::setIncorrectData($this->getUrl()["incorrect"], $this->setJsonStructure()["incorrect"]);
    }
}
