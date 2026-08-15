@extends('backend.layouts.app')
@section('title', 'Products Pages')
@section('content')
@include('backend.components.import-products.index')
@include('backend.components.import-products.create')
@include('backend.components.import-products.edit')
{{-- @include('backend.components.import-products.add-product') --}}
@include('backend.components.import-products.delete')
@endsection
