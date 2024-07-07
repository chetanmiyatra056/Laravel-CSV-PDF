@extends('frontend.layouts.main')

@section('main-container')
    <div class="my-5">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" id="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" id="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container my-3">
            <h1 class="text-center">Profile Form</h1>

            {{-- action="{{ url('/edit') }}/{{ Auth::User()->id }}" --}}

            <form method="POST" action="{{ url('/edit') }}/{{ Auth::User()->id }}" id="fileUpload"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Username</label>
                    <input type="text" class="form-control" name="name" id="name"
                        value="{{ Auth::User()->name }}">
                    <span class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="mb-3">
                    <label for="pic" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email"
                        value="{{ Auth::user()->email }}">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="country" class="form-label">Country</label>
                    @php
                        $country = DB::table('countries')
                            ->where('id', Auth::user()->countries)
                            ->first();
                    @endphp
                    <select name="countries" id="countries" class="form-control">
                        <option value="{{ Auth::user()->countries }}">{{ $country->name }}</option>
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
                    @php
                        $allstates = DB::table('states')
                            ->where('country_id', Auth::user()->countries)
                            ->get();

                        $states = DB::table('states')
                            ->where('id', Auth::user()->states)
                            ->first();
                    @endphp
                    <select name="states" id="states" class="form-control">
                        <option value="{{ Auth::user()->states }}">{{ $states->name }}</option>
                        @foreach ($allstates as $items)
                            <option value="{{ $items->id }}">{{ $items->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">
                        @error('states')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="inputState">City</label>
                    @php
                        $allcities = DB::table('cities')
                            ->where('state_id', Auth::user()->states)
                            ->get();

                        $cities = DB::table('cities')
                            ->where('id', Auth::user()->cities)
                            ->first();

                    @endphp
                    <select name="cities" id="cities" class="form-control">
                        <option value="{{ Auth::user()->cities }}">{{ $cities->name }}</option>

                        @foreach ($allcities as $items)
                            <option value="{{ $items->id }}">{{ $items->name }}</option>
                        @endforeach

                    </select>
                    <span class="text-danger">
                        @error('cities')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label class="form-check-label my-2" for="checkhobbie">Select Hobbies</label><br>

                    <input class="form-check-input mx-2" type="checkbox" value="reading" name="hobbies[]" id="hobbies"
                        @php
$hobbies = explode(",", Auth::User()->hobbies);
                    
                            if (in_array("reading", $hobbies )) {
                                echo 'checked';
                            } @endphp>
                    <label class="form-check-label" for="reading">
                        Reading
                    </label>

                    <input class="form-check-input mx-2" type="checkbox" value="writting" name="hobbies[]" id="hobbies"
                        @php
if (in_array("writting", $hobbies )) {
                                echo 'checked';
                            } @endphp>
                    <label class="form-check-label" for="writting">
                        Writting
                    </label>

                    <input class="form-check-input mx-2" type="checkbox" value="gaming" name="hobbies[]" id="hobbies"
                        @php
if (in_array("gaming", $hobbies )) {
                                echo 'checked';
                            } @endphp>
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

                    <input class="form-check-input mx-2" type="radio" value="male" name="gender" id="gender"
                        @php
if (Auth::User()->gender == 'male') {
                                                echo "checked";
                                            } @endphp>
                    <label class="form-check-label" for="male">
                        Male
                    </label>

                    <input class="form-check-input mx-2" type="radio" value="female" name="gender" id="gender"
                        @php
if (Auth::User()->gender == 'female') {
                                                echo "checked";
                                            } @endphp>
                    <label class="form-check-label" for="female">
                        Female
                    </label>

                    <input class="form-check-input mx-2" type="radio" value="other" name="gender" id="gender"
                        @php
if (Auth::User()->gender == 'other') {
                                                echo "checked";
                                            } @endphp>
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

                    <div class="input-group date">

                        <input type="date" min="2000-01-01" data-date="" data-date-format="DD/MM/YYYY"
                            class="input form-control datepicker" name="date" id="date"
                            value="{{ Auth::User()->date_of_birth }}">

                        <span class="text-danger">
                            @error('date')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="type">Type</label>
                    <select class="form-select" name="type" id="type">
                        {{-- <option value="{{Auth::User()->type}}">{{ucfirst(trans(Auth::User()->type))}}</option> --}}
                        <option value="seller"
                            @php
if (Auth::User()->type == 'seller') {
                                                echo "selected";
                                            } @endphp>
                            Seller</option>
                        <option value="user"
                            @php
if (Auth::User()->type == 'user') {
                                            echo "selected";
                                        } @endphp>
                            User</option>
                    </select>
                    <span class="text-danger">
                        @error('type')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="old_profile" class="form-label">Current Profile</label><br>

                    <?php
                    $record = DB::table('profiles')
                        ->where('user_id', Auth::User()->id)
                        ->get();
                    
                    // print_r($uploads);
                    
                    ?>
                    <div class="profile-image">
                        @foreach ($record as $value)
                            @php
                                $uploads = $value->upload;
                            @endphp
                            <div class="">
                                <img src="{{ 'uploads/' . $uploads }}" alt="img error" width="100"
                                    class="img-thumbnail">
                                <input type="file" class="current_profile" name="current_profile[]"
                                    id="current_profile" hidden>
                            </div>
                            <button class="btn btn-danger mx-2 pop_value_btn" value="{{ $value->id }}"
                                type="button">Remove</button>
                        @endforeach
                    </div>
                </div>



                <div class="mb-3">
                    <label for="update_profile" class="form-label">Choose New Profile</label><br>
                    {{-- <label for="old_profile" class="form-label">Old file {{Auth::User()->profile}}</label> --}}

                    <input class="form-control" type="file" name="update_profile[]" id="update_profile" multiple>
                    <span class="text-danger">
                        @error('update_profile')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button type="submit" name="update" id="update" class="btn btn-primary">Submit</button>
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
                            $('#states').append('<option value="' + val.id +
                                '"> ' +
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
                            $('#cities').append('<option value="' + val.id +
                                '"> ' +
                                val.name + ' </option>')
                        });
                    }
                })
            });

            $('.pop_value_btn').on('click', function() {
                var id = $(this).val();
                var button = $(this);

                $.ajax({
                    url: "{{ url('/record') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(response) {
                        alert('An error occurred. Please try again.');
                    }
                });
                $(this).prev().remove();
                $(this).remove();
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

        // $(function() {
        //     $('.datepicker').datepicker({
        //         format: 'dd/mm/yyyy',
        //         autoclose: true,
        //         todayHighlight: true,
        //         endDate: new Date(),
        //     });
        // });

        // $(function() {
        //     var today = new Date().toISOString().split('T')[0];
        //     // $('.date').setAttribute("max", today);

        //     $('#date').datetimepicker({
        //         format: 'DD-MM-YYYY',
        //         // value: val,
        //         maxDate: today,
        //         // todayHighlight: true, 
        //         // endDate: new Date(),

        //     })
        // });
    </script>
@endsection
