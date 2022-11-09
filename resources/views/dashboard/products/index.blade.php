@extends('layouts.dashboard')

@section('title','All Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

<div class="mb-5 ">
    <a href="{{ route('dashboard.products.create') }}" class='btn btn-primary mr-2'> Add Product </a>
    {{-- <a href="{{ route('dashboard.products.trash') }}" class='btn btn-outline-dark btn-sm'> Trash </a> --}}
</div>

<x-alert type='success' />
<x-alert type='info' />

{{-- <form action="{{ URL::current() }}" method="get" class='d-flex justify-content-between mb-4'>
    <x-form.input name='name' placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>active</option>
        <option value="archived" @selected(request('status')=='archived' )>archived</option>
    </select>
    <button class="btn btn-dark mx-2"> Filter </button>
</form> --}}

<table class="table table-striped table-bordered ">
    <tr>
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Store</th>
        <th>Price</th>
        <th>status</th>

        <th colspan="2" class="text-center">Action</th>
    </tr>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td> <img src="{{ asset("storage/" . $product->image) }}" height='50' alt=""></td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name}}</td>
            <td>{{ $product->store->name}}</td>
            <td>{{ $product->price}}</td>
            <td>{{ $product->status }}</td>
            <td>
                <a href=" {{ route('dashboard.products.edit', $product->id) }} "
                    class="btn btn-sm btn-outline-success">
                    Edit</a>
            </td>
            <td>
                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST"
                    class="delete-form">
                    @csrf
                    @method('DELETE')
                    <input type="button" class="btn btn-sm btn-outline-danger delete-btn" value="Delete">
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <th colspan="9" class='text-center'> NO Products Define .</th>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $products->withQueryString()->appends(['search' => 1])->links() }}
@endsection

@push('scripts')
 <script>
        $('.delete-btn').on('click' , ()=>{
            Swal.fire({
                title: 'Are you sure to delete this service?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $('.delete-btn').closest('.delete-form').submit();
                }
            })
        })
    </script>
@endpush
