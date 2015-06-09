<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorListadoMedico extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		if(Session::get('tipo_per') != 'A')
		{
			return redirect()->back();
		}
		$user = array(	'nombre' => Session::get('nombre'),
						'apellido' => Session::get('apellido'),
						'sexo' => Session::get('sexo'),
						'cedula' => Session::get('cedula'),
						'tipo_per' => Session::get('tipo_per'),
						'login' => Session::get('login')
					);

		$nombre = $request->get('nombre');
		$medicos = "";
		if($nombre != ""){
			$medicos = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->where('persona.nombre','like','%'.$nombre.'%')->orWhere('persona.apellido', 'like', '%'.$nombre.'%')->orderBy('persona.cedula','asc')->paginate(10);
		}
		else
		{
			$medicos = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->orderBy('persona.cedula','asc')->paginate(10);
		}
		return view('administrador.listados.medico',compact(['medicos','user']));
	}

	public function create()
	{
		if(Session::get('tipo_per') != 'A')
		{
			return redirect()->back();
		}
		$user = array(	'nombre' => Session::get('nombre'),
						'apellido' => Session::get('apellido'),
						'sexo' => Session::get('sexo'),
						'cedula' => Session::get('cedula'),
						'tipo_per' => Session::get('tipo_per'),
						'login' => Session::get('login')
					);
		return view('administrador.registrar.medico',compact(['user']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(Session::get('tipo_per') != 'A')
		{
			return redirect()->back();
		}
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
			'num_medico' => 'required|numeric',
			'especialidad' => 'required|in:General,Internista,Pediatria,Geriatria,Neumologia,Odontologia,Psiquiatria',
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
    		'tipo_per' => 'M',
    		'imagen' => $request->login.'.jpg'
    		]
		);

		$request->file('imagen')->move('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/', $request->login.'.jpg');

		DB::table('medico')->insert(
    		[
    		'cedula' => $request->cedula, 
    		'especialidad' => $request->especialidad,
    		'num_medico' => $request->num_medico
    		]
		);

		Session::flash('message','El Medico '.$request->nombre.' '.$request->apellido.' a sido registrado satisfactoriamente');

		return redirect()->route('Medicos.index');
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
	public function edit($cedula)
	{ 
		if(Session::get('tipo_per') != 'A')
		{
			return redirect()->back();
		}
		$user = array(	'nombre' => Session::get('nombre'),
						'apellido' => Session::get('apellido'),
						'sexo' => Session::get('sexo'),
						'cedula' => Session::get('cedula'),
						'tipo_per' => Session::get('tipo_per'),
						'login' => Session::get('login')
					);

		$medico = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->where('persona.cedula', '=', $cedula)->first();
		return view('administrador.editar.medico',compact(['medico','user']));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $cedula)
	{
		if(Session::get('tipo_per') != 'A')
		{
			return redirect()->back();
		}
		date_default_timezone_set('America/Caracas');

		$data = $request->all();

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

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$medico = DB::table('persona')->where('cedula', '=', $cedula)->first();
		if($medico->imagen != 'NoImagen.jpg'){
			unlink('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/'.$medico->imagen);
		}
		$request->file('imagen')->move('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/', $request->login.'.jpg');

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

		DB::table('medico')->where('cedula', $cedula)->update(
    		[ 
    		'especialidad' => $request->especialidad,
    		'num_medico' => $request->num_medico
    		]
		);

		Session::flash('message','El Medico '.$request->nombre.' '.$request->apellido.' a sido Editado');

		return redirect()->route('Medicos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $cedula)
	{
		if(Session::get('tipo_per') != 'A')
		{
			return redirect()->back();
		}
		$medico = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->where('persona.cedula', '=', $cedula)->first();
		
		DB::table('persona')->where('cedula', '=', $cedula)->delete();

		if($medico->imagen != 'NoImagen.jpg'){
			unlink('C:/wamp/www/Proyectos/ConsultaMedica/public/imagen_usuario/'.$medico->imagen);
		}

		Session::flash('message','El Medico '.$medico->nombre.' '.$medico->apellido.' a sido Eliminado');

		return redirect()->route('Medicos.index');
	}

}
