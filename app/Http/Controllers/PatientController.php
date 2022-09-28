<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::patients()->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required',
            'address' => 'nullable',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'cedula.required' => 'El carnet de identidad es obligatorio',
            'phone.required' => 'El teléfono es obligatorio',
        ];
        $this->validate($request, $rules, $messages);

        User::create(
            $request->only('name', 'email', 'cedula', 'address', 'phone')
            + [
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
        );
        $notification = 'El paciente se ha registrado correctamente.';
        return redirect('/pacientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = User::patients()->findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required',
            'address' => 'nullable',
            'phone' => 'required',
        ];
        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'cedula.required' => 'El carnet de identidad es obligatorio',
            'phone.required' => 'El teléfono es obligatorio',
        ];
        $this->validate($request, $rules, $messages);
        $user = User::patients()->findOrFail($id);

        $data = $request->only('name', 'email', 'cedula', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);
        
        $user->fill($data);
        $user->save();

        $notification = 'La información se actualizó correctamente.';
        return redirect('/pacientes')->with(compact('notification'));   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::patients()->findOrFail($id);
        $pacienteName = $user->name;
        $user->delete();

        $notification = "El médico $pacienteName ha sido eliminado.";

        return redirect('/pacientes')->with(compact('notification'));
    }
}
