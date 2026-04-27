@extends('admin.dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-black text-gray-900 mb-2 uppercase italic tracking-tighter">Riwayat Aktivitas Sistem</h1>
    <p class="text-gray-500 mb-10">Merekam jejak audit setiap tindakan penting yang dilakukan oleh Admin.</p>

    <div class="bg-white border-2 border-gray-50 rounded-[2.5rem] shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Admin</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tindakan</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Deskripsi</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($logs as $log)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-900 block">{{ $log->created_at->format('d M Y') }}</span>
                        <span class="text-[10px] text-gray-400 font-medium">{{ $log->created_at->format('H:i:s') }} WIB</span>
                    </td>
                    <td class="px-8 py-5 text-sm font-black text-red-600 uppercase">
                        {{ $log->user->name ?? 'System' }}
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[9px] font-black uppercase tracking-tighter">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-xs text-gray-500 font-medium leading-relaxed">
                        {{ $log->description }}
                    </td>
                    <td class="px-8 py-5 text-[10px] font-mono text-gray-400 text-right">
                        {{ $log->ip_address }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <p class="text-gray-400 text-sm font-medium">Belum ada rekaman aktivitas.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $logs->links() }}
    </div>
</div>
@endsection