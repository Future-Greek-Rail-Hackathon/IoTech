<?php

declare(strict_types=1);

namespace App\Charts;

use BaoPham\DynamoDb\Facades\DynamoDb;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class TemperatureChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $thing_dynamo_query = DynamoDb::table('thingpark-data')
            ->setKeyConditionExpression('DevEUI = :DevEUI')
            ->setExpressionAttributeValue(':DevEUI', DynamoDb::marshalValue('0004A30B001FB325'))
            ->setLimit(100)
            ->prepare()
            ->query();

        $thing_collection = collect($thing_dynamo_query['Items']);
        $thing_data = $thing_collection->map(function ($item, $key) {
            return $item['payload_hex']['S'];
        });

        $time_data = $thing_collection->map(function ($item, $key) {
            return $item['Time']['S'];
        });

        $temperature_data = $thing_data->map(function ($item, $key) {
            return floatval(explode(';', hex2bin($item))[0]);
        });
        
        return Chartisan::build()
            ->labels($time_data->toArray())
            ->dataset('Temperature', $temperature_data->toArray());
    }
}
