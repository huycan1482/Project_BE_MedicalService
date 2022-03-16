@extends('admin.layouts.main')

@section('header_title')
<title>Medical Services | Errors</title>
@endsection

@section('css')
<link rel="stylesheet" href="myAssets/css/404.css">
@endsection

@section('content')
<div class="container">
    <div class="error-div">
        <h1>{{ $status }}</h1>
        <p>{{ $msg }}</p>
    </div>
</div>
@endsection