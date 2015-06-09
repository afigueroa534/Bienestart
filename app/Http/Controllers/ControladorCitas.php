<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorCitas extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Session::get('tipo_per') != 'P')
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
		$citas = DB::table('cita')->join('persona', 'cita.cedula_medico', '=', 'persona.cedula')->join('medico', 'cita.cedula_medico', '=', 'medico.cedula')->where('cita.cedula_paciente','=',$user['cedula'])->orderBy('cita.fecha','desc')->orderBy('cita.hora','desc')->paginate(10);
		return view('paciente.listados.cita',compact(['citas','user']));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Session::get('tipo_per') != 'P')
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

		return view('paciente.registrar.cita',compact(['user']));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		if(Session::get('tipo_per') != 'P')
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
			'medico' => 'required|exists:medico,cedula',
			'fecha' => 'required|date|date_format:Y-m-d|after:'.date('Y-m-d'),
			'hora' => 'required|in:08:00:00,09:00:00,10:00:00,14:00:00,15:00:00,16:00:00'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$cambio = DB::table('cita')->where('fecha', '=', $request->fecha)->where('hora', '=', $request->hora)->where('cedula_paciente', '=', $user['cedula'])->count();
		
		$cantidad = DB::table('cita')->where('fecha', '=', $request->fecha)->where('hora', '=', $request->hora)->where('cedula_paciente', '=', $user['cedula'])->where('estado', '<>', 'C')->count();
		if($cantidad != 0)
		{
			$errors = array('cantidad' => 'Lo sentimos ya tiene una cita para esa fecha y hora, intente de nuevo');
			return redirect()->back()->withErrors($errors)->withInput($request->all());
		}

		$cantidad = DB::table('cita')->where('fecha', '=', $request->fecha)->where('hora', '=', $request->hora)->where('cedula_medico', '=', $request->medico)->where('estado','<>','C')->count();
		if($cantidad != 0)
		{
			$errors = array('cantidad' => 'Lo sentimos la fecha ya fue ocupada por otro paciente, intente de nuevo');
			return redirect()->back()->withErrors($errors)->withInput($request->all());
		}

		$cantidad = DB::table('evento')->where('cedula', '=', $request->medico)->where('fecha_inicio','<=',$request->fecha)->where('fecha_final','>=',$request->fecha)->count();
		if($cantidad != 0)
		{
			$errors = array('cantidad' => 'Lo sentimos la fecha ya fue ocupada, intente de nuevo');
			return redirect()->back()->withErrors($errors)->withInput($request->all());
		}

		if($cambio == 0){
			DB::table('cita')->insert(
	    		[
	    		'cedula_paciente' => $user['cedula'], 
	    		'cedula_medico' => $request->medico,
	    		'hora' => $request->hora,
	    		'fecha' => $request->fecha,
	    		'estado' => 'P',
	    		]
			);
		}
		else
		{
			DB::table('cita')->where('cedula_paciente','=', $user['cedula'])->where('fecha','=', $request->fecha)->where('hora','=', $request->hora)->update(
	    		[
	    		'cedula_paciente' => $user['cedula'],
	    		'cedula_medico' => $request->medico,
	    		'estado' => 'P'
	    		]
			);
		}

		Session::flash('message','La cita a sido registrada satisfactoriamente');

		return redirect()->route('Citas.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request)
	{
		if(Session::get('tipo_per') != 'P')
		{
			return redirect()->back();
		}
		switch ($request->opcion) {
			case 1:
				$medicos = DB::table('persona')->join('medico', 'persona.cedula', '=', 'medico.cedula')->where('medico.especialidad','=',$request->especialidad)->orderBy('persona.nombre','desc')->get();
				return response()->json([
		                'msg' => $medicos
		            ]);
				break;
			case 2:
				date_default_timezone_set('America/Caracas');
				$eventos = DB::table('medico')->join('evento', 'medico.cedula', '=', 'evento.cedula')->where('medico.cedula','=',$request->cedula)->get();
				$citas = DB::table('medico')->join('cita', 'medico.cedula', '=', 'cita.cedula_medico')->where('medico.cedula','=',$request->cedula)->where('cita.estado','<>','C')->where('cita.fecha','>=',date('Y-m-d'))->orderBy('cita.fecha','asc')->get();
				return response()->json([
		                'eventos' => $eventos,
		                'citas' => $citas
		            ]);
				break;
		}
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($fecha,Request $request)
	{
		if(Session::get('tipo_per') != 'P')
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
		DB::table('cita')->where('cedula_paciente','=', $user['cedula'])->where('fecha','=', $fecha)->where('hora','=', $request->hora)->update(
    		[
    		'estado' => 'C',
    		]
		);

		Session::flash('message','La cita a sido cancelada satisfactoriamente');

		return redirect()->route('Citas.index');
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
