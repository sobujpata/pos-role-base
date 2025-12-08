@extends('backend.layouts.app')
@section('content')
    @include('backend.components.pos-invoice.index')
    @include('backend.components.pos-invoice.invoice-details')
@endsection
