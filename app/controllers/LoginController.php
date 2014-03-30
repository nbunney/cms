<?php
/**
 * Login resource (handles all the authentication)
 * @author Matthew Davies <daviesgeek@icloud.com>
 * @created March 24th, 2014
 */
class LoginController extends \BaseController {


	public $title = 'Login';

	/**
	 * User facing login page
	 * @return Response
	 */
	public function index() {
		return View::make('login')->with('title', $this->title);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()	{
		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		$remember = Input::get('remember');
		Auth::attempt($user, $remember);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		//
	}

}