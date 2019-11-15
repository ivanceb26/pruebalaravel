<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class UsuarioController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombres' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:usuario'],
            'cedula' => ['required', 'numeric', 'unique:usuario'],
            'telefono' => ['required', 'numeric', 'min:8'],
        ]);
    }
    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'id' => ['required', 'numeric'],
            'nombres' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255'],
            'cedula' => ['required', 'numeric'],
            'telefono' => ['required', 'numeric', 'min:8'],
        ]);
    }

    protected function create(array $data)
    {
        return Usuario::create([
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'cedula' => $data['cedula'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
        ]);
    }

    protected function update(array $data)
    {
        $user = Usuario::find($data['id']);
        $user->nombres = $data['nombres']; 
        $user->apellidos = $data['apellidos']; 
        $user->cedula = $data['cedula']; 
        $user->correo = $data['correo']; 
        $user->telefono = $data['telefono']; 
        //dd($user);
        $user->save();
    }

    protected function validarCorreoyDocumentoUnico(Request $request){
         $errors=[];
        //unique email validation for update
        if(!Usuario::where('correo',$request->correo)->where('id','!=',$request->id)->get()->isEmpty()){
            $errors['correo']='El correo ya existe, no se ha actualizado el registro.' ;
        }
        //unique document validation for update
        if(!Usuario::where('cedula',$request->cedula)->where('id','!=',$request->id)->get()->isEmpty()){
            $errors['cedula']='La cedula ya existe, no se ha actualizado el registro.' ;
        }
        return $errors;
    }

    public function crearUsuario(Request $request){
        $validator = $this->validator($request->all());
        if($validator->fails()){
            return $validator->errors();
        }
        $respuesta = false;
        if($this->create($request->all())){
            $respuesta = "ok";
        }else{
            $respuesta = "false";
        }
        $data=['resp'=>$respuesta];
        return response()->json($data);
    }

    

    public function actualizarUsuario(Request $request){
        //return $request->all();
        $validator = $this->validatorUpdate($request->all());
        if($validator->fails()){
            return $validator->errors();
        }
        //return ['msg'=>!Usuario::where('correo',$request->correo)->where('id','!=',$request->id)->get()->isEmpty()];
        $errors = $this->validarCorreoyDocumentoUnico($request);
        if(!empty($errors)){
            return response()->json([$errors]);
        }

        try {
            $this->update($request->all());
            $respuesta = "ok";
        }catch(\Illuminate\Database\QueryException $e){
            $respuesta = "sin cambios"; 
        }

        $data=['resp'=>$respuesta];
        return response()->json($data);
    }

    public function listarUsuario(Request $request){

        return response()->json(Usuario::get());
    }

    public function buscarUsuario(Request $request,$id){
        return response()->json(Usuario::find($id));
    }

    public function testDB(){
        try {
            DB::connection()->getPdo();
            if(DB::connection()->getDatabaseName()){
                echo "Yes! Successfully connected to the DB: " . DB::connection()->getDatabaseName();
            }else{
                die("Could not find the database. Please check your configuration.");
            }
        } catch (\Exception $e) {
            die("Could not open connection to database server.  Please check your configuration.");
        }
    }

}
