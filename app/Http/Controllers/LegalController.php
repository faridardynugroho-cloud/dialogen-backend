<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LegalController extends Controller
{
    public function about()
    {
        return view('legal.about');
    }

    public function privacy()
    {
        return view('legal.privacy_policy', [
            'updatedAt' => '12 Juli 2026',
        ]);
    }

    public function terms()
    {
        return view('legal.terms', [
            'updatedAt' => '12 Juli 2026',
        ]);
    }

    public function feedbackForm()
    {
        return view('legal.feedback');
    }

    public function feedbackSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type'    => ['required', 'in:bug,saran,lainnya'],
            'title'   => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
            'email'   => ['nullable', 'email', 'max:150'],
        ], [
            'type.required'    => 'Pilih jenis masukan terlebih dahulu.',
            'title.required'   => 'Judul singkat wajib diisi.',
            'title.max'        => 'Judul terlalu panjang (maksimal 150 karakter).',
            'message.required' => 'Ceritakan detail masukan kamu.',
            'message.max'      => 'Deskripsi terlalu panjang (maksimal 3000 karakter).',
            'email.email'      => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Feedback::create([
            'type'        => $request->input('type'),
            'title'       => $request->input('title'),
            'message'     => $request->input('message'),
            'email'       => $request->input('email'),
            'app_version' => $request->input('app_version'),
            'app_build'   => $request->input('app_build'),
            'platform'    => $request->input('platform', 'unknown'),
            'ip_address'  => $request->ip(),
        ]);

        return redirect()
            ->route('legal.feedback')
            ->with('success', 'Masukan kamu sudah kami terima. Tim Dialogen akan meninjaunya secepat mungkin.');
    }
}
