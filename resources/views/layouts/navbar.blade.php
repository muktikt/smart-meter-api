<header class="fixed top-0 right-0 left-[290px] h-[95px] bg-white border-b border-gray-100 px-8 flex items-center justify-between z-40">

    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Smart Water Meter
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Dashboard Monitoring PDAM Tirta Dharma Ayu
        </p>
    </div>

    <div class="flex items-center gap-4">

        <!-- SEARCH -->
        <form action="/pelanggan" method="GET" class="hidden lg:block">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari pelanggan..."
                    class="w-[340px] h-[52px] bg-[#f5f7fb] border border-gray-200 rounded-2xl px-5 pl-12 outline-none focus:ring-4 focus:ring-[#2191d1]/20 focus:border-[#2191d1]"
                >

                <span class="absolute left-4 top-3.5 text-gray-400 text-lg">
                    🔍
                </span>
            </div>
        </form>

        <!-- NOTIF PENGADUAN -->
        <a href="/pengaduan"
           class="w-12 h-12 rounded-2xl bg-[#f5f7fb] hover:bg-blue-50 transition-all flex items-center justify-center text-xl relative">

            🔔

            @php
                $notifPengaduan = \App\Models\Pengaduan::whereIn('status', ['pending', 'proses'])->count();
            @endphp

            @if($notifPengaduan > 0)
                <span class="absolute -top-1 -right-1 min-w-[20px] h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center px-1">
                    {{ $notifPengaduan }}
                </span>
            @endif
        </a>

        <!-- WARNING ANOMALI -->
        <a href="/meter/anomali"
           class="w-12 h-12 rounded-2xl bg-[#f5f7fb] hover:bg-red-50 transition-all flex items-center justify-center text-xl relative">

            ⚠️

            @php
                $notifAnomali = \App\Models\MeterReading::where('pemakaian', '>', 100)->count();
            @endphp

            @if($notifAnomali > 0)
                <span class="absolute -top-1 -right-1 min-w-[20px] h-5 bg-yellow-500 text-white text-xs rounded-full flex items-center justify-center px-1">
                    {{ $notifAnomali }}
                </span>
            @endif
        </a>

        <!-- PROFILE -->
        <a href="{{ url('/admin-profile') }}" class="flex items-center gap-3 bg-[#f5f7fb] hover:bg-blue-50 transition-all px-4 py-2 rounded-2xl">

            <div class="w-11 h-11 rounded-2xl bg-[#2191d1] flex items-center justify-center text-white font-bold">
                A
            </div>

            <div>
                <h3 class="font-semibold text-gray-700">
                    Admin PDAM
                </h3>

                <p class="text-xs text-gray-400">
                    Administrator
                </p>
            </div>

        </a>

        <!-- LOGOUT -->
        <form action="/logout" method="POST">
            @csrf

            <button
                type="submit"
                class="bg-red-500 hover:bg-red-600 transition-all duration-300 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg">
                Logout
            </button>
        </form>

    </div>

</header>