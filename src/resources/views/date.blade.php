@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css')}}">
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
<div class="attendance-home">
    <a class="attendance_back" href="{{ route('date_index', ['date' => \Carbon\Carbon::parse($selectedDate)->subDay()->toDateString()]) }}"><</a>
    <h2 class="attendance__title">{{ $selectedDate }}</h2>
    <a class="attendance_next" href="{{ route('date_index', ['date' => \Carbon\Carbon::parse($selectedDate)->addDay()->toDateString()]) }}">></a>
</div>

<table class="attendance__table">
    <tr class="attendance__row">
        <th class="attendance__label">名前</th>
        <th class="attendance__label">勤務開始</th>
        <th class="attendance__label">勤務終了</th>
        <th class="attendance__label">休憩時間</th>
        <th class="attendance__label">勤務時間</th>
    </tr>
    @foreach ($clockRecords as $record)
    <tr class="attendance__row">
        <td class="attendance__data"><a href="{{ route('user.rescords_each', ['id' => $record->user->id])}}">{{$record->user->name}}</a></td>
        <td class="attendance__data">{{\Carbon\Carbon::parse($record->checkin_time)->format('H:i:s')}}</td>
        <td class="attendance__data">{{\Carbon\Carbon::parse($record->checkout_time)->format('H:i:s')}}</td>
        <td class="attendance__data">{{gmdate('H:i:s', $record->total_break_time)}}</td>
        <td class="attendance__data">{{gmdate('H:i:s', $record->actual_work_time)}}</td>
    </tr>
    @endforeach
</table>
<div>{{ $clockRecords->appends(request()->query())->links('vendor.pagination.custom') }}</div>
@endsection('content')