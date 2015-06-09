<?php namespace ConsultaMedica\Http\Controllers;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

class ControladorHistorial extends Controller {

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
		$antecedentes = DB::table('antecedente')->join('paciente', 'paciente.cedula', '=', 'antecedente.cedula')->where('paciente.cedula','=',$user['cedula'])->orderBy('antecedente.edad','desc')->paginate(10);
		return view('paciente.listados.antecedente',compact(['antecedentes','user']));
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

		return view('paciente.registrar.antecedente',compact(['user']));
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

		$data = $request->all();

		$persona = DB::table('persona')->select('fecha_nac')->where('cedula', '=', $user['cedula'])->first();

		$rules = array(
			'edad' => 'required|numeric|min:0|max:'.$this->calcularEdad($persona->fecha_nac),
			'descripcion' => 'required'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		$num = DB::table('antecedente')->where('cedula', '=', $user['cedula'])->max('id_antecedente');
		$num++;

		DB::table('antecedente')->insert(
    		[
    		'cedula' => $user['cedula'], 
    		'id_antecedente' => $num,
    		'descripcion' => $request->descripcion,
    		'edad' => $request->edad
    		]
		);

		Session::flash('message','El Antecedente a sido registrado satisfactoriamente');

		return redirect()->route('Historial.index');
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
	public function edit(Request $request,$id_antecedente)
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

		$antecedente = DB::table('antecedente')->where('cedula', '=', $user['cedula'])->where('id_antecedente', '=', $id_antecedente)->first();
		return view('paciente.editar.antecedente',compact(['antecedente','user']));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id_antecedente)
	{
		if(Session::get('tipo_per') != 'P')
		{
			return redirect()->back();
		}
		$data = $request->all();

		$persona = DB::table('persona')->select('fecha_nac')->where('cedula', '=', $request->cedula)->first();

		$rules = array(
			'edad' => 'required|numeric|min:0|max:'.$this->calcularEdad($persona->fecha_nac),
			'descripcion' => 'required'
		);

		$validacion = Validator::make($data,$rules);

		if($validacion->fails()){
			return redirect()->back()->withErrors($validacion->errors())->withInput($request->all());
		}

		DB::table('antecedente')->where('cedula', $request->cedula)->where('id_antecedente','=', $id_antecedente)->update(
    		[
    		'descripcion' => $request->descripcion,
    		'edad' => $request->edad,
    		]
		);

		Session::flash('message','El Antecedente a sido Editado satisfactoriamente');

		return redirect()->route('Historial.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id_antecedente)
	{
		if(Session::get('tipo_per') != 'P')
		{
			return redirect()->back();
		}
		DB::table('antecedente')->where('cedula', '=', $request->cedula)->where('id_antecedente', '=', $id_antecedente)->delete();

		Session::flash('message','El Antecedente a sido Eliminado');

		return redirect()->route('Historial.index');
	}

	function calcularEdad($fechanacimiento){

	    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
	    $ano_diferencia  = date("Y") - $ano;
	    $mes_diferencia = date("m") - $mes;
	    $dia_diferencia   = date("d") - $dia;
	    if ($dia_diferencia < 0 || $mes_diferencia < 0)
	        $ano_diferencia--;
	    return $ano_diferencia;

	}

}
