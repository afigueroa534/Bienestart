<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorPaciente extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('registrarpaciente');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
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
		date_default_timezone_set('America/Caracas');
		$data = $request->all();
		$rules = array(
			'cedula' => 'required|numeric',
			'vcedula' => 'required|in:V,E',
			'login' => 'required|unique:persona,login|min:5',
			'nombre' => 'required',
			'apellido' => 'required',
			'direccion' => 'required',
			'email' => 'required|unique:persona,email',
			'clave' => 'required|min:5',
			'fecha_nac' => 'required|date|date_format:Y-m-d|before:'.date('Y-m-d'),
			'telefono' => 'required|numeric',
			'sexo' => 'required|in:M,F', 
			'grupo_sangre' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
			'imagen' => 'required|image'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$request->cedula = $request->vcedula.$request->cedula;

		$rules = array(
			'cedula' => 'unique:persona,cedula',
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		DB::table('persona')->insert(
    		[
    		'cedula' => $request->cedula, 
    		'login' => $request->login,
    		'nombre' => $request->nombre,
    		'apellido' => $request->apellido,
    		'direccion' => $request->direccion,
    		'email' => $request->email,
    		'clave' => password_hash($request->clave, PASSWORD_DEFAULT),
    		'fecha_nac' => $request->fecha_nac,
    		'telefono' => $request->telefono,
    		'sexo' => $request->sexo,
    		'tipo_per' => 'P',
    		'imagen' => $request->login.'.jpg'
    		]
		);

		$request->file('imagen')->move('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/', $request->login.'.jpg');

		DB::table('paciente')->insert(
    		[
    		'cedula' => $request->cedula, 
    		'grupo_sangre' => $request->grupo_sangre
    		]
		);

		Session::flash('message','Bienvenido '.$request->nombre.' '.$request->apellido.' a sido registrado satisfactoriamente. Ingrese agregando su Login y Password');

		return redirect()->route('Login.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
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
		return redirect()->back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return redirect()->back();
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
