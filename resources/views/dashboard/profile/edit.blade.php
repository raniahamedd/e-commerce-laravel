@extends('layouts.dashboard')

@section('title',' Update Profile')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
<x-alert type='success' />
<form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-3">
    <div class="form-row ">
        <div class="col-md-6">
            <x-form.input name='first_name' label="First Name" :value="$user->profile->first_name" />
        </div>
        <div class="col-md-6">
            <x-form.input name='last_name' label="Last Name" :value="$user->profile->last_name" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <x-form.input name='birthday' type="date" label="Birthday" :value="$user->profile->birthday" />
        </div>
        <div class="col-md-6">
            <x-form.radio name="gender" :options="[ 'male'=>'Male' , 'female'=>'Female' ]" label="Gender" :checked="$user->profile->gender" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name='street_address' label="Street Adress" :value="$user->profile->street_address" />
        </div>
        <div class="col-md-4">
            <x-form.input name='city' label="City" :value="$user->profile->city" />
        </div>
        <div class="col-md-4">
            <x-form.input name='state' label="State" :value="$user->profile->state" />
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-4">
            <x-form.input name='postal_code' label="Pstal Code" :value="$user->profile->postal_code" />
        </div>
        <div class="col-md-4">
            <x-form.select name='country' label="Country" :options="$countries" :selected="$user->profile->country"/>
        </div>
        <div class="col-md-4">
            <x-form.select name='locale' label="Locale" :options="$locales" :selected="$user->profile->locale"/>
        </div>
    </div>
</div>
<button type="submit" class='btn btn-success'> Save </button>
</form>
@endsection
