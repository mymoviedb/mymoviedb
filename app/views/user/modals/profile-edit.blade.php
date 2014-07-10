<html>
	<body>
	 <!-- ########################### Initialize Modal Window for User Details ########################-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title" id="myModalLabel">Edit User Profile</h3>
				</div> <!-- End Modal Header -->
				<div class="modal-body">
					
				<?php
					$access = Session::get('user_access');
					$userid = Session::get('user_id');
				?>

				{{ Form::open(array('method'=>'POST', 'route' => 'users.store', 'style' => 'display:inline')) }}

				@foreach($user as $userinfo)

					<!-- Set hidden element with user id embedded -->
					<input type="hidden" name="id" id="id" value={{ $userid }}>

					<!-- Display the username -->
					<h2 style="align:center">{{ $userinfo->username }}</h2>
					<br><br>

					<!--2 Column Form to change user infomation and dislpay current status -->
					<div class='container col-md-offset-1'>
						<div class='row col-md-3'>
							<div>
								{{ Form::label('givenname', 'First Name:') }} <br>
								<input type="text" name='givenname' id='givenname' value={{ $userinfo->givenname }}>
							</div><br />

							<div>
								{{ Form::label('surname', 'Last Name:') }} <br>
								<input type="text" name='surname' id='surname' value={{ $userinfo->surname }}>
							</div><br />

							<div>
								{{ Form::label('email', 'Email Address:') }} <br>
								<input type="text" name='email' id='email' value={{ $userinfo->email }}>
							</div><br />
						</div> <!-- End First Row -->


						<div class='row col-md-3'>
							<div>
								{{ Form::label('password', 'New Password:') }} <br>
								<input type="password" name='password' id='password' value={{ $userinfo->password }}>
							</div><br />

							<div>
								{{ Form::label('password_confirmation', 'Confirm New Password:') }} <br>
								<input type="password" name='password_confirmation' id='password_confirmation' value={{ $userinfo->password }}>
							</div><br />

							<div>
								{{ Form::label('useraccess', 'Current Membership Status:') }} <br>
								{{ $access }}
							</div><br />
						</div> <!-- End Second Row -->
					</div> <!-- End Container -->
				@endforeach

				<br><br>

				{{ Form::submit('Save', array('class' => 'btn btn-warning')) }}
				<!-- Close the Form -->
				{{ Form::close() }}
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div> <!-- End Modal Body -->
				<div class="modal-footer">
				</div> <!-- End Modal Footer -->
			</div> <!-- End Modal Content -->
		</div> <!-- End Modal Dialog -->
	</body>
</html>