<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{ $title }}</title>

		<!-- Include Twitter Bootstrap -->
		{{ HTML::style('/css/bootstrap.min.css') }}
	    {{ HTML::style('/css/bootstrap-theme.css') }}

	    <!--Include JS Files -->
	    <script src="/js/jquery-1.11.1.min.js"></script>
	</head>
	<body>

		<!-- Grab User from Session Variables -->
		<?php
			$username = Session::get('current_user');
			$userid = Session::get('user_id');
		?>
		

		<div id="nav">
	      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	      	<div class="navbar-header">
				<a class="navbar-brand">MyMovieDB</a>
	        </div> <!-- End Navbar Header -->

	      <ul class="nav navbar-nav">

	      	<!-- Home Menu. -->
	      	<li>{{ HTML::Link('/', 'Dashboard') }}</li>

	      </ul> <!-- End Left Nav -->

	      <ul class="nav navbar-nav pull-right">
	      	<li style="color:yellow"> {{ "Logged in:" }} <br><h4> &nbsp;&nbsp; {{ $username }} &nbsp;&nbsp; </h4></li>
	      	<li> <a data-toggle='modal' data-target='#user_modal' href="{{ URL::route('users.show', $userid) }}">Edit Profile</a></li>
	      	<li> {{ HTML::link('logout', 'Logout') }}</li>
	      </ul> <!-- End Left Nav-->


	      </nav> <!-- End "navbar" Div-->
	    </div> <!-- End "Nav" Div-->

	    
	    <div id="content">
	    	@if(Session::has('message'))
	      		<center>{{ Session::get('message') }}</center>
	      		<br>
	    	@endif

	    	@yield ('content')
	    </div>

	    <div id="footer">
	    	<br><br>
	    	<center>&copy;http://mymoviedb.local {{ date('Y') }}</center>
	    </div>

		<!-- Javascript Files required for page-->
	    <script src="/js/bootstrap.min.js"></script>


	<!-- ########################### Initialize Modal Window for User Details ########################-->
	<div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="myModalLabel">Edit User Profile</h3>
				</div> <!-- End Modal Header -->
				<div class="modal-body"><div class="te"></div>
				</div> <!-- End Modal Body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div> <!-- End Modal Footer -->
			</div> <!-- End Modal Content -->
		</div> <!-- End Modal Dialog -->
	</div> <!-- End Modal -->

	</body>
</html>








