<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index()
    {
        $orders = WorkOrder::latest()->paginate(10);
        return view('work_orders.index', compact('orders'));
    }

    public function create()
    {
        return view('work_orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'assigned_to' => ['nullable','integer'],
            'status' => ['required','in:pendiente,en_progreso,completada,cancelada'],
            'due_date' => ['nullable','date'],
        ]);

        WorkOrder::create($data);

        return redirect()->route('work-orders.index')->with('status', 'Orden creada ✅');
    }
}