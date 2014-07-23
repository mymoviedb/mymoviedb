@extends('layouts.default')

<!-- Incldue customfunctions from views/includes -->
@include('includes.customfunctions')

<!-- Add a few breaks to display content below the navbar -->
<br><br><br>


@section('content')

<!-- Check for Errors -->
@if($errors->has())
	<div class='alert alert-danger' align='center'>
		@foreach ($errors->all() as $error)
			<div><h6 style='color:red'>{{$error}}</h6></div>
		@endforeach
	</div>
@endif

<!-- Echo Header (page title) and record count -->
<h2 style='text-align:center'>User Records</h2>
<p style='text-align:center'>{{$usercount . " records found"}}</p><br>


<!-- Display user records if returned -->
@if(count($users) != 0)
	<table class='table' cellspacing="5" id='users'>

		<!--Create column headers in table -->
		<thead>
			<tr>
				<th>First Name:</th>
				<th>Last Name:</th>
				<th>Username:</th>
				<th>E-Mail:</th>
				<th>Active:</th>
				<th>User Since:</th>
				<th>Last Login:</th>
				<th>Enable/Disable</th>
			</tr>
		</thead>
		<tbody>
			<!-- Loop through user records -->
			@foreach($users as $user)

			<!-- If active set active otherwise, set user disabled -->
			<?php 
				if($user->active =='1')
					$status = "Active";
				else
					$status = "Disabled";

				if(is_null($user->last_login)) $last_login = "No Record";
				else $last_login = ConvertDateMySQLNorm($user->last_login);

				$user_since = ConvertDateMySQLNorm($user->created_at);
			?>

			<tr>
				<td>{{$user->givenname}}<br></td>
				<td>{{$user->surname}}<br></td>
				<td>{{$user->username}}<br></td>
				<td>{{$user->email}}<br></td>
				<td>{{$status}}<br></td>
				<td>{{$last_login}}<br></td>
				<td>{{$user_since}}<br></td>
			
			@if($status == "Active")
				<td>
					{{Form::open(array(
						'route' => array('adminpanel.destroy', $user->id),
						'method' => 'DELETE',
						'style' => 'display:inline'
						))
					}}


					{{Form::button('Disable', array(
						'class' => 'btn btn-danger',
						'data-toggle' => 'modal',
						'data-target' => '#confirmDelete',
						'data-title' => 'Disable User',
						'data-message' => 'Are you sure you want to disable this user account?',
						'data-btncancel' => 'btn-default',
						'data-btnaction' => 'btn-danger',
						'data-btntxt' => 'Disable'
						))
					}}

					{{Form::close()}}
				</td>
				@else
				<td>
					{{Form::open(array(
						'route' => array('adminpanel.update', $user->id),
						'method' => 'PATCH',
						'style' => 'display:inline'
						))
					}}


					{{Form::button('Enable', array(
						'class' => 'btn btn-success',
						'data-toggle' => 'modal',
						'data-target' => '#confirmDelete',
						'data-title' => 'Enable User',
						'data-message' => 'Are you sure you want to enable this user account?',
						'data-btncancel' => 'btn-default',
						'data-btnaction' => 'btn-success',
						'data-btntxt' => 'Enable'
						))
					}}

					{{Form::close()}}
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>

	<!-- Include he modal_confirm php file in views/includes -->
	@include('includes.modal_confirm')


	@else

	<h3 style="text-align:center">No user records found. </h3>
	@endif

@stop