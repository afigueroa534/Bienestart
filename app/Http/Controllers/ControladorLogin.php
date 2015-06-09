<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class ControladorLogin extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Session::put('login', '');
		Session::put('tipo_per', '');

		date_default_timezone_set('America/Caracas');
		DB::table('cita')->where('fecha','<', date('Y-m-d'))->where('estado','=', 'P')->update(
    		[
    		'estado' => 'C'
    		]
		);

		return view('login');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		return redirect()->back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		$data = $request->all();
		$rules = array(
			'login' => 'required',
			'clave' => 'required'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$claves = DB::table('persona')->select('clave')->where('login', '=', $request->login)->get();
		if($claves == null)
		{
			$errors = array('clave' => 'El Login o Password es Invalido');
			return redirect()->back()->withErrors($errors)->withInput($request->all());
		}
		else
		{
			foreach ($claves as $clave) {
				if (!password_verify($request->clave, $clave->clave))
				{
					$errors = array('clave' => 'El Login o Password es Invalido');
					return redirect()->back()->withErrors($errors)->withInput($request->all());
				}
			}
		}

		$personas = DB::table('persona')->where('login', '=', $request->login)->get();

		foreach ($personas as $persona) {

			Session::put('login', $persona->login);
			Session::put('tipo_per', $persona->tipo_per);
			Session::put('cedula', $persona->cedula);
			Session::put('sexo', $persona->sexo);
			Session::put('nombre', $persona->nombre);
			Session::put('apellido', $persona->apellido);
			return redirect()->route('Principal.index');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		return redirect()->back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('password_olvidado');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		$personas = DB::table('persona')->where('email', '=', $request->email)->get();
		if($personas == null)
		{
			$errors = array('clave' => 'Lo sentimos su email no fue encontrado');
			return redirect()->back()->withErrors($errors)->withInput($request->all());
		}
		else
		{
			foreach ($personas as $persona) {
				$faker = Faker::create();
				$clave = $faker->numberBetween($min = 8000000, $max = 30000000);
				DB::table('persona')->where('email','=',$request->email)->update(
		    		[
		    		'clave' => password_hash($clave, PASSWORD_DEFAULT)
		    		]
				);

				\Mail::send('email', compact(['persona','clave']), function($message) use ($persona)
				{
				    $message->from('bienestart.info@gmail.com')
				            ->to($persona->email, $persona->nombre.' '.$persona->apellido)
				            ->subject('Nuevo Password');
				});

				Session::flash('message','Se le ha enviado un correo. Revise su bandeja de entrada');

				return redirect()->route('Login.index');

			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return redirect()->back();
	}

}
