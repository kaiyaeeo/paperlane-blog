@php
    $seoTitle = $title ?? 'Paperlane';
    $seoDescription = $description ?? 'Ruang menulis digital. Tempat sederhana untuk menulis dan membaca.';
    $seoImage = $image ?? null;
    $seoType = $type ?? 'website';
    $seoUrl = url()->current();
@endphp

<meta name="description" content="{{ $seoDescription }}">
<link rel="canonical" href="{{ $seoUrl }}">

{{-- Open Graph --}}
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:site_name" content="Paperlane">
@if($seoImage)
    <meta property="og:image" content="{{ $seoImage }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
@if($seoImage)
    <meta name="twitter:image" content="{{ $seoImage }}">
@endif

{{-- Extra meta --}}
<meta name="theme-color" content="#3E2723">