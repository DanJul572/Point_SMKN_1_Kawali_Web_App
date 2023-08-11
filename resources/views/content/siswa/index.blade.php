@extends('layouts.admin')

@section('content')
    <siswa-index :import_route="{{ json_encode(route('siswa.import')) }}"></siswa-index>
@endsection