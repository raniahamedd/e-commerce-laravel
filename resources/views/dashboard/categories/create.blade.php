@extends('layouts.dashboard')

@section('title','Add New Category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">new category</li>
@endsection

@section('content')
<form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('dashboard.categories._form')
</form>
@endsection
