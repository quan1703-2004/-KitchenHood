@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Chỉnh sửa FAQ</h1>

    <div class="card shadow mb-4 admin-form">
        <div class="card-body">
            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.faqs._form', ['faq' => $faq])
            </form>
        </div>
    </div>
</div>
@endsection


