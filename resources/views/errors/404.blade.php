@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Sorry, the page you are looking for could not be found.'))
@section('image')

    <img  src="{{ asset('img/logo-sirt-blanco.svg') }}" class="chapter-title responsive-img center-align mx-16"></img>
@endsection
