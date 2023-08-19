@extends('frontend.layouts.master')
@section('style')

@endsection
@section('content')
<div class="container">
    <div class="">
        <x-slider />
    </div>
    <div class="row text-center mt-2 mb-2">
        <h1>MOVIE SELECTION</h1>
    </div>
    <div class="row">
        <x-movie />
    </div>
</div>
@endsection

