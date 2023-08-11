@extends('layouts.admin')

@section('content')
    <pengaduan-index :asset_url="{{ json_encode(asset('app/main/image/pengaduan/')) }}"></pengaduan-index>
@endsection