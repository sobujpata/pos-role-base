@extends('backend.layouts.app')
@section('title', 'Barcode Generate Pages')
@section('content')
@include('backend.components.barcode-products.index')
@include('backend.components.barcode-products.barcode-modal')
@endsection
