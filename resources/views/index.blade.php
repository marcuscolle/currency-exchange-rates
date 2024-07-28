@extends('layouts.front')


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">

            <div class="col-md-8">

                <h1>Currency Exchange Rates</h1>
                {{--        <form action="{{ route('currency-rates') }}" method="POST">--}}
                <form action="#" method="POST">

                    @csrf
                    <div class="form-group">
                        <label for="date">Enter Date (YYYY-MM-DD):</label>
                        <input type="text" name="date" id="date" class="form-control" value="{{ old('date') }}">
                        @error('date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>


    //create a nice code for my form above

@endsection
