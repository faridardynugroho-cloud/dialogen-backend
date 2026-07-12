@extends('admin.layout')

@section('title', 'Feedback & Bug Report')
@section('page_title', 'Feedback & Bug Report')

@section('content')

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        @foreach ([
            ['label' => 'Total Masuk', 'value' => $stats['total'], 'color' => 'from-brand-indigo to-brand-navy'],
            ['label' => 'Baru', 'value' => $stats['baru'], 'color' => 'from-blue-500 to-blue-700'],
            ['label' => 'Diproses', 'value' => $stats['diproses'], 'color' => 'from-amber-500 to-amber-700'],
            ['label' => 'Selesai', 'value' => $stats['selesai'], 'color' => 'from-emerald-500 to-emerald-700'],
            ['label' => 'Laporan Bug', 'value' => $stats['bug'], 'color' => 'from-brand-red to-red-800'],
        ] as $card)
            <div class="bg-panel border border-white/5 rounded-2xl p-5 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-gradient-to-br {{ $card['color'] }} opacity-10"></div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $card['label'] }}</p>
                <p class="mt-2 text-2xl font-extrabold text-white">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- FILTER BAR --}}
    <div class="bg-panel border border-white/5 rounded-2xl p-4 mb-6">
        <form method="GET" action="{{ route('admin.feedback.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       placeholder="Cari judul, deskripsi, atau email..."
                       class="w-full px-4 py-2.5 rounded-xl bg-[#0F0B26] border border-white/10 text-white placeholder-gray-500 text-sm focus:border-brand-red outline-none transition-colors">
            </div>

            <select name="status" class="px-4 py-2.5 rounded-xl bg-[#0F0B26] border border-white/10 text-white text-sm focus:border-brand-red outline-none">
                @foreach (['semua' => 'Semua Status', 'baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'diabaikan' => 'Diabaikan'] as $val => $label)
                    <option value="{{ $val }}" {{ ($filters['status'] ?? 'semua') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="type" class="px-4 py-2.5 rounded-xl bg-[#0F0B26] border border-white/10 text-white text-sm focus:border-brand-red outline-none">
                @foreach (['semua' => 'Semua Jenis', 'bug' => 'Bug', 'saran' => 'Saran', 'lainnya' => 'Lainnya'] as $val => $label)
                    <option value="{{ $val }}" {{ ($filters['type'] ?? 'semua') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="platform" class="px-4 py-2.5 rounded-xl bg-[#0F0B26] border border-white/10 text-white text-sm focus:border-brand-red outline-none">
                @foreach (['semua' => 'Semua Platform', 'android' => 'Android', 'ios' => 'iOS', 'unknown' => 'Unknown'] as $val => $label)
                    <option value="{{ $val }}" {{ ($filters['platform'] ?? 'semua') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-red text-white text-sm font-semibold hover:bg-brand-red/90 transition-colors">
                Filter
            </button>

            @if (array_filter($filters))
                <a href="{{ route('admin.feedback.index') }}" class="px-4 py-2.5 rounded-xl border border-white/10 text-gray-400 text-sm hover:text-white transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-panel border border-white/5 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[900px]">
                <thead>
                    <tr class="bg-panel2 text-left text-xs text-gray-400 uppercase tracking-wide">
                        <th class="px-5 py-3.5 font-semibold">Jenis</th>
                        <th class="px-5 py-3.5 font-semibold">Judul & Deskripsi</th>
                        <th class="px-5 py-3.5 font-semibold">Kontak</th>
                        <th class="px-5 py-3.5 font-semibold">Perangkat</th>
                        <th class="px-5 py-3.5 font-semibold">Tanggal</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($feedbacks as $fb)
                        <tr class="hover:bg-white/[0.02] transition-colors align-top">
                            <td class="px-5 py-4">
                                @php
                                    $typeBadge = [
                                        'bug' => ['🐞', 'bg-red-500/10 text-red-400'],
                                        'saran' => ['💡', 'bg-amber-500/10 text-amber-400'],
                                        'lainnya' => ['💬', 'bg-blue-500/10 text-blue-400'],
                                    ][$fb->type];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeBadge[1] }}">
                                    {{ $typeBadge[0] }} {{ ucfirst($fb->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 max-w-xs">
                                <p class="font-semibold text-white">{{ $fb->title }}</p>
                                <p class="text-gray-400 text-xs mt-1 line-clamp-2">{{ $fb->message }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-400 text-xs">
                                {{ $fb->email ?: '—' }}
                            </td>
                            <td class="px-5 py-4 text-gray-400 text-xs">
                                <p>{{ ucfirst($fb->platform ?? 'unknown') }}</p>
                                @if ($fb->app_version)
                                    <p class="text-gray-500">v{{ $fb->app_version }} ({{ $fb->app_build }})</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-400 text-xs whitespace-nowrap">
                                {{ $fb->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-5 py-4">
                                <form method="POST" action="{{ route('admin.feedback.updateStatus', $fb) }}">
                                    @csrf
                                    @method('PATCH')
                                    @php
                                        $statusColor = [
                                            'baru' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                            'diproses' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'selesai' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'diabaikan' => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
                                        ][$fb->status];
                                    @endphp
                                    <select name="status" onchange="this.form.submit()"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold border outline-none cursor-pointer {{ $statusColor }} bg-[#0F0B26]">
                                        @foreach (['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'diabaikan' => 'Diabaikan'] as $val => $label)
                                            <option value="{{ $val }}" {{ $fb->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('detail-{{ $fb->id }}').showModal()"
                                            class="text-xs text-gray-400 hover:text-white px-2 py-1 rounded-lg hover:bg-white/5 transition-colors">
                                        Detail
                                    </button>
                                    <form method="POST" action="{{ route('admin.feedback.destroy', $fb) }}"
                                          onsubmit="return confirm('Hapus feedback ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 px-2 py-1 rounded-lg hover:bg-red-500/10 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- DETAIL MODAL --}}
                        <tr>
                            <td colspan="7" class="p-0">
                                <dialog id="detail-{{ $fb->id }}" class="backdrop:bg-black/60 rounded-2xl p-0 bg-panel border border-white/10 w-full max-w-lg">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-4">
                                            <div>
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeBadge[1] }} mb-2">
                                                    {{ $typeBadge[0] }} {{ ucfirst($fb->type) }}
                                                </span>
                                                <h3 class="font-bold text-white text-lg">{{ $fb->title }}</h3>
                                            </div>
                                            <button onclick="document.getElementById('detail-{{ $fb->id }}').close()" class="text-gray-400 hover:text-white">✕</button>
                                        </div>
                                        <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-line">{{ $fb->message }}</p>

                                        <div class="mt-5 pt-5 border-t border-white/5 grid grid-cols-2 gap-3 text-xs">
                                            <div>
                                                <p class="text-gray-500">Email</p>
                                                <p class="text-gray-200 mt-0.5">{{ $fb->email ?: '—' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Platform</p>
                                                <p class="text-gray-200 mt-0.5">{{ ucfirst($fb->platform ?? 'unknown') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Versi Aplikasi</p>
                                                <p class="text-gray-200 mt-0.5">{{ $fb->app_version ? "v{$fb->app_version} ({$fb->app_build})" : '—' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">IP Address</p>
                                                <p class="text-gray-200 mt-0.5">{{ $fb->ip_address ?: '—' }}</p>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('admin.feedback.updateStatus', $fb) }}" class="mt-5 pt-5 border-t border-white/5">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $fb->status }}">
                                            <label class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Catatan Internal</label>
                                            <textarea name="admin_notes" rows="2"
                                                      placeholder="Catatan untuk tim (tidak terlihat oleh pengguna)..."
                                                      class="w-full mt-2 px-3 py-2 rounded-lg bg-[#0F0B26] border border-white/10 text-white text-sm outline-none focus:border-brand-red">{{ $fb->admin_notes }}</textarea>
                                            <button type="submit" class="mt-3 px-4 py-2 rounded-lg bg-brand-red text-white text-xs font-semibold hover:bg-brand-red/90">
                                                Simpan Catatan
                                            </button>
                                        </form>
                                    </div>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center text-gray-500">
                                Belum ada feedback yang cocok dengan filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if ($feedbacks->hasPages())
        <div class="mt-6">
            {{ $feedbacks->links() }}
        </div>
    @endif

@endsection
