@extends('layouts.app')

@section('title', 'ADDA | 500 - Server Error')

@section('content')
<header class="relative w-full h-60 md:h-96 bg-cover bg-center" >
    <div class="header-bg pt-20">
        <h1 class="header-title">500 - Server Error</h1>
        <p class="text-white">Sorry, we are having a problem with our server. Please try again later.</p>
        <a href="/" class="btn-primary">Back to Homepage</a>
    </div>
</header>
@endsection
