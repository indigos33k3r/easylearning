@extends('layouts.app')

@section('content')
    <!-- main-container start -->    
    <section class="main-container content min-height">
        <div class="container">
            <div class="row">
                <!-- main start -->                
                <div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
                    <div class="form-block center-block" style = "">
                        <h2 class="title">Register</h2>
                        <hr>
                        <form id="register-form" class="form-horizontal" role="form">
                            {{ csrf_field() }}
                            <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-3 control-label" >Name <span class="text-danger small">*</span></label>
                                <div class="col-sm-8">
                                     <input id="name" type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    <i class="fa fa-pencil form-control-feedback"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-3 control-label" >Phone <span class="text-danger small">*</span></label>
                                <div class="col-sm-8">
                                     <input id="name" type="text" class="form-control" placeholder="Phone" name="phone" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                    <i class="fa fa-pencil form-control-feedback"></i>
                                </div>
                            </div>                                     
                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-sm-3 control-label">E-mail Address <span class="text-danger small">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" placeholder="E-mail" name="email" value="{{ old('email') }}" required>
                                    <i class="fa fa-user form-control-feedback"></i>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="inputPassword" class="col-sm-3 control-label">Password <span class="text-danger small">*</span></label>
                                <div class="col-sm-8">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>                                    
                                    <i class="fa fa-lock form-control-feedback"></i>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="password-confirm" class="col-sm-3 control-label">Confirm Password <span class="text-danger small">*</span></label>

                                <div class="col-sm-8">
                                    <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                     <i class="fa fa-lock form-control-feedback"></i>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" required> Accept our <a href="#">privacy policy</a> and <a href="#">customer agreement</a>
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-8">
                                    <button type="submit" class="btn btn-default">Register</button>
                                </div>
                            </div>

                            <input type="reset" class="hidden">
                        </form>
                    </div>
                </div>
                <!-- main end -->
                <form id="remote-check-form" class="hidden">
                	{{csrf_field()}}
                </form>
            </div>
        </div>
    </section>
    <!-- main-container end -->

    <div class="modal fade" id="accountCreated" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Account created</h4>
                </div>
                <div class="modal-body">
                    <p>Your account has been succesfully created.</p>
                    <p class="small">Note: Please access the link received on email in order to activate your account.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Ok</button>
                </div>
            </div>
        </div>
    </div>    
@endsection
