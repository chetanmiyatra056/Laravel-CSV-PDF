@extends('frontend.layouts.main')

@section('main-container')
<div class="my-5">

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" id="alert">
        {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container my-3">
        <h1 class="text-center">All User List</h1>

        <div class="row my-3">
            <!-- <div class="me-5 mb-2 mb-lg-0 col">
                    <a href="{{ url('/export-csv') }}" class="btn btn-success btn" type="button">Export CSV</a>

                    <a href="{{ url('/export-pdf') }}" class="btn btn-info btn" type="button">PDF</a>
                </div> -->

            <form class="d-flex col-md-4" action=" ">
                <input class="form-control me-2" style="float:right;" type="text" name="search" id="search"
                    placeholder="Search" value="{{ $search }}">
                <!-- <button class="btn btn-outline-info mx-2" type="submit">Search</button> -->
                <a href="{{ url('/list') }}">
                    <button class="btn btn-outline-danger" type="button">Reset</button>
                </a>
            </form>
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
                    <th scope="col">Hobbies</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Type</th>
                    <th scope="col">Profile</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>

            <tbody id="user-table">
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
                        <img src="{{ 'uploads/' . $uploads }}" alt="img error" width="50" class="img-thumbnail">
                        @endforeach
                    </td>

                    <td scope="row">{{ $user->status }}</td>

                </tr>
                @endforeach
            </tbody>

        </table>

        <hr>

        <!-- <form action="{{ route('importCSV') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="fields col-md-4">
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="import_csv" name="import_csv" accept=".csv">
                    {{-- <label class="input-group-text" for="import_csv">Upload</label> --}}
                </div>
            </div>
            <button type="submit" class="btn btn-success">Import CSV</button>
        </form> -->

    </div>

    <script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let query = $(this).val();
            if (query.length === 0) {
                // location.reload();
                // $('#user-table').empty();
                $('#search').val('');
                document.getElementById('search').focus();
            } else {
                $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    type: "GET",
                    data: {
                        'query': query
                    },
                    success: function(data) {
                        let tableBody = $('#user-table');
                        tableBody.empty();
                        $.each(data, function(index, user) {
                            tableBody.append(`
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${user.name}</td>
                                            <td>${user.email}</td>
                                            <td>${user.countries}</td>
                                            <td>${user.states}</td>
                                            <td>${user.cities}</td>
                                            <td>${user.hobbies}</td>
                                            <td>${user.gender}</td>
                                            <td>${user.date_of_birth}</td>
                                            <td>${user.type}</td>
                                            // <td>${user.profile}</td>
                                            <td>${user.status}</td>
                                        </tr>
                                    `);
                        });
                    }
                });
            }
        });
    });
    </script>

</div>



@endsection