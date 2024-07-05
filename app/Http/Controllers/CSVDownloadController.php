<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CSVDownloadController extends Controller
{
    public function exportCSV()
    {
        $filename = 'employee-data.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'id',
                'name',
                'email',
                'countries',
                'states',
                'cities',
                'hobbies',
                'gender',
                'date_of_birth',
                'type',
                // 'password',
                'profile',
                'status',
            ]);

            // Fetch and process data in chunks
            User::chunk(25, function ($employees) use ($handle) {
                foreach ($employees as $employee) {

                    $country = DB::table('countries')
                        ->where('id', $employee->countries)
                        ->first();

                    $state = DB::table('states')
                        ->where('id', $employee->states)
                        ->first();

                    $cities = DB::table('cities')
                        ->where('id', $employee->cities)
                        ->first();

                    $profiles = DB::table('profiles')
                        ->where('user_id', $employee->id)
                        ->get();


                    // $uploads = [];
                    foreach ($profiles as $item) {
                        $uploads =  implode(", ", $item->upload);
                        // $uploads =  $item->upload;
                        // }

                        // echo $uploads;

                        // Extract data from each employee.
                        $data = [
                            isset($employee->id) ? $employee->id : '',
                            isset($employee->name) ? $employee->name : '',
                            isset($employee->email) ? $employee->email : '',
                            isset($country->name) ? $country->name : '',
                            isset($state->name) ? $state->name : '',
                            isset($cities->name) ? $cities->name : '',
                            isset($employee->hobbies) ? $employee->hobbies : '',
                            isset($employee->gender) ? $employee->gender : '',
                            isset($employee->date_of_birth) ? $employee->date_of_birth : '',
                            isset($employee->type) ? $employee->type : '',

                            // isset($employee->password) ? $employee->password : '',

                            // isset($uploads) ? $uploads : '',
                            isset($employee->profile) ? implode(', ', $item->upload) : '',
                            isset($employee->status) ? $employee->status : '',

                            // isset($employee->type) ? implode(", ", json_decode($employee->skills)) : '',

                        ];

                        // Write data to a CSV file.
                        fputcsv($handle, $data);
                    }
                }
            });

            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }

    public function downloadPDF() {
        // $show = Disneyplus::find($id);
        $users = User::all();
        $pdf = PDF::loadView('frontend.pdf',compact('users'));

        return $pdf->download('receipt.pdf');
}
}
