@extends('site.layouts.app')

@section('google_analitics')
{!!get_platform_data('google_analitics')->value!!}
@endsection
@section('title')
    {{config('app.name')}}
@endsection

@section('hero')
@include('site.inc.header.header')
@endsection

@section('cliens')
{{-- @include('site.inc.cliens.cliens') --}}
@endsection

@section('about')
@include('site.inc.about.about')
@endsection

@section('why-us')
@include('site.inc.why_us.why_us')
@endsection

@section('skills')
@include('site.inc.skills.skills')
@endsection

@section('services')
@include('site.inc.services.services')
@endsection

@section('cta')
{{-- @include('site.inc.cta.cta') --}}
@endsection 

@section('portfolio')
{{-- @include('site.inc.portfolio.portfolio') --}}
@endsection 

@section('team')
{{-- @include('site.inc.team.team') --}}
@endsection 

@section('pricing')
{{-- @include('site.inc.pricing.pricing') --}}
@endsection 

@section('faq')
@include('site.inc.faq.faq')
@endsection

@section('contact')
@include('site.inc.contact.contact')
@endsection

@section('footer-newsletter')
@include('site.inc.footer_newsletter.footer_newsletter')
@endsection