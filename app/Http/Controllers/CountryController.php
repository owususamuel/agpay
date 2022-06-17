<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;

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
                'iso_code' => $data['iso_code'],
                'iso_numeric_code' => $data['iso_numeric_code'],
                'common_name' => $data['common_name'],
                'official_name' => $data['official_name'],
                'symbol' => $data['symbol']
            ]);
        }

        //return to_route('user.create');
        $rows_count = count($records);
        return response()->json([
            'message' => "$rows_count currency records successfully uploaded"
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

    // public function uploadContent(Request $request)
    // {
    //     $file = $request->file('uploaded_file');
    //     if ($file) {
    //         $filename = $file->getClientOriginalName();
    //         $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
    //         $tempPath = $file->getRealPath();
    //         $fileSize = $file->getSize(); //Get size of uploaded file in bytes
    //         //Check for file extension and size
    //         $this->checkUploadedFileProperties($extension, $fileSize);
    //         //Where uploaded file will be stored on the server 
    //         $location = 'uploads'; //Created an "uploads" folder for that
    //         // Upload file
    //         $file->move($location, $filename);
    //         // In case the uploaded file path is to be stored in the database 
    //         $filepath = public_path($location . "/" . $filename);
    //         // Reading file
    //         $file = fopen($filepath, "r");
    //         $importData_arr = array(); // Read through the file and store the contents as an array
    //         $i = 0;
    //         //Read the contents of the uploaded file 
    //         while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
    //             $num = count($filedata);
    //             // Skip first row (Remove below comment if you want to skip the first row)
    //             if ($i == 0) {
    //                 $i++;
    //                 continue;
    //             }
    //             for ($c = 0; $c < $num; $c++) {
    //                 $importData_arr[$i][] = $filedata[$c];
    //             }
    //             $i++;
    //         }
    //         fclose($file); //Close after reading
    //         $j = 0;
    //         foreach ($importData_arr as $importData) {
    //             $name = $importData[1]; //Get user names
    //             $email = $importData[3]; //Get the user emails
    //             $j++;
    //             try {
    //                 DB::beginTransaction();
    //                 Country::create([
    //                     'name' => $importData[1],
    //                     'club' => $importData[2],
    //                     'email' => $importData[3],
    //                     'position' => $importData[4],
    //                     'age' => $importData[5],
    //                     'salary' => $importData[6]
    //                 ]);
    //                 //Send Email
    //                 //$this->sendEmail($email, $name);
    //                 DB::commit();
    //             } catch (\Exception $e) {
    //                 //throw $th;
    //                 DB::rollBack();
    //             }
    //         }
    //         return response()->json([
    //             'message' => "$j records successfully uploaded"
    //         ]);
    //     } else {
    //         //no file was uploaded
    //         throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
    //     }
    // }
    // public function checkUploadedFileProperties($extension, $fileSize)
    // {
    //     $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
    //     $maxFileSize = 2097152; // Uploaded file size limit is 2mb
    //     if (in_array(strtolower($extension), $valid_extension)) {
    //         if ($fileSize <= $maxFileSize) {
    //         } else {
    //             throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
    //         }
    //     } else {
    //         throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
    //     }
    // }
    // public function sendEmail($email, $name)
    // {
    //     $data = array(
    //         'email' => $email,
    //         'name' => $name,
    //         'subject' => 'Welcome Message',
    //     );
    //     Mail::send('welcomeEmail', $data, function ($message) use ($data) {
    //         $message->from('welcome@myapp.com');
    //         $message->to($data['email']);
    //         $message->subject($data['subject']);
    //     });
    // }
}
