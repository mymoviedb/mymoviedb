<?php

class BaseModel extends Eloquent {
	public $errors;

	public static function boot()
	{
		parent::boot();
		static::saving (function($post)
		{
			return $post->validate();
		});
	}

	public function validate()
	{
		// Function to validate the user input. Input rules are set in the model for the appropriate database table. 

		$validation = Validator::make($this->attributes, static::$rules);

		if(validation->passes()) return true;

		$this->errors = $validation->messages();

		return false;
	}
}