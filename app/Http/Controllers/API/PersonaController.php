<?php namespace ConsultaMedica\Http\Controllers\API;

use ConsultaMedica\Http\Requests;
use ConsultaMedica\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\FAcades\Session;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
use ConsultaMedica\Models\Persona;

class PersonaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        try{
            $result = Persona::all();
            if($result->count()==0){
                return response()->json(['msg' => 'No hay resultados', 'status'=>'404'],404);
            }else{
                return response()->json([
                    'msg' => 'Succes',
                    'status' => '200',
                    'persona' => $result->toArray()
                    ],200
                );
            }
        }catch (\Exception $ex){
            return response()->json([
                'msg' => 'Faild',
                'status' => '405'
                 ],405
            );
        }
    }


    public function login($login, $pass){
        try{
            $persona = DB::table('persona')->where('login', '=', $login)->get();
           // dd($persona);
           // $a = $persona->toArray;
            //dd($a);
          //  dd($persona->clave);
            if($persona == null){
                return response()->json(['msg' => 'Usuario no Registrado', 'status' => '404'],404);
            }else{

                foreach ($persona as $pers){
                    //dd($pass);
                    if (password_verify($pass, $pers->clave)) {

                        return response()->json([
                            'msg' => 'Succes',
                            'status' => '200',
                            'persona' => $persona
                        ],200
                        );

                    }else{
                        return response()->json([
                            'msg' => 'Contrasena incorrecta',
                            'status' => '200'
                        ],200
                        );
                    }
                }


            }
        }catch (\Exception $ex){
            return response()->json([
                'msg' => $ex->getMessage(),
                'status' => '405'
            ],405
            );
        }
    }



	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        try{

            $persona = new Persona($request->all());
            $persona->setAttribute('clave',\Hash::make($request->get('clave')));
            $persona->save();
            DB::table('paciente')->insert(['cedula' => $request->cedula]);
            return response()->json([
                'msg' => 'Registro exitoso',
                'status' => '201',
                'persona' => $persona->toArray()
            ],201
            );

        }catch (\Exception $ex){
            return response()->json(['msg' => 'Usuario no Registrado', 'status' => '205'],205);
        }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */



	public function show($id)
	{
        try{
            $persona = DB::table('persona')
                ->where('login','=',$id)
                ->leftjoin('paciente', 'persona.cedula', '=', 'paciente.cedula')
                ->select('persona.*', 'paciente.grupo_sangre')
                ->get();

            //$persona = Persona::where('cedula', $id)->get();
            //dd($persona);
            if($persona == null){
                return response()->json(['msg' => 'Usuario no registrado', 'status' => '404'],404);
            }else{
                return response()->json([
                    'msg' => 'Succes',
                    'status' => '200',
                    'persona' => $persona
                ],200
                );
            }
        }catch (\Exception $ex){
            return response()->json([
                'msg' => 'Faild',
                'status' => '405'
            ],405
            );
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
        try{

            DB::table('persona')
                ->where('cedula', $id)
                ->update(['telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'sexo' => $request->sexo,
                'fecha_nac'=> $request->fecha_nac]);

            DB::table('paciente')
                ->where('cedula',$id)
                ->update(['grupo_sangre'=>$request->grupo_sangre]);

            return response()->json([
                'msg' => 'Succes',
                'status' => '200'],200
            );

        }catch (\Exception $ex){
            return response()->json(['msg' => 'Error al actualizar', 'status' => '205'],205);
        }
	}


    public function restartPassword(Request $request){
        $personas = DB::table('persona')->where('email', '=', $request->email)->get();
        if($personas == null)
        {
            return response()->json([
                'msg' => 'Failed',
                'status' => '200'],200
            );

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

                /*\Mail::send('email', compact(['persona','clave']), function($message) use ($persona)
                {
                    $message->from('jhonnyflorez23@gmail.com')
                        ->to($persona->email, $persona->nombre.' '.$persona->apellido)
                        ->subject('Nuevo Password');
                });*/

                $data = array(
                    'customer' => 'John Smith',
                    'url' => 'http://laravel.com'
                );

                \Mail::send('emails.welcome',$data, function($message)
                {
                    $message->from('jflorez0310@gmail.com', 'Laravel');

                    $message->to('jflorez0310@gmail.com')->cc('bar@example.com');


                });

                return response()->json([
                    'msg' => 'Succes',
                    'status' => '405'],405
                );
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
        //  dd($id);
        try{

            $p = Persona::where('cedula', '=',$id)->get();


            if($p->count()==0){
                return response()->json(['msg' => 'No Found'],404);
            }else{
                $p->forceDelete();
                return response()->json(['msg' => 'Succes'],204);
            }
        }catch (\Exception $ex){
            return response()->json([
                'msg' => 'Faild',
            ],405
            );
        }
	}




}
