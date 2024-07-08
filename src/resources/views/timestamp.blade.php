@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/timestamp.css')}}">
@endsection

@section('link')
<ul class="header-nav">
    @if (Auth::check())
    <li class="header-nav__item">
        <a class="header-nav__link" href="/">ホーム</a>
        <form class="header-nav__form" action="/attendance" method="post">
            @csrf
            <button class="header-nav__date">日付一覧</button>
        </form>
        <form action="/logout" method="post">
            @csrf
            <button class="header-nav__button">ログアウト</button>
        </form>
    </li>
    @endif
</ul>
@endsection

@section('content')
<div>
    @auth
    <div>
        <h2 class="timestamp__title">{{ Auth::user()->name }} さん、お疲れ様です</h2>
    </div>
    @endauth

    <div class="button-container">
        <form class="clock_record" action="/checkin" method="post">
            @csrf
            <button type="submit" class="button" {{ $isStarted ? 'disabled' : '' }}>勤務開始</button>
        </form>
        <form class="clock_record" action="/checkout" method="post">
            @csrf
            <button type="submit" class="button {{ $activeButton ?? '' === 'checkout' ? 'active' : 'inactive'}}">勤務終了</button>
        </form>
    </div>

    <div class="button-container">
        <form class="breaktime" action="/break-start" method="post">
            @csrf
            <button type="submit" class="button {{ $activeButton ?? '' === 'start' ? 'active' : 'inactive'}}">休憩開始</button>
        </form>
        <form class="breaktime" action="/break-end" method="post">
            @csrf
            <button type="submit" class="button {{ $activeButton ?? '' === 'end' ? 'active' : 'inactive'}}">休憩終了</button>
        </form>
    </div>
</div>
@endsection('content')