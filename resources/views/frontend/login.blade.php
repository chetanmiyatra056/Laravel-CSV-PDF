@extends('frontend.layouts.main')

@section('main-container')
    <div class="my-5">
        
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" id="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" id="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container my-5">

            <h1 class="text-center">Login Form</h1>

            <form method="POST" action="{{ url('/') }}/login">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                        value="{{ old('email') }}">
                    <span class="text-danger">
                        @error('email')
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

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password"
                        value="{{ old('password') }}">
                    <span class="text-danger">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <button type="submit" name="check" id="check" class="btn btn-primary">Login</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </form>
        </div>

    </div>

    <script>
        const alert = document.getElementById('alert');
        setTimeout(() => {
            $('#alert').alert('close')
        }, 2000)
    </script>
@endsection
