@extends('layouts.auth')

@section('title', 'Đăng ký')
@section('header-text', 'Tạo tài khoản mới')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<style>
/* Reuse login card styles for register */
.card { --p: 32px; --h-form: auto; --w-form: 420px; --input-px: 0.75rem; --input-py: 0.65rem; --submit-h: 42px; --blind-w: 64px; --space-y: 0.5rem; width: var(--w-form); height: var(--h-form); max-width: 100%; border-radius: 16px; background: white; position: relative; display: flex; align-items: center; justify-content: space-evenly; flex-direction: column; overflow-y: auto; padding: var(--p); }
.form { order: 1; position: relative; display: flex; align-items: center; justify-content: space-evenly; flex-direction: column; width: 100%; }
.form .title { width: 100%; font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 1rem; color: rgba(0,0,0,0.7); border-bottom: 2px solid rgba(0,0,0,0.3); }
.form .label_input { white-space: nowrap; font-size: 1rem; margin-top: calc(var(--space-y) / 2); color: rgba(0,0,0,0.9); font-weight: 600; text-align: left; margin-right: auto; }
.form .input { background: white; border: 1px solid #8f8f8f; border-radius: 6px; outline: none; padding: var(--input-py) var(--input-px); font-size: 18px; width: 100%; color: #000000b3; margin: var(--space-y) 0; transition: all 0.25s ease; }
.form .input:focus { border: 1px solid #0969da; box-shadow: 0 0 0 2px #0969da; }
.form .submit { height: var(--submit-h); width: 100%; cursor: pointer; background-color: #fff; background-image: linear-gradient(-180deg, rgba(255,255,255,0.09) 0%, rgba(17,17,17,0.04) 100%); border: 1px solid rgba(22,22,22,0.2); font-weight: 500; color: #000; border-radius: 0.25rem; margin: var(--space-y) 0 0; }
.form .submit:hover { background-image: linear-gradient(-180deg, rgba(255,255,255,0.18) 0%, rgba(17,17,17,0.08) 100%); }
</style>

<div class="card">
  <form class="form" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="title">Sign Up</div>

    <label class="label_input" for="name">Name</label>
    <input class="input @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}" required />
    @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

    <label class="label_input" for="email">Email</label>
    <input class="input @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required />
    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

    <label class="label_input" for="password">Password</label>
    <input class="input @error('password') is-invalid @enderror" id="password" name="password" type="password" required />
    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

    <label class="label_input" for="password_confirmation">Confirm Password</label>
    <input class="input" id="password_confirmation" name="password_confirmation" type="password" required />

    <button class="submit" id="register-submit" type="submit">Create account</button>
    <div id="register-loader" class="d-none" style="width:100%;margin-top:12px;">
      <style>
      .wrapper{display:flex;justify-content:center;align-items:center;height:60px}
      .ball{--size:16px;width:var(--size);height:var(--size);border-radius:11px;margin:0 10px;animation:2s bounce ease infinite}
      .blue{background-color:#4285f5}
      .red{background-color:#ea4436;animation-delay:.25s}
      .yellow{background-color:#fbbd06;animation-delay:.5s}
      .green{background-color:#34a952;animation-delay:.75s}
      @keyframes bounce{50%{transform:translateY(25px)}}
      </style>
      <div class="wrapper">
        <div class="blue ball"></div>
        <div class="red ball"></div>
        <div class="yellow ball"></div>
        <div class="green ball"></div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('footer')
<div class="text-center">
    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
</div>
@endsection