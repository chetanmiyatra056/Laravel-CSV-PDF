@extends('frontend.layouts.main')

@section('main-container')
    <div class="my-5">
        <div class="container my-3">
            <h1 class="text-center">All User List</h1>

            <div class="container">
                <a href="{{ url('/export-csv') }}" class="btn btn-primary btn" type="button">CSV</a>
                <a href="{{ url('/export-pdf') }}" class="btn btn-primary btn" type="button">PDF</a>
            </div>

            <table class="table table-striped table-dark table-bordered table-hover my-3">
                <thead>
                    <tr>
                        <th scope="col">Sr No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Country</th>
                        <th scope="col">State</th>
                        <th scope="col">City</th>
                        {{-- <th scope="col">Password</th> --}}
                        <th scope="col">Hobbies</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Type</th>
                        <th scope="col">Profile</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($users as $user)
                        @php
                            $count = $count + 1;
                        @endphp
                        <tr>
                            <th scope="row">
                                @php
                                    echo $count;
                                @endphp
                            </th>

                            <td scope="row">{{ $user->name }}</td>

                            <td scope="row">{{ $user->email }}</td>

                            @php
                                $country = DB::table('countries')
                                    ->where('id', $user->countries)
                                    ->first();
                            @endphp
                            <td scope="row">{{ $country->name }}</td>

                            @php
                                $state = DB::table('states')
                                    ->where('id', $user->states)
                                    ->first();
                            @endphp
                            <td scope="row">{{ $state->name }}</td>

                            @php
                                $cities = DB::table('cities')
                                    ->where('id', $user->cities)
                                    ->first();
                            @endphp

                            <td scope="row">{{ $cities->name }}</td>

                            <td scope="row">{{ $user->hobbies }}</td>

                            <td scope="row">{{ $user->gender }}</td>

                            <td scope="row">{{ $user->date_of_birth }}</td>

                            <td scope="row">{{ $user->type }}</td>

                            @php
                                $profiles = DB::table('profiles')
                                    ->where('user_id', $user->id)
                                    ->get();
                            @endphp

                            <td scope="row">
                                @foreach ($profiles as $item)
                                    @php
                                        $uploads = $item->upload;
                                    @endphp
                                    <img src="{{ 'uploads/' . $uploads }}" alt="img error" width="50"
                                        class="img-thumbnail">
                                @endforeach
                            </td>

                            <td scope="row">{{ $user->status }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
