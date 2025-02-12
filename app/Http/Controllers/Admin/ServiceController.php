<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount('tickets')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:services|max:255',
            'prefix' => 'required|unique:services|size:1|alpha'
        ]);
        
        Service::create($request->all());
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Servicio creado');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|unique:services,name,'.$service->id.'|max:255',
            'prefix' => 'required|unique:services,prefix,'.$service->id.'|size:1|alpha'
        ]);
        
        $service->update($request->all());
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Servicio actualizado');
    }

    public function destroy(Service $service)
    {
        // Eliminar tickets asociados
        $service->tickets()->delete();
        $service->delete();
        
        return redirect()->route('admin.services.index')
            ->with('success', 'Servicio eliminado');
    }
}