@extends('layouts.dashboard')

@section('title','Add New Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">new Product</li>
@endsection

@section('content')
<form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('dashboard.categories._form')
</form>
@endsection
