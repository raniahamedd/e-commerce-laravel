@extends('layouts.dashboard')

@section('title','Trashed Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item"> Categories </li>
<li class="breadcrumb-item active"> Trash </li>
@endsection

@section('content')

<div class="mb-5 ">
    <a href="{{ route('dashboard.categories.index') }}" class='btn btn-primary btn-sm'> Back </a>
</div>

<x-alert  type='success' />
<x-alert  type='info' />

<form action="{{ URL::current() }}" method="get" class='d-flex justify-content-between mb-4' >
    <x-form.input name='name' placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="form-control mx-2"  >
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active') >active</option>
            <option value="archived" @selected(request('status') == 'archived') >archived</option>
        </select>
        <button class="btn btn-dark mx-2" > Filter </button>
</form>

<table class="table  table-striped table-bordered ">
    <tr>
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
        <th>Deleted At</th>
        <th colspan="2">Action</th>
    </tr>
    <tbody>
     @forelse($categories as $category)
        <tr>
            <td> <img src="{{ asset("storage/" . $category->image) }}" height='50'  alt=""></td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->status}}</td>
            <td>{{ $category->deleted_at }}</td>
            <td>
                <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm btn-outline-info" type="submit" name="delete"> Rstore </button>
                </form>
            </td>
            <td>
                <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit" name="delete"> Delete </button>
                </form>
            </td>
        </tr>
     @empty
        <tr>
            <th colspan="7" class='text-center'> NO Categories Trashed .</th>
        </tr>
     @endforelse
    </tbody>
</table>
{{ $categories->withQueryString()->appends(['search' => 1])->links() }}
@endsection

