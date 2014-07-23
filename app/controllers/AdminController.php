<?php

class AdminController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Admin Panel Controller
	|--------------------------------------------------------------------------
	*/

  public $restful = true;

  /**
  * Display listing of the resource
  * 
  * @return Response
  */
  
  // This action grab user information and dislay it on the admin panel index
	public function index()
	{
		// Grab the currently logged in users access level
		$access = Session::get('user_access');

		if($access == "Admin" || $access == "admin")
		{
			// Count the number of user records
			$usercount = DB::table('users')
				->count();

			return View::make('admin.index')
				->with('title', "Admin Index")
				->with('usercount', $usercount)
				->with('users', UserModel::orderby('active')->get());
		}

		return Redirct::back()
			->with('message', FlashMessage::DisplayAlert('Not Autorized to see page content', 'danger'));
	}

  /**
  * Display listing of the resource
  * 
  * @param int $id
  * @return Response
  */
  
  // This Remove the specified resource from storage
	public function destroy($id)
	{

		// Grab the user record from the database
		$user = UserModel::find($id);

		// Udate the database record with the updated status (Set Active bit to 0 for in-active)
		$updatestatus = DB::table('users')
			->where('id', $id)
			->update(array('active'=>'0'));

		return Redirect::route('adminpanel.index')
			->with('title', "Admin Index")
			->with('message', FlashMessage::DisplayAlert('User successfully disabled', 'success'));
	}

  /**
  * Display listing of the resource
  * 
  * @param int $id
  * @return Response
  */
  
  // This Remove the specified resource from storage
	public function update($id)
	{

		// Grab the user record from the database
		$user = UserModel::find($id);

		// Udate the database record with the updated status (Set Active bit to 1 for active)
		$updatestatus = DB::table('users')
			->where('id', $id)
			->update(array('active'=>'1'));

		return Redirect::route('adminpanel.index')
			->with('title', "Admin Index")
			->with('message', FlashMessage::DisplayAlert('User successfully enabled', 'success'));
	}

}
