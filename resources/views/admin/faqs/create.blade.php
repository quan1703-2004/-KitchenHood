@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thêm mới FAQ</h1>

    <div class="card shadow mb-4 admin-form">
        <div class="card-body">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf
                @include('admin.faqs._form')
            </form>
        </div>
    </div>
</div>
@endsection


