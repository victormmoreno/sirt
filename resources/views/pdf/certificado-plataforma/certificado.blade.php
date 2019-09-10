@extends('pdf.illustrated-layout')
@section('image-header')
<div class="center">
	<p class="z-depth-3">
        <img class="img-responsive"  src="{{asset('img/logonacional_Negro.png')}}" >
        </img>
    </p>
</div>
  
@endsection

@section('title', 'Certificado' )
@section('message')
<p class="red-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	
@endsection
