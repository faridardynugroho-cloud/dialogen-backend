<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query()->latest();

        if ($request->filled('status') && $request->input('status') !== 'semua') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type') && $request->input('type') !== 'semua') {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('platform') && $request->input('platform') !== 'semua') {
            $query->where('platform', $request->input('platform'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $feedbacks = $query->paginate(15)->withQueryString();

        $stats = [
            'total'     => Feedback::count(),
            'baru'      => Feedback::where('status', 'baru')->count(),
            'diproses'  => Feedback::where('status', 'diproses')->count(),
            'selesai'   => Feedback::where('status', 'selesai')->count(),
            'bug'       => Feedback::where('type', 'bug')->count(),
        ];

        return view('admin.feedback.index', [
            'feedbacks' => $feedbacks,
            'stats'     => $stats,
            'filters'   => $request->only(['status', 'type', 'platform', 'search']),
        ]);
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status'      => ['required', 'in:baru,diproses,selesai,diabaikan'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $feedback->update([
            'status'      => $request->input('status'),
            'admin_notes' => $request->input('admin_notes', $feedback->admin_notes),
        ]);

        return back()->with('success', 'Status feedback berhasil diperbarui.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return back()->with('success', 'Feedback berhasil dihapus.');
    }
}
