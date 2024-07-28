@extends('layouts.front')


@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Currency Exchange Rates</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('front.currency-rates') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="date">Select Date:</label>
                                <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}">
                                @error('date')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
