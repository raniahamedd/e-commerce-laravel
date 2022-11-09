@extends('layouts.dashboard')

@section('title',' Update Category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">edit category</li>
@endsection

@section('content')
<form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        @include('dashboard.categories._form',[
            'button_label' => 'Update '
        ])
</form>
@endsection
