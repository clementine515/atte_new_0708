@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css')}}">
@endsection

@section('content')
<div class="verify-email__text">メールが送信されました。</br>認証をしてください。</div>
@endsection('content')