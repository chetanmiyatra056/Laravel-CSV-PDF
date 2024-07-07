@extends('frontend.layouts.main')

@section('main-container')
    <div class="my-5">

        @if (session()->has('error'))
            <div class="alert alert-success alert-dismissible fade show" id="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container my-3">
            <h1 class="text-center">Register Form</h1>

            <form method="POST" action="{{ url('/') }}/register" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    <span class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        value="{{ old('password') }}">
                    <span class="text-danger">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                    </i>
                </div>

                <div class="form-group mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                        value="{{ old('confirm_password') }}">
                    <span class="text-danger">
                        @error('confirm_password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select name="countries" id="countries" class="form-control">
                        <option value="">Select Country</option>
                        @foreach ($counteries as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">
                        @error('countries')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="inputState">State</label>
                    <select name="states" id="states" class="form-control">
                        <option value="">Select State</option>
                    </select>
                    <span class="text-danger">
                        @error('states')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="inputState">City</label>
                    <select name="cities" id="cities" class="form-control">
                        <option value="">Select City</option>
                    </select>
                    <span class="text-danger">
                        @error('cities')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label class="form-check-label my-2" for="checkhobbie">Select Hobbies</label><br>

                    <input class="form-check-input mx-2" type="checkbox" name="hobbies[]" value="reading">
                    <label class="form-check-label" for="reading">
                        Reading
                    </label>

                    <input class="form-check-input mx-2" type="checkbox" name="hobbies[]" value="writting">
                    <label class="form-check-label" for="writting">
                        Writting
                    </label>

                    <input class="form-check-input mx-2" type="checkbox" name="hobbies[]" value="gaming">
                    <label class="form-check-label" for="gaming">
                        Gaming
                    </label>
                    <br>
                    <span class="text-danger">
                        @error('hobbies')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group-check mb-3">

                    <label class="form-check-label my-2" for="gender">Select Gender</label><br>

                    <input class="form-check-input mx-2" type="radio" value="male" name="gender">
                    <label class="form-check-label" for="male">
                        Male
                    </label>

                    <input class="form-check-input mx-2" type="radio" value="female" name="gender">
                    <label class="form-check-label" for="female">
                        Female
                    </label>

                    <input class="form-check-input mx-2" type="radio" value="other" name="gender">
                    <label class="form-check-label" for="other">
                        Other
                    </label>
                    <br>
                    <span class="text-danger">
                        @error('gender')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="date" class="form-label">Select Date Of Birth</label>

                    <input type="date" min="2000-01-01" data-date="" data-date-format="DD/MM/YYYY"
                        class="input form-control datepicker" name="date" id="date" placeholder="DD/MM/YYYY">

                    <span class="text-danger">
                        @error('date')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="type">Type</label>
                    <select class="form-select" name="type" id="type">
                        <option value="">Select your type</option>
                        <option value="seller">Seller</option>
                        <option value="user">User</option>
                    </select>
                    <span class="text-danger">
                        @error('type')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="profile" class="form-label">Choose Profile</label>
                    <input class="form-control" type="file" name="profile[]" id="profile" multiple>
                    <input class="form-control" type="text" name="status" id="status" value="0" hidden>
                    <span class="text-danger">
                        @error('profile')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button type="submit" name="add" id="add" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            var today = new Date().toISOString().split('T')[0];
            document.getElementById("date").setAttribute("max", today);

            const alert = document.getElementById('alert');
            setTimeout(() => {
                $('#alert').alert('close')
            }, 2000)

            $('#countries').change(function(event) {
                var idCountry = this.value;
                $('#states').html('');

                $.ajax({
                    url: "/api/fetch-state",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        country_id: idCountry,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#states').html('<option value="">Select State</option>');
                        $.each(response.states, function(index, val) {
                            $('#states').append('<option value="' + val.id + '"> ' +
                                val.name + ' </option>')
                        });
                        $('#cities').html('<option value="">Select City</option>');
                    }
                })
            });

            $('#states').change(function(event) {
                var idState = this.value;
                $('#cities').html('');
                $.ajax({
                    url: "/api/fetch-cities",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        state_id: idState,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#cities').html('<option value="">Select City</option>');
                        $.each(response.cities, function(index, val) {
                            $('#cities').append('<option value="' + val.id + '"> ' +
                                val.name + ' </option>')
                        });
                    }
                })
            });

        });
    </script>

    <script>
        $(".datepicker").on("change", function() {
            this.setAttribute(
                "data-date",
                moment(this.value, "YYYY-MM-DD")
                .format(this.getAttribute("data-date-format"))
            )
        }).trigger("change")
    </script>
@endsection
