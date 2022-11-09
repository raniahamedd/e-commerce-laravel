@extends('layouts.dashboard')

@section('title','All Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

<div class="mb-5 ">
    <a href="{{ route('dashboard.categories.create') }}" class='btn btn-primary mr-2'> Add Category </a>
    <a href="{{ route('dashboard.categories.trash') }}" class='btn btn-outline-dark btn-sm'> Trash </a>
</div>

<x-alert type='success' />
<x-alert type='info' />

<form action="{{ URL::current() }}" method="get" class='d-flex justify-content-between mb-4'>
    <x-form.input name='name' placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status')=='active' )>active</option>
        <option value="archived" @selected(request('status')=='archived' )>archived</option>
    </select>
    <button class="btn btn-dark mx-2"> Filter </button>
</form>

<table class="table  table-striped table-bordered ">
    <tr>
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>Parent</th>
        <th>Products Count</th>
        <th>Status</th>
        <th>Created At</th>
        <th colspan="2">Action</th>
    </tr>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td> <img src="{{ asset("storage/" . $category->image) }}" height='50' alt=""></td>
            <td>{{ $category->id }}</td>
            <td><a href="{{ route('dashboard.categories.show',$category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name}}</td>
            <td>{{ $category->products_count}}</td>
            <td>{{ $category->status}}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <a href=" {{ route('dashboard.categories.edit', $category->id) }} "
                    class="btn btn-sm btn-outline-success">
                    Edit</a>
            </td>
            <td>
                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST"
                    class="delete-form">
                    @csrf
                    @method('DELETE')
                    <input type="button" class="btn btn-sm btn-outline-danger delete-btn" value="Delete">
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <th colspan="7" class='text-center'> NO Categories Define .</th>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $categories->withQueryString()->appends(['search' => 1])->links() }}
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
