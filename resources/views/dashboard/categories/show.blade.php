@extends('layouts.dashboard')

@section('title',$category->name)

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
<li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')

<table class="table table-striped table-bordered ">
    <tr>
        <th></th>
        <th>Name</th>
        <th>Store</th>
        <th>status</th>
        <th>Created At</th>
    </tr>
    <tbody>
        @php
            $products = $category->productS()->with('store')->latest()->paginate(6)
        @endphp

     @forelse($products as $product)
        <tr>
            <td> <img src="{{ asset("storage/" . $product->image) }}" height='50' alt=""></td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->store->name}}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at}}</td>

     @empty
        <tr>
            <th colspan="5" class='text-center'> NO Products Define .</th>
        </tr>
     @endforelse
    </tbody>
</table>
    {{ $products->links() }}
@endsection
