@extends('login.auth')

@section('content')
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-offset-1">
                        	<div class="form-box">
                        		<div class="form-top">
	                        		<div class="form-top-left">
	                        			<h3>Sign up now</h3>
	                            		<p>Fill in the form below to get instant access:</p>
	                        		</div>
	                            </div>
	                            <div class="form-bottom">
				                    <form role="form" action="{{ url('/register')}}" method="post" class="registration-form">
				                      {{ csrf_field() }}

				                    	<div class="form-group">
				                    		<label class="sr-only" for="username">Username</label>
				                        	<input type="text" name="username" placeholder="Username" class="form-first-name form-control" id="username">

				                        	 @if ($errors->has('username'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('username') }}</strong>
			                                    </span>
			                                @endif
				                        </div>

				                        <div class="form-group">
				                    		<label class="sr-only" for="username">email</label>
				                        	<input type="text" name="email" placeholder="Email" class="form-first-name form-control" id="email">

				                        	 @if ($errors->has('email'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('email') }}</strong>
			                                    </span>
			                                @endif
				                        </div>

				                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
				                        	<label class="sr-only" for="password">Password</label>
				                        	<input type="password" name="password" placeholder="Password" class="form-last-name form-control" id="password">

				                        	 @if ($errors->has('password'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password') }}</strong>
			                                    </span>
			                                @endif
				                        </div>

				                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
				                        	<label class="sr-only" for="password">Password</label>
				                        	<input type="password" name="password_confirmation" placeholder="Password" class="form-last-name form-control" id="password_confirmation">

				                        	 @if ($errors->has('password_confirmation'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
			                                    </span>
			                                @endif
				                        </div>

				                    
				                        <button type="submit" class="btn">Sign me up!</button>
				                        <a href="{{url('/login')}}">Already a member? Login now</a>
				                    </form>
				                   
			                    </div>
                        	</div>
                        	
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
       
@endsection