@extends('frontend.layouts.main')

@section('main-container')
    <div class="my-5">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" id="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container my-2">
            <div class="p-5 mb-4 my-5 text-light bg-dark rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Welcome to User {{ Auth::User()->email }}</h1>
                    <?php
                    
                    $record = DB::table('profiles')
                        ->where('user_id', Auth::User()->id)
                        ->get();
                    ?>
                    <hr>
                    <div class="profile-image">
                        @foreach ($record as $value)
                            @php
                                $uploads = $value->upload;
                            @endphp
                            <img src="{{ 'uploads/' . $uploads }}" alt="img error" width="100" class="img-thumbnail">
                        @endforeach
                    </div>
                    <hr>
                    <div>
                        @php
                            $data = DB::table('users')
                                ->select(
                                    'countries.name as countries_name',
                                    'states.name as states_name',
                                    'cities.name as cities_name',
                                )
                                ->join('countries', 'users.countries', '=', 'countries.id')
                                ->join('states', 'users.states', '=', 'states.id')
                                ->join('cities', 'users.cities', '=', 'cities.id')
                                ->where('users.id', Auth::User()->id)
                                ->first();
                        @endphp

                        <h3>Country :- {{ $data->countries_name }}</h3>
                        <hr>
                        <h3>State :- {{ $data->states_name }}</h3>
                        <hr>
                        <h3>City :- {{ $data->cities_name }}</h3>
                    </div>
                    <hr>
                    <div>
                        <h3>Hobbies :- @php
                            $hobbies = explode(',', Auth::User()->hobbies);
                            if (in_array('reading', $hobbies)) {
                                echo 'Reading ';
                            }
                            if (in_array('writting', $hobbies)) {
                                echo 'Writting ';
                            }
                            if (in_array('gaming', $hobbies)) {
                                echo 'Gaming ';
                            }
                        @endphp
                        </h3>
                    </div>
                    <hr>
                    <div>
                        {{-- <h3 class="date">Date of Birth :- {{ Auth::User()->date_of_birth }}</h3> --}}
                        <h3 class="date">Date of Birth :- @php
                             $newDate = date("d-m-Y", strtotime(Auth::User()->date_of_birth));
                             echo $newDate;
                        @endphp</h3>
                    </div>
                    <hr>
                    <div>
                        <h3>Gender :- {{ ucfirst(trans(Auth::User()->gender)) }}</h3>
                    </div>
                    <hr>
                    <div>
                        <h3>Type :- {{ ucfirst(trans(Auth::User()->type)) }}</h3>
                    </div>
                    <hr>
                    <form action="{{ url('/logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-lg" type="submit">LogOut</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        const alert = document.getElementById('alert');
        setTimeout(() => {
            $('#alert').alert('close')
        }, 2000)
    </script>
@endsection
