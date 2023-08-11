@extends('layouts.admin')

@section('content')
    <poin-siswa :create_route="{{ json_encode(route('poin.create')) }}"></poin-siswa>
@endsection