<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Dashboard\RegisterUserRequest;
use App\Http\Resources\Dashboard\ListUserResource;
use App\Http\Resources\Dashboard\ShowUserResource;
use App\Mail\ConfirmationAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    /**
     * Amount of rows in package send to front end.
     *
     * @var integer
     */
    private  $amountPackage = 10;
    /**
     * Number of page initial
     *
     * @var integer
     */
    private $firstPage = 1;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($number)
    {
        $countRows = User::where('isDeleted',0)->count();
        $packages = ceil(($countRows/$this->amountPackage)+1);
        if($number == $this->firstPage){
            $users = User::where('isDeleted',0)->skip(0)->take($this->amountPackage)->get();
        }else{
            $users = User::where('isDeleted',0)->skip(($number*$this->amountPackage)-10)->take($this->amountPackage)->get();
        }

        $columns=[
            "ID",
            "NOMBRE",
            "APELLIDO",
            "CORREO",
            "ROL",
            'FECHA REGISTRO'
        ];

        if(Auth::user()->role){
            array_push($columns,"OPCIÓNES");
        }
        
        return response()->json([
            'status' => true,
            'page' => $number,
            'totalPages' => $packages,
            'data' => ListUserResource::collection($users),
            'columns' => $columns,
            'role' => Auth::user()->role,
            'nameUserLogged' => Auth::user()->name,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\RegisterUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterUserRequest $request)
    {
        try{
            if(Auth::user()->role){
            $user = User::create(
                [
            
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            $dataToEmail = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => $request->password,
            ];

            Mail::to($request->email)->send(new ConfirmationAccount([
                $dataToEmail
            ]));
    
            return response()->json([
                'status' => true,
                'user' => $user,
            ],200);

            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'You dont have a permission.',
                ],401);
            }
    
        }catch(Exception $exception){
    
            return response()->json([
                'status' => false,
                'message' => 'Error ocurred in transaction.',
            ],500);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json([
            'status' => true,
            'data' => new ShowUserResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->role){
            $idUser = User::where('id',$request->id)
            ->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'You dont have privileges.',
            ],401);
            
        }
        return response()->json([
            'status' => true,
            'message' => 'User update ',
            'userId' => $idUser,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role){
            User::find($id)->update(['isDeleted' => 1]);
        }
        return response()->json([
            'status' => true,
            'message' => 'User deleted',
        ]);
    }
}
