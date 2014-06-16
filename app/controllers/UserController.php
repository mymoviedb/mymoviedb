<?php
class UserController extends BaseController {

public $restful = true;

/**
  * Display listing of the resource
  * 
  * @return Response
  */

public function login()
{
	// Set the user array to gather data from the login form
	$userdata = array(
		'username' => Input::get('username'),
		'password' => Input::get('password')
		);

	// Check to see if the user is already logged in
		if(Auth::check())
		{
			return Redirect::to('/');
		} //End Auth Check
		

	if(Auth::attempt($userdata))
	{
		// Grab user record 
		$user = UserModel::find(Auth::user()->id);

		// If the user account is disabled then send user back to login screen
		if($user->active=='0')
		{
			Auth::logout();
			Session::flush();

			return Redirect::to('login')
				->with('message', FlashMessage::DisplayAlert('Your account is currently disabled, Please contact your Administrator for additional details', 'danger'));

		} // End User active check

		Session::put('current_user', Input::get('username'));
		Session::put('user_access', $user->access);
		Session::put('user_id', $user->id);

		return Redirect::to('/')
			->with('message', FlashMessage::DisplayAlert('Login Successful', 'success'));

	} // End Auth Attempt If
	else
	{
		return Redirect::to('login')
			->with('message', FlashMessage::DisplayAlert('Incorrect Username/Password', 'danger'));
	} // End Else

} // End function Login


/**
  * Display listing of the resource
  * 
  * @return Response
  */

public function signup()
{
	// Set today date
	$today = date("Y-m-d H:i:s");

	// Set the user array to gather data from the signup form for new user registration
	$userdata = array(
		'givenname' => Input::get('givenname'),
		'surname' => Input::get('surname'),
		'username' => Input::get('username'),
		'email' => Input::get('email'),
		'password' => Input::get('password'),
		'password_confirmation' => Input::get('password_confirmation')
		);

	// Set validation rules
	$rules = array(
		'givenname'=>'alpha_num|max:50',
		'surname'=>'alpha_num|max:50',
		'username'=>'required|unique:users,username|alpha_dash|min:5',
		'email'=>'required|unique:users,email|email',
		'password'=>'required|alpha_num|between:6,100|confirmed',
		'password_confirmation'=>'required|alpha_num|between:6,100',
		);

	// Run our validation check
	$validator = Validator::make($userdata, $rules);

	// If validation fails then redirect the user back to the signup screen 
	if($validator->fails())
	{		
		return Redirect::back()
			->withInput()
			->withErrors($validator);
	} // End If
	else
	{
		$user = new UserModel;
		$user->givenname = Input::get('givenname');
		$user->surname = Input::get('surname');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->photo = 'No Photo Found';
		$user->password = Hash::make(Input::get('password'));
		$user->active = "1";
		$user->isdel = "0";
		$user->last_login = $today;
		$user->access = "User";

		$user->save();
	} // End Else

	// Once the record has been saved to the database, then redirect the user user back to the login screen.
	return Redirect::to('login')
		->with('message', FlashMessage::DisplayAlert('User Account Created', 'sucess'));

} // Ends Signup Function

/**
  * Display listing of the resource
  * 
  * @return Response
  */

public function forgotpassword()
{
	// Set the user array to gather data from the password recover form
	$userdata = array(
		'email' => Input::get('email')
	);

	// Set Validaton Rule
	$rules = array(
		'email' => 'required|email', 
		);

	// Run our validation check
	$validator = Validator::make($userdata, $rules);

	// If validation fails then redirect back to the signup screen with errors
	if($validator->fails())
	{
		return Redirect::back()
			->withInput()
			->withErrors($validator);
	}
	// If Validation passes then process the form data
	else
	{
		//Grab the user record by the email address provided by the input form
		$user = UserModel::where('email', '=', Input::get('email'));

		// If the user record exists then grab the first returned result
		if($user->count())
		{
			$user = $user->first();

			// Generate a reset code and the temp password 
			$resetcode = str_random(60);
			$passwd = str_random(15);

			//Set the new values in the users db record to document the values
			$user->password_temp = Hash::make($passwd);
			$user->resetcode = $resetcode;

			// Save resetcode and temp password to user database record
			if($user->save())
			{
				// Set data array , this is the information that will be passed to the email form.
				$data = array(
					'email' => $user->email,
					'firstname' => $user->givenname,
					'lastname' => $user->surname,
					'username' => $user->username,
					'link' => URL::to('resetpassword', $resetcode),
					'password' => $passwd
				);

				// Send a mail to the user. This will plug the datavalues into the reminder email template and mail the user. 
				Mail::send('emails.auth.reminder', $data, function($message) use($user, $data)
				{
					$message->to($user->email, $user->givenname . ' ' . $user->lastname)->subject('MyMovieDB Password Recovery Request');
				}); // End Mail

				// Return to the login screen with a message informing the user to check their email
				return Redirect::to('login')
					->with('message', FlashMessage::DisplayAlert('User password reset link has been sent to your email', 'success'));

			} //End If DB Save
		} // End If User Count

		// If the email address does not match an email address in the database the display feedback to the user
			return Redirect::to('forgotpassword')
				->with('message', FlashMessage::DisplayAlert('Could not validate existing email address', 'danger'));
	} // End Else
} // End FogotPassword FN


/**
  * Display listing of the resource
  * 
  * @return Response
  */

public function resetpassword($resetcode)
{
	// Grab the user record where the reset code sent in the email matches in the database
	$user = UserModel::where('resetcode', '=', $resetcode)
		->where('password_temp', '!=', '');

	// If the DB search comes back with records from the query
	if($user->count())
	{
		// Set the user variable to the first returned record
		$user = $user->first();

		// Set the user user password to the value stored in password_temp, and then clear password temp and resetcode.
		$user->password = $user->password_temp;
		$user->password_temp = '';
		$user->resetcode = '';

		// Save the record to the database
		if($user->save())
		{
			// If successful then send the user to the login page and let them know they can now use the new password
			return Redirect::to('login')
				->with('message', FlashMessage::DisplayAlert('Your account has been reset. You can now log in with the password sent to your e-mail.', 'success'));
		}
	} // End User Count

	// If no user record was found, then inform the user that the reset code was not found in the database
	return Redirect::to('login')
	->with('message', FlashMessage::DisplayAlert('Could not recover account. Please contact your Administrator for further assistence.', 'danger'));
} //End ResetPassword FN
} // Ends UserController Class













