@extends('login.auth')
@section('content')
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row cont-body">
                        <div class="col-sm-6 col-md-offset-1" style="margin-top: 200px;">

                        	<div class="form-box">
	                        	<div class="form-top">
	                        		<div class="form-top-left">
	                        			<h3>Login to our site</h3>
	                           	 		<p>Enter username and password to log on:</p>
	                        		</div>
	                        		
	                            </div>
	                            <div class="form-bottom">
				                    <form role="form" action="{{ url('/login') }}" method="post" class="login-form">
				                     {{ csrf_field() }}
				                    	<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
				                    		<label class="sr-only" for="username">Username</label>
				                        	<input type="text" name="username" placeholder="Username..." class="form-username form-control" id="username">
				                        	
				                        	 @if ($errors->has('username'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('username') }}</strong>
		                                    </span>
                              				 @endif
				                        </div>

				                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
				                        	<label class="sr-only" for="password">Password</label>
				                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="password">
				                        </div>
				                        <button type="submit" class="btn">Sign in!</button>
				                        <a href="{{url('/register')}}"><p>Not a member yet? Register now</p></a>
				                    </form>

			                    </div>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
@endsection