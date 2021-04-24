<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
		if(Auth::user()->hasAccess()){
        	return $next($request);
		}
		else{
            if(\Request::isMethod('post')) {
                $message = 'No tienes permiso para agregar registros en '.url()->current().' !!';
            }
            elseif(\Request::isMethod('put')) {
                $message = 'No tienes permiso para modificar registros en '.url()->current().' !!';
            }
            elseif(\Request::isMethod('patch')) {
                $message = 'No tienes permiso para modificar registros en '.url()->current().' !!';
            }
            elseif(\Request::isMethod('delete')) {
                $message = 'No tienes permiso para eliminar registros en '.url()->current().' !!';
            }
            elseif(\Request::isMethod('get')) {
                $message = 'No tienes permiso para ingresar a la ruta '.url()->current().' !!';
            }

            if(\Request::ajax()){
                return response()->json([
                        'message' => $message
                    ], 422);
            }
            else{
                Session::flash('flash_message', $message);
                return redirect()->guest(route('home'));
            }
		}
    }
}
