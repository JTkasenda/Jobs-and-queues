<?php

namespace App\Http\Controllers;

use App\Jobs\SalesCsvProcess;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    //

    public function index()
    {
        return view('upload-file');
    }

    public function upload()
    {
        if (request()->has('mycsv')) {
            // $data = array_map('str_getcsv', file(request()->mycsv));
            $data = file(request()->mycsv);

            //Chunking file
            $chunks = array_chunk($data, 1000);
            $path = resource_path('temp');
            foreach ($chunks as $key => $chunk) {
                $name = "/temp{$key}.csv";
                // return $path.$name;
                file_put_contents($path . $name, $chunk);
            }

            $files = glob("$path/*.csv");
            $header = [];
            foreach ($files as $key => $file) {
                $data = array_map('str_getcsv', file($file));
                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                SalesCsvProcess::dispatch($data, $header);

                unlink($file);
            }
            return "Done";
        } else {
            return "Please upload file";
        }
    }
}
