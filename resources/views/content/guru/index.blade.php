@extends('layouts.admin')

@section('content')
    <guru-index :import_route="{{ json_encode(route('guru.import')) }}"></guru-index>
@endsection