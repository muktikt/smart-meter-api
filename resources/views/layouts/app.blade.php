<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Smart Water Meter' }}</title>

    <!-- VITE -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DATATABLE -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.tailwindcss.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-[#f5f7fb] font-[Inter] overflow-hidden">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    @include('layouts.sidebar')

    <!-- MAIN -->
    <div class="flex-1 flex flex-col ml-[290px]">

        <!-- NAVBAR -->
        @include('layouts.navbar')

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 mt-[95px]">

            @yield('content')

        </main>

    </div>

</div>

<!-- SWEET ALERT SUCCESS -->
@if(session('success'))

<script>

    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#2191d1',
        timer: 2500,
        showConfirmButton: false
    });

</script>

@endif

<!-- SWEET ALERT ERROR -->
@if(session('error'))

<script>

    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        confirmButtonColor: '#ef4444'
    });

</script>

@endif

<!-- GLOBAL DATATABLE -->
<script>

    $(document).ready(function () {

        $('.datatable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                emptyTable: "Belum ada data untuk ditampilkan",
                paginate: {
                    previous: "Prev",
                    next: "Next"
                }
            }
        });

    });

</script>

@stack('scripts')

</body>

</html>