<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    private $rows = [];
    
    public function uploadContent(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        $records = array_map('str_getcsv', file($path));

        if (! count($records) > 0) {
           return 'Error...';
        }

        // Get field names from header column
        $fields = array_map('strtolower', $records[0]);

        // Remove the header column
        array_shift($records);

        foreach ($records as $record) {
            if (count($fields) != count($record)) {
                return 'csv_upload_invalid_data';
            }

            // Decode unwanted html entities
            $record =  array_map("html_entity_decode", $record);

            // Set the field name as key
            $record = array_combine($fields, $record);

            // Get the clean data
            $this->rows[] = $this->clear_encoding_str($record);
        }

        foreach ($this->rows as $data) {
            Country::create([
                'continent_code' => $data['continent_code'],
                'currency_code' => $data['iso2_code'],
                'iso3_code' => $data['iso3_code'],
                'fips_code' => $data['fips_code'],
                'calling_code' => $data['calling_code'],
                'calling_code' => $data['calling_code'],
                'common_name' => $data['common_name'],
                'official_name' => $data['official_name'],
                'endonym' => $data['endonym'],
                'demonym' => $data['demonym'],
            ]);
        }

        //return to_route('user.create');
        $rows_count = count($records);
        return response()->json([
            'message' => "$rows_count country records successfully uploaded"
        ]);
    }
    
    private function clear_encoding_str($value)
    {
        if (is_array($value)) {
            $clean = [];
            foreach ($value as $key => $val) {
                $clean[$key] = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
            }
            return $clean;
        }
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

}
