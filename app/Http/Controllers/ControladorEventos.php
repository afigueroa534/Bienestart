<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorEventos extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Session::get('tipo_per') != 'M')
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
		$eventos = DB::table('evento')->join('medico', 'evento.cedula', '=', 'medico.cedula')->where('evento.cedula','=',$user['cedula'])->orderBy('evento.fecha_inicio','desc')->paginate(10);
		return view('medico.listados.evento',compact(['eventos','user']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Session::get('tipo_per') != 'M')
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

		return view('medico.registrar.evento',compact(['user']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(Session::get('tipo_per') != 'M')
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
		date_default_timezone_set('America/Caracas');
		$data = $request->all();
		$rules = array(
			'fecha_final' => 'required|date|date_format:Y-m-d|after:'.$request->fecha_inicio,
			'fecha_inicio' => 'required|date|date_format:Y-m-d|after:'.date('Y-m-d'),
			'descripcion' => 'required|in:Vacacion,Convencion,Reunion,Motivo Personal'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$num = DB::table('evento')->where('cedula', '=', $user['cedula'])->max('id_evento');
		$num++;

		DB::table('evento')->insert(
    		[
    		'cedula' => $user['cedula'], 
    		'id_evento' => $num,
    		'descripcion' => $request->descripcion,
    		'fecha_inicio' => $request->fecha_inicio,
    		'fecha_final' => $request->fecha_final,
    		]
		);

		DB::table('cita')->where('cedula_medico','=', $user['cedula'])->where('fecha','>=', $request->fecha_inicio)->where('fecha','<=', $request->fecha_final)->update(
    		[
    		'estado' => 'C'
    		]
		);

		Session::flash('message','El Evento '.$request->descripcion.' que inicia el '.$request->fecha_inicio.' a sido registrado satisfactoriamente');

		return redirect()->route('Eventos.index');
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
	public function edit(Request $request,$id_evento)
	{
		if(Session::get('tipo_per') != 'M')
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

		$evento = DB::table('evento')->where('cedula', '=', $user['cedula'])->where('id_evento', '=', $id_evento)->first();
		return view('medico.editar.evento',compact(['evento','user']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id_evento)
	{
		if(Session::get('tipo_per') != 'M')
		{
			return redirect()->back();
		}
		$data = $request->all();

		date_default_timezone_set('America/Caracas');
		$rules = array(
			'fecha_final' => 'required|date|date_format:Y-m-d|after:'.$request->fecha_inicio,
			'fecha_inicio' => 'required|date|date_format:Y-m-d|after:'.date('Y-m-d'),
			'descripcion' => 'required|in:Vacacion,Convencion,Reunion,Motivo Personal'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		DB::table('evento')->where('cedula', $request->cedula)->where('id_evento', $id_evento)->update(
    		[
    		'descripcion' => $request->descripcion,
    		'fecha_inicio' => $request->fecha_inicio,
    		'fecha_final' => $request->fecha_final,
    		]
		);

		DB::table('cita')->where('cedula_medico','=', $user['cedula'])->where('fecha','>=', $request->fecha_inicio)->where('fecha','<=', $request->fecha_final)->update(
    		[
    		'estado' => 'C'
    		]
		);

		Session::flash('message','El Evento '.$request->descripcion.' que inicia el '.$request->fecha_inicio.' a sido Editado');

		return redirect()->route('Eventos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id_evento)
	{
		if(Session::get('tipo_per') != 'M')
		{
			return redirect()->back();
		}
		$evento = DB::table('evento')->where('cedula', '=', $request->cedula)->where('id_evento', '=', $id_evento)->first();
		
		DB::table('evento')->where('cedula', '=', $request->cedula)->where('id_evento', '=', $id_evento)->delete();

		Session::flash('message','El Evento '.$evento->descripcion.' a sido Eliminado');

		return redirect()->route('Eventos.index');
	}

}
