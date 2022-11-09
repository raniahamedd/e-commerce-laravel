@extends('layouts.dashboard')

@section('title',' Update Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')
<form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        @include('dashboard.products._form',[
            'button_label' => 'Update '
        ])
</form>
@endsection
