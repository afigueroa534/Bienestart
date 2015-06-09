<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorAgenda extends Controller {

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
		date_default_timezone_set('America/Caracas');
		$citas = DB::table('cita')->join('persona', 'persona.cedula', '=', 'cita.cedula_paciente')->where('cita.cedula_medico','=',$user['cedula'])->where('cita.fecha','>=',date('Y-m-d'))->where('cita.estado','<>','C')->orderBy('cita.fecha','asc')->paginate(10);
		return view('medico.listados.agenda',compact(['citas','user']));
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
