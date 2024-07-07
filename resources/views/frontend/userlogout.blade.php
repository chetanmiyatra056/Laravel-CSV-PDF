@extends('frontend.layouts.main')

@section('main-container')
    <div class="my-5">
        <div class="container allContent-section">

            <div class="p-5 mb-4 my-5 text-light bg-dark rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Welcome To User Dashboard Page</h1>
                    <p class="col-md-8 fs-4">Using a series of utilities, you can create this jumbotron, just like the one
                        in previous versions of Bootstrap. Check out the examples below for how you can remix and restyle it
                        to your liking.</p>

                    {{-- @if (session()->has('email')) --}}
                        <form action="{{ url('/logout') }}" method="POST">
                            @csrf
                            {{-- <input type="text" name="id" id="id" value="{{ session('email')}} "> --}}
                            <button class="btn btn-primary btn-lg" type="submit">LogOut</button>
                        </form>
                    {{-- @else
                        <a href="{{ url('/register') }}" class="btn btn-primary btn-lg" type="button">Start Register</a>
                    @endif --}}

                </div>
            </div>
        </div>

    </div>
@endsection
