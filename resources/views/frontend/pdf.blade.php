<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center">All User List</h1>

        <table class="table table-striped table-bordered table-hover my-3">
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
                                <img src="{{ public_path('/uploads/' . $uploads) }}" alt="img error" width="50"
                                    class="img-thumbnail">
                            @endforeach
                        </td>

                        <td scope="row">{{ $user->status }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
