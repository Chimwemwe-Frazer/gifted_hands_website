@extends('layouts.app')

@section('title', 'ADDA | 403 - Forbidden')

@section('content')
    <header class="relative w-full h-60 md:h-96 bg-cover bg-center rounded-lg"
        >
        <div class="header-bg pt-20">
            <h1 class="header-title">403 - Forbidden</h1>
            <p class="text-white">Sorry, you do not have permission to access this page.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary">Back to Dashboard</a>
        </div>
    </header>
@endsection
