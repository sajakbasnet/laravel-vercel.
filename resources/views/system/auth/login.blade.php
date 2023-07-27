@extends('system.layouts.masterLogin')
@section('content')
<div id="global-loader" class="light-loader" style="display: none;">
    <img src="https://laravel.spruko.com/xino/ltr/assets/img/loaders/loader.svg" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->



<!-- main-signin-wrapper -->
<div class="my-auto page page-h">
    <div class="main-signin-wrapper">
        <div class="main-card-signin d-md-flex wd-100p">
            <div class="p-5 wd-100p">
                <div class="main-signin-header">
                    <h2>Seja Bem Vindo!</h2>
                    <h4>Por favor, insira seus dados para entrar.</h4>
                    <form id="" method="post" action="{{ route('login') }}">
                        @if(!$errors->isEmpty())
                        <div class="alert alert-danger" role="alert">
                            {{$errors->first()}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label>Email</label>
                            <input id="login-user-dog" name="email" class="form-control" placeholder="Enter your email" type="email">

                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input autocomplete="current-password" name="password" id="senha-user-dog" class="form-control" placeholder="Enter your password" type="password">
                        </div>
                        <div class="actions__container">
                            <button class="btn btn-main-primary btn-block" type="submit">Login</button>
                            <div id="buttonDiv"></div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection