<title>{{ $seoTitle ?? config('app.name', 'Gifted Hands Private Clinic') }}</title>

<meta name="description"
    content="{{ $seoDescription ?? 'Gifted Hands Private Clinic provides accessible, patient-centered private healthcare in Lilongwe, Malawi.' }}">

<meta name="robots" content="{{ $seoRobots ?? 'index, follow' }}">

<link rel="canonical" href="{{ $seoCanonical ?? url()->current() }}">

<meta property="og:type" content="{{ $seoType ?? 'website' }}">
<meta property="og:title" content="{{ $seoTitle ?? config('app.name', 'Gifted Hands Private Clinic') }}">
<meta property="og:description"
    content="{{ $seoDescription ?? 'Gifted Hands Private Clinic provides accessible, patient-centered private healthcare in Lilongwe, Malawi.' }}">
<meta property="og:url" content="{{ $seoCanonical ?? url()->current() }}">
<meta property="og:site_name" content="{{ config('app.name', 'Gifted Hands Private Clinic') }}">

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $seoTitle ?? config('app.name', 'Gifted Hands Private Clinic') }}">
<meta name="twitter:description"
    content="{{ $seoDescription ?? 'Gifted Hands Private Clinic provides accessible, patient-centered private healthcare in Lilongwe, Malawi.' }}">