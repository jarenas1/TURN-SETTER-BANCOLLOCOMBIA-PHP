<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::with('user')->paginate(10);
        return view('admin.counters.index', compact('counters'));
    }

    public function create()
    {
        return view('admin.counters.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:counters|max:50']);
        
        Counter::create($request->only('name'));
        
        return redirect()->route('admin.counters.index')
            ->with('success', 'Taquilla creada');
    }

    public function edit(Counter $counter)
    {
        return view('admin.counters.edit', compact('counter'));
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'name' => 'required|unique:counters,name,'.$counter->id.'|max:50'
        ]);
        
        $counter->update($request->only('name'));
        
        return redirect()->route('admin.counters.index')
            ->with('success', 'Taquilla actualizada');
    }

    public function destroy(Counter $counter)
    {
        // Reasignar tickets si es necesario
        Ticket::where('counter_id', $counter->id)
            ->update(['counter_id' => null]);
        
        $counter->delete();
        
        return redirect()->route('admin.counters.index')
            ->with('success', 'Taquilla eliminada');
    }
}