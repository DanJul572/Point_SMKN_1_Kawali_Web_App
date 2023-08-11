@extends('layouts.user')

@section('content')
    <dashboard-user :user="{{ json_encode(session('user')) }}"></dashboard-user>
@endsection