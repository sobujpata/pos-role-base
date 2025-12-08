@extends('backend.layouts.app')
@section('content')
    @include('backend.components.invoices.index')
    @include('backend.components.invoices.invoice-complete')
    @include('backend.components.invoices.invoice-delete')
    @include('backend.components.invoices.invoice-details')
@endsection
