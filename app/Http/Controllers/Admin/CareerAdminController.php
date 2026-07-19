<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Illuminate\Http\Request;

class CareerAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = CareerApplication::query()->latest();

        if ($request->filled('status') && array_key_exists($request->status, CareerApplication::STATUSES)) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(20)->withQueryString();

        return view('admin.careers.index', compact('applications'));
    }

    public function update(Request $request, CareerApplication $application)
    {
        $data = $request->validate([
            'status' => ['nullable', 'in:' . implode(',', array_keys(CareerApplication::STATUSES))],
            'notes'  => ['nullable', 'string', 'max:5000'],
        ]);

        $application->update(array_filter([
            'status' => $data['status'] ?? null,
            'notes'  => $data['notes'] ?? null,
        ], fn ($v) => ! is_null($v)));

        return back()->with('success', 'Application updated.');
    }

    public function download(CareerApplication $application)
    {
        abort_unless($application->cv_path && file_exists(public_path($application->cv_path)), 404);

        return response()->download(public_path($application->cv_path));
    }

    public function destroy(CareerApplication $application)
    {
        if ($application->cv_path && file_exists(public_path($application->cv_path))) {
            @unlink(public_path($application->cv_path));
        }
        $application->delete();

        return back()->with('success', 'Application deleted.');
    }
}
