@extends('layouts.front')

@section('content')

    <div class="container mt-5">
        <h1>Exchange Rates for {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h1>

        @if($rates->isEmpty())
            <div class="alert alert-info">No exchange rates found for the given date.</div>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rates as $rate)
                    <tr>
                        <td>{{ $rate->code }}</td>
                        <td>{{ $rate->name }}</td>
                        <td>{{ $rate->rate }}</td>
                        <td>{{ $rate->date->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('front.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>

@endsection
