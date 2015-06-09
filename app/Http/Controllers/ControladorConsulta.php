<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorConsulta extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
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
		$paciente = DB::table('persona')->join('paciente', 'persona.cedula', '=', 'paciente.cedula')->where('persona.cedula','=',$request->cedula_paciente)->first();
		$antecedentes = DB::table('antecedente')->where('cedula','=',$request->cedula_paciente)->get();
		$consultas = DB::table('consulta')->join('cita', 'consulta.cedula_paciente', '=', 'cita.cedula_paciente')->where('consulta.fecha','=','cita.fecha')->where('consulta.hora','=','cita.hora')->get();
		return view('medico.registrar.consulta',compact(['user','paciente','antecedentes','consultas']));
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
