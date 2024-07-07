<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}

    <title>Hello, world!</title>

    <style>
        .table {
            width: 10%;
            font-size: 15px;
            /* border-collapse: collapse; */
        }

        table,
        th,
        td {
            border: 2px solid black;
        }

        th,
        td {
            /* padding: auto; */
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">All User List</h1>

    {{-- <table class="table table-striped table-bordered table-hover my-3"> --}}
    <table class="table">
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

                    {{-- <td scope="row">{{ $user->hobbies }}</td> --}}
                    @php
                        $string_array = explode(', ', $user->hobbies);
                    @endphp
                    <td scope="row">
                        @foreach ($string_array as $item)
                            @php
                                echo $item . '<br>';
                            @endphp
                        @endforeach
                    </td>



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
                            {{-- <img src="{{ public_path('uploads/' . $uploads) }}" alt="img error" width="50"
                                class="img-thumbnail"> --}}
                            <img src="{{ 'uploads/' . $uploads }}" alt="img error" width="50" class="img-thumbnail">
                        @endforeach
                    </td>

                    <td scope="row">{{ $user->status }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
