<?php

namespace App\Http\Controllers;

use App\Models\Profile;
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
                'profile',
                'status',
            ]);

            // Fetch and process data in chunks
            User::chunk(
                25,
                function ($employees) use ($handle) {
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

                        $uploads = $profiles->pluck('upload')->toArray();
                        $uploadsString = implode(", ", $uploads);

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
                            $uploadsString,
                            isset($employee->status) ? $employee->status : '',
                        ];
                        fputcsv($handle, $data);
                    }
                }
            );
            fclose($handle);
        }, 200, $headers);
    }

    
    public function downloadPDF()
    {
        // $show = Disneyplus::find($id);
        $users = User::all();
        $pdf = PDF::loadView('frontend.pdf', compact('users'));

        return $pdf->download('receipt.pdf');
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'import_csv' => 'required|mimes:csv',
        ]);
        //read csv file and skip data
        $file = $request->file('import_csv');
        $handle = fopen($file->path(), 'r');

        //skip the header row
        fgetcsv($handle);

        $chunksize = 25;
        while (!feof($handle)) {
            $chunkdata = [];

            for ($i = 0; $i < $chunksize; $i++) {
                $data = fgetcsv($handle);
                if ($data === false) {
                    break;
                }
                $chunkdata[] = $data;
            }

            $this->getchunkdata($chunkdata);
        }
        fclose($handle);

        return redirect()->route('list')->with('success', 'Data has been added successfully.');
    }

    public function getchunkdata($chunkdata)
    {
        foreach ($chunkdata as $column) {
            $id = $column[0];
            $name = $column[1];
            $email = $column[2];
            $countries = $column[3];
            $states = $column[4];
            $cities = $column[5];
            $hobbies = $column[6];
            $gender = $column[7];
            $date_of_birth = $column[8];
            $type = $column[9];
            $profile = $column[10];
            $status = $column[11];


            //create new employee
            $user = new User();
            $user->id = $id;
            $user->name = $name;
            $user->email = $email;

            $country = DB::table('countries')->where('name', $countries)->first();
            $user->countries = $country->id;

            $state = DB::table('states')->where('name', $states)->first();
            $user->states = $state->id;

            $cities = DB::table('cities')->where('name', $cities)->first();
            $user->cities = $cities->id;

            $user->hobbies =  $hobbies;
            $user->gender = $gender;
            $user->date_of_birth = $date_of_birth;
            $user->type = $type;
            $user->status = $status;

            $destination_array = explode(', ', $profile);

            foreach ($destination_array as $value) {

                $user->save();

                Profile::create([
                    'upload' => $value,
                    'user_id' => $id,
                ]);
            }
        }
    }
}
