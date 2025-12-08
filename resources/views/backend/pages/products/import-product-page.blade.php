@extends('backend.layouts.app')
@section('title', 'Products Pages')
@section('content')
@include('backend.components.import-products.index')
@include('backend.components.import-products.create')
@endsection
