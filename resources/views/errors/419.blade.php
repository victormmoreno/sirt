@extends('errors::illustrated-layout')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Sorry, your session has expired. Please refresh and try again.'))
@section('image')
	<img class="chapter-title responsive-img" height="290px" width="800px" style="position: absolute; margin-top: 200px; margin-left: 40px" src="{{ asset('img/logonacional_Negro.png') }}" />
@endsection
