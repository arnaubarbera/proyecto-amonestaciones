<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            Log::info('Intento de login', ['dni' => $request->dni]);

            $request->validate([
                'dni' => 'required|string',
                'password' => 'required|string',
            ]);

            $profesor = Profesor::where('dni', $request->dni)->first();

            if (!$profesor) {
                Log::warning('Profesor no encontrado', ['dni' => $request->dni]);
                return response()->json([
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }

            if (!Hash::check($request->password, $profesor->password)) {
                Log::warning('Contraseña incorrecta', ['dni' => $request->dni]);
                return response()->json([
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }

            Log::info('Login exitoso', ['dni' => $request->dni]);

            return response()->json([
                'dni' => $profesor->dni,
                'nombre' => $profesor->nombre,
                'apellidos' => $profesor->apellidos,
                'correo' => $profesor->correo,
                'telefono' => $profesor->telefono
            ]);
        } catch (\Exception $e) {
            Log::error('Error en login', [
                'error' => $e->getMessage(),
                'dni' => $request->dni
            ]);
            return response()->json([
                'message' => 'Error al procesar la solicitud'
            ], 500);
        }
    }
} 