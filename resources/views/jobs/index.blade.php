@extends('layout')

@section('content')
    <h1>Available jobsd</h1>

    <ul>
        @forelse ($jobs as $job)
            <li> {{ $loop->index }} {{ $job }}
            </li>
        @empty

            <p>No jobs available</p>
        @endforelse ()

    </ul>
@endsection

