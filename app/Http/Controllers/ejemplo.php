
<!-- Esto es en el create, osea en el register -->

$tipo = $request->input('tipo');

        if($tipo == 'Vendedor'){
            $persona = $this->persona_repositorio->create($request->get('nombre'),$request->get('primer_apellido'),
                            $request->get('segundo_apellido'),$request->get('telefono'),$request->get('codigo_postal'));

            $user = $this->user_repositorio->create($request->get('nombre'),$request->get('primer_apellido'),
                            $request->get('segundo_apellido'),$request->get('email'),Hash::make($request->get('password')),$persona->id);

            $vendedor = $this->vendedor_repositorio->create($request->get('codigo_vendedor'),$request->get('rfc'),$persona->id);
            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token','persona','vendedor'),201);
        }elseif ($tipo == 'Cliente') {
            $persona = $this->persona_repositorio->create($request->get('nombre'),$request->get('primer_apellido'),$request->get('segundo_apellido'),$request->get('telefono'),$request->get('codigo_postal'));

            $cliente = $this->cliente_repositorio->create($request->get('numero_tarjeta'),$persona->id);

            return response()->json(compact('cliente','persona'),201);
        }

        <!-- Esto es en el update -->

 $tipo = $request->get('tipo');

if($tipo == 'Vendedor'){
    $persona = $this->persona_repositorio->update($request->get('nombre'),$request->get('primer_apellido'),$request->get('segundo_apellido'),$request->get('telefono'),$request->get('codigo_postal'),$id);

    $user = $this->user_repositorio->update($request->get('nombre'),$request->get('primer_apellido'),
                    $request->get('segundo_apellido'),$request->get('email'),$persona);

    $vendedor = $this->vendedor_repositorio->update($request->get('codigo_vendedor'),$request->get('rfc'),$persona);

    return response()->json(compact('user','persona','vendedor'),201);
}elseif ($tipo == 'Cliente') {
    $persona = $this->persona_repositorio->update($request->get('nombre'),$request->get('primer_apellido'),$request->get('segundo_apellido'),$request->get('telefono'),$request->get('codigo_postal'),$id);

    $cliente = $this->cliente_repositorio->update($request->get('numero_tarjeta'),$persona);

    return response()->json(compact('cliente','persona'),201);
}
}


<!-- Esto es del delete -->

public function delete($id)
    {
        $vendedor = Vendedores::where('id_persona','=',$id)->first();
        $cliente =  Clientes::where('id_persona','=',$id)->first();
        if ($vendedor != ''){
            $user = User::where('id_persona','=',$id)->first();
            $user = $user->id;
            $vendedor = $vendedor->id;
            $vendedor = $this->vendedor_repositorio->delete($vendedor);
            $user = $this->user_repositorio->delete($user);
            $persona = $this->persona_repositorio->delete($id);

            return response()->json('Datos eliminados');
        }elseif ($cliente != '') {
            $cliente = $cliente->id;
            $cliente = $this->cliente_repositorio->delete($cliente);
            $persona = $this->persona_repositorio->delete($id);

            return response()->json('Datos eliminados');
        }
        return response()->json('La persona que intentas eliminar no existe');
    }