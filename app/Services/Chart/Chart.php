<?php

namespace App\Services\Chart;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class Chart
{
    /**
     * @param array $request
     * @return JsonResponse|array
     */
    public function handler(array $request): JsonResponse|array
    {
        try {
            return [
                "legend" => new \stdClass,
                "tooltip" => new \stdClass,
                "dataset" => $this->setDataset($request['name_dataset'], $request['value_dataset']),
                "xAxis" => $this->setAxis($request['x_axis']),
                "yAxis" => $this->setAxis($request['y_axis']),
                "series" => $this->setSeries($request['chart_type']),
            ];
        } catch (\Exception $e) {
            return Response::json(["status" => "error", "message" => $e], 500);
        }
    }

    /**
     * @param array $dataset
     * @return array
     */
    public function trimHandler(array $dataset): array
    {
        $data = null;
        foreach ($dataset as $val) {
            $data[] = str_replace(" ", "", $val);
        }
        return $data;
    }

    /**
     * @param $arr
     * @return int
     */
    public function advancedArrayCount($arr): int
    {
        $count = [];
        for ($j = 0; $j < count($arr); $j++) {
            $count[] = count($arr[$j]);
        }
        return max($count);
    }

    /**
     * @param array $datasetNames
     * @param array $datasetValues
     * @return JsonResponse|\stdClass
     */
    public function setDataset(array $datasetNames, array $datasetValues): JsonResponse|\stdClass
    {
        $datasetNameCounter = count($datasetNames);
        $datasetValueCounter = count($datasetValues);

        $dataset = new \stdClass();
//        $dataset->dimensions = $datasetNames;
        $dataset->source = array_fill(0, count($datasetNames),
            array_fill(0, $this->advancedArrayCount($datasetValues), 0)
        );
        if ($datasetNameCounter == $datasetValueCounter) {
            for ($x = 0; $x < $datasetNameCounter; $x++) {
                for ($y = 0; $y < $this->advancedArrayCount($datasetValues); $y++) {
                    is_int($datasetValues[$x][$y])
                        ? $dataset->source[$y][$x] = (int)$datasetValues[$x][$y]
                        : $dataset->source[$y][$x] = $datasetValues[$x][$y];
                }
            }
        } else {
            return Response::json([
                "status" => "error",
                "message" => "введено больше или меньше значений чем названий этих категорий"
            ], 500);
        }
        array_unshift($dataset->source, $datasetNames);
        return $dataset;
    }

    /**
     * @param array $data
     * @return \stdClass
     */
    public function setAxis(array $data): \stdClass
    {
        $axis = new \stdClass();
        $axis->type = 'value';

        if (!empty($data))
//        {
//            is_array($data)
//                ? $axis->data = $data
//                : $axis->data = explode(',', str_replace(' ', '', $data));
            $axis->type = 'category';
//        } else { $axis->type = 'value'; }

        return $axis;
    }

    /**
     * @param array $chartType
     * @return JsonResponse|array
     */
    public function setSeries(array $chartType): JsonResponse|array
    {
        try {
            $typeWithProperties = [];
            foreach ($chartType as $value) {
                $typeWithProperties[] = match ($value) {
                    "line" => ["type" => $value, "smooth" => false],
                    "pie" => ["type" => $value, "radius" => "30%"],
                    "bar" => ["type" => $value],
                    "scatter" => ["symbolSize" => 20, "type" => $value],
                    default => Response::json([
                        "status" => "error", "message" => "Данного типа диаграммы не существует!"
                    ], 409)
                };
            }
            return $typeWithProperties;
        } catch (\Exception $e) {
            return Response::json(["status" => "error", "message" => $e], 500);
        }
    }
}
