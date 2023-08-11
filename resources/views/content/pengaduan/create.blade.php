@extends('layouts.user')

@section('content')
    <pengaduan-create :user="{{ json_encode(session('user')) }}"></pengaduan-create>
@endsection