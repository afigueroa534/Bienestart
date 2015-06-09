<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorPrincipal extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = array(	'nombre' => Session::get('nombre'),
						'apellido' => Session::get('apellido'),
						'sexo' => Session::get('sexo'),
						'cedula' => Session::get('cedula'),
						'tipo_per' => Session::get('tipo_per'),
						'login' => Session::get('login')
					);
		if($user['login'] == '' && $user['tipo_per'] == '')
		{
			return redirect()->route('Login.index');
		}
		switch ($user['tipo_per']) {
			case 'M': 
				$medicos = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->where('persona.cedula', '=', $user['cedula'])->get();
				foreach ($medicos as $medico) {
					return view('medico.medico',compact(['medico','user']));
				}
				break;
			case 'P':
				$pacientes = DB::table('persona')->join('paciente', 'persona.cedula', '=', 'paciente.cedula')->where('persona.cedula', '=', $user['cedula'])->get();
				foreach ($pacientes as $paciente) {
					return view('paciente.paciente',compact(['paciente','user']));
				}
				break;
			case 'A':
				$administradores = DB::table('persona')->where('cedula', '=', $user['cedula'])->get();
				foreach ($administradores as $administrador) {
					return view('administrador.administrador',compact(['administrador','user']));
				}
				break;
		}
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
	public function store()
	{
		return redirect()->back();
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
		$user = array(	'nombre' => Session::get('nombre'),
						'apellido' => Session::get('apellido'),
						'sexo' => Session::get('sexo'),
						'cedula' => Session::get('cedula'),
						'tipo_per' => Session::get('tipo_per'),
						'login' => Session::get('login')
					);

		switch ($user['tipo_per']) {
			case 'M': 
				$medicos = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->where('persona.cedula', '=', $user['cedula'])->get();
				foreach ($medicos as $medico) {
					return view('medico.editar.medico',compact(['medico','user']));
				}
				break;
			case 'P':
				$pacientes = DB::table('persona')->join('paciente', 'persona.cedula', '=', 'paciente.cedula')->where('persona.cedula', '=', $user['cedula'])->get();
				foreach ($pacientes as $paciente) {
					return view('paciente.editar.paciente',compact(['paciente','user']));
				}
				break;
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $cedula)
	{
		date_default_timezone_set('America/Caracas');

		$user = array(	'nombre' => Session::get('nombre'),
						'apellido' => Session::get('apellido'),
						'sexo' => Session::get('sexo'),
						'cedula' => Session::get('cedula'),
						'tipo_per' => Session::get('tipo_per'),
						'login' => Session::get('login')
					);

		$data = $request->all();

		$rules = "";
		if($user['tipo_per'] == 'M') {

			$rules = array(
				'login' => 'required|min:5|unique:persona,login,'.$cedula.',cedula',
				'nombre' => 'required',
				'apellido' => 'required',
				'direccion' => 'required',
				'email' => 'required|unique:persona,email,'.$cedula.',cedula',
				'clave' => 'required|min:5',
				'fecha_nac' => 'required|date|date_format:Y-m-d|before:'.date('Y-m-d'),
				'telefono' => 'required|numeric',
				'sexo' => 'required|in:M,F', 
				'num_medico' => 'required|numeric',
				'especialidad' => 'required|in:General,Internista,Pediatria,Geriatria,Neumologia,Odontologia,Psiquiatria',
				'imagen' => 'required|image'
			);
		}
		else
		{
			$rules = array(
				'login' => 'required|min:5|unique:persona,login,'.$cedula.',cedula',
				'nombre' => 'required',
				'apellido' => 'required',
				'direccion' => 'required',
				'email' => 'required|unique:persona,email,'.$cedula.',cedula',
				'clave' => 'required|min:5',
				'fecha_nac' => 'required|date|date_format:Y-m-d|before:'.date('Y-m-d'),
				'telefono' => 'required|numeric',
				'sexo' => 'required|in:M,F', 
				'grupo_sangre' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
				'imagen' => 'required|image'
			);
		}

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$personas = DB::table('persona')->where('cedula', '=', $cedula)->get();
		foreach ($personas as $persona) {
			
			if($persona->imagen != 'NoImagen.jpg'){
				unlink('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/'.$persona->imagen);
			}
			$request->file('imagen')->move('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/', $request->login.'.jpg');

		}

		DB::table('persona')->where('cedula', $cedula)->update(
    		[
    		'login' => $request->login,
    		'nombre' => $request->nombre,
    		'apellido' => $request->apellido,
    		'direccion' => $request->direccion,
    		'email' => $request->email,
    		'clave' => password_hash($request->clave, PASSWORD_DEFAULT),
    		'fecha_nac' => $request->fecha_nac,
    		'telefono' => $request->telefono,
    		'sexo' => $request->sexo,
    		'tipo_per' => 'M',
    		'imagen' => $request->login.'.jpg'
    		]
		);

		if($user['tipo_per'] == 'M'){

			DB::table('medico')->where('cedula', $cedula)->update(
	    		[
	    		'especialidad' => $request->especialidad,
	    		'num_medico' => $request->num_medico
	    		]
			);

		}
		else
		{
			DB::table('paciente')->where('cedula', $cedula)->update(
	    		[
	    		'grupo_sangre' => $request->grupo_sangre
	    		]
			);
		}

		Session::put('login', $request->login);
		Session::put('sexo', $request->sexo);
		Session::put('nombre', $request->nombre);
		Session::put('apellido', $request->apellido);

		Session::flash('message','Los Datos han sido editados satisfactoriamente');

		return redirect()->route('Principal.index');
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
