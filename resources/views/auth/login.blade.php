<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Smart Water Meter</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#f5f7fb] min-h-screen flex items-center justify-center">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT -->
        <div class="bg-[#2191d1] text-white p-10 flex flex-col justify-center relative overflow-hidden">

            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mt-10 -mr-10"></div>
            <div class="absolute bottom-0 left-0 w-52 h-52 bg-white/10 rounded-full -mb-20 -ml-20"></div>

            <div class="relative z-10">

                <h1 class="text-4xl font-bold leading-tight mb-4">
                    Smart Water Meter
                </h1>

                <p class="text-blue-100 text-lg mb-8">
                    Sistem Monitoring dan Otomasi Pembacaan Meter Air PDAM Tirta Dharma Ayu
                </p>

                <div class="space-y-4">

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        <p>Monitoring Real-time</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        <p>Deteksi Anomali Pemakaian</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        <p>Validasi OCR Meter Air</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        <p>Dashboard Monitoring PDAM</p>
                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="p-10 md:p-14 flex items-center">

            <div class="w-full">

                <div class="mb-8">

                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        Login Admin
                    </h2>

                    <p class="text-gray-500">
                        Masuk ke dashboard Smart Water Meter
                    </p>

                </div>

                <form action="/login" method="POST" class="space-y-6">

                    @csrf

                    {{-- Flash / Validation Messages --}}
                    @if(session('error'))
                        <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="p-3 bg-green-50 border border-green-200 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-3 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-md">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email atau No. Pelanggan
                        </label>

                        <input
                            type="text"
                            name="email"
                            placeholder="Masukan email atau nomor pelanggan"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20 focus:border-[#2191d1]"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-4 focus:ring-[#2191d1]/20 focus:border-[#2191d1]"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#2191d1] hover:bg-[#1977ad] transition-all duration-300 text-white font-semibold py-3 rounded-xl shadow-lg"
                    >
                        Masuk
                    </button>

                </form>

                <div class="mt-8 text-center text-sm text-gray-500">
                    © 2026 Smart Water Meter - PDAM Tirta Dharma Ayu
                </div>

            </div>

        </div>

    </div>

</body>
</html>