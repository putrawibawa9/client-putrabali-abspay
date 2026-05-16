@if (Session::has('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ Session::get('error') ?? ($error ?? '') }}",
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'custom-decline-button'
            },
            buttonsStyling: true,
            confirmButtonColor: '#dc3545'
        })
    </script>
@endif
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="A comprehensive Content Management System (CMS) for managing English language courses, students, schedules, and educational resources at Putra Bali English Course">
    <meta name="author" content="Muhammad Sufyan">

    <title>Putra Bali English Course | Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://flowbite-admin-dashboard.vercel.app//app.css">
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://flowbite-admin-dashboard.vercel.app/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://flowbite-admin-dashboard.vercel.app/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://flowbite-admin-dashboard.vercel.app/favicon-16x16.png">
    <link rel="icon" type="image/png" href="https://flowbite-admin-dashboard.vercel.app/favicon.ico">
    <link rel="manifest" href="https://flowbite-admin-dashboard.vercel.app/site.webmanifest">
    <link rel="mask-icon" href="https://flowbite-admin-dashboard.vercel.app/safari-pinned-tab.svg" color="#5bbad5">

    @stack('css')

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        .custom-confirm-button {
            background-color: #1d4ed8;
        }

        .custom-decline-button {
            background-color: #dc3545;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-800">
    @include('.partials.navbar')

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('partials.sidebar')


        {{-- Main Content --}}
        <div id="main-content"
            class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 pt-6 lg:pt-0 dark:bg-gray-900">
            <main class="min-h-0 lg:min-h-[calc(100vh-9rem)]">

                @yield('content')

            </main>
        </div>
    </div>


    @include('partials.footer')


    {{-- Script --}}
    <script async defer src="{{ asset('flowbite/js/buttons.js') }}"></script>
    <script src="{{ asset('flowbite/js/app.bundle.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Expose server-side session idle timeout and useful endpoints to the client.
        // SESSION_IDLE_TIMEOUT is in seconds (from config('session.idle_timeout')).
        window.SESSION_IDLE_TIMEOUT = {{ config('session.idle_timeout', 900) }};
        // How many seconds before actual logout we show a warning modal (client-side)
        window.IDLE_WARNING_SECONDS = 30;
        window.PING_URL = "{{ url('/ping') }}";
        window.LOGOUT_URL = "{{ route('logout') }}";
    </script>


  
    @if (Session::has('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: "{{ Session::get('error') ?? ($error ?? '') }}",
                icon: 'error',
                confirmButtonText: 'OK',
                 customClass: {
                    confirmButton: 'custom-confirm-button'
                },
                buttonsStyling: true,
                confirmButtonColor: 'rgb(37, 99, 235)',
            })
        </script>
    @endif
    @if (Session::has('success'))
        {{-- Untuk !empty dapat dihilangkan nanti saat redirect page sudah diimplementasikan (untuk menghindari bug alert) --}}
        {{-- Contoh @if (Session::has('success')) --}}
        <script>
            const whatsappInvoice = @json(session('whatsapp_invoice'));
            const invoiceWarning = @json(session('invoice_warning'));
            const paymentSuccessSummary = @json(session('payment_success_summary'));
            const successMessage = @json(Session::get('success') ?? ($success ?? ''));
            const paymentSummaryHtml = Array.isArray(paymentSuccessSummary) && paymentSuccessSummary.length
                ? `
                    <div style="text-align:left;">
                        <div style="margin-bottom:12px;">${successMessage}</div>
                        <div style="font-weight:600;margin-bottom:10px;">Payment berhasil disimpan:</div>
                        <ul style="margin:0;padding-left:18px;">
                            ${paymentSuccessSummary.map((payment) => `
                                <li style="margin-bottom:8px;">
                                    <div>${payment.type_label || 'Payment'} - ${payment.amount_label || '-'}</div>
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                `
                : successMessage;

            Swal.fire({
                title: 'Success!',
                html: paymentSummaryHtml,
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'custom-confirm-button'
                },
                buttonsStyling: true,
                confirmButtonColor: '#1d4ed8' // Change this to your desired color
            }).then(async () => {
                if (invoiceWarning) {
                    await Swal.fire({
                        title: 'Invoice WhatsApp belum bisa dikirim',
                        text: invoiceWarning,
                        icon: 'warning',
                        confirmButtonText: 'Mengerti',
                        customClass: {
                            confirmButton: 'custom-confirm-button'
                        },
                        buttonsStyling: true,
                        confirmButtonColor: '#d97706'
                    });
                }

                if (whatsappInvoice && whatsappInvoice.url) {
                    const result = await Swal.fire({
                        title: 'Kirim invoice via WA?',
                        text: `Ringkasan pembayaran untuk ${whatsappInvoice.student_name || 'siswa'} siap dikirim ke ${whatsappInvoice.phone || 'nomor siswa'}.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Kirim Sekarang',
                        cancelButtonText: 'Nanti Saja',
                        customClass: {
                            confirmButton: 'custom-confirm-button',
                            cancelButton: 'custom-decline-button'
                        },
                        buttonsStyling: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#6b7280'
                    });

                    if (result.isConfirmed) {
                        window.open(whatsappInvoice.url, '_blank', 'noopener');
                    }
                }
            });
        </script>
    @endif

    {{-- Script untuk poplate data student di fitur update --}}
    <script src="{{ asset('js/students.js') }}"></script>



    {{-- Script untuk poplate data teacher di fitur update --}}
    <script src="{{ asset('js/teacher.js') }}"></script>

    {{-- Script untuk poplate data course di fitur update --}}
    <script src="{{ asset('js/course.js') }}"></script>

    <script src="{{ asset('js/change-custom-payment-rate.js') }}"></script>

    

    @stack('js')

    {{-- script untuk absensi --}}
    <script>
        document.getElementById('attendance-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Gather form data
            const form = event.target;
            const formData = new FormData(form);

            // Construct the JSON object
            const jsonData = {
                day: "Tuesday", // Add static or dynamically retrieved values here
                date: "2021-06-03",
                time: "11:00",
                course_id: 1,
                teacher_id: 5,
                attendances: [],
            };

            // Process the form inputs
            const students = document.querySelectorAll('tbody tr');
            students.forEach((row, index) => {
                const studentId = row.querySelector(`input[name^="student-"]`).name.match(/\d+/)[0];
                const status = row.querySelector(`input[name="student-${studentId}"]:checked`);

                if (status) {
                    jsonData.attendances.push({
                        students_courses_id: studentId,
                        status: status.value
                    });
                }
            });

            console.log(JSON.stringify(jsonData, null, 2)); // For debugging purposes

            // Send the JSON to your server
            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                            .value // Include CSRF token
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    // Optionally handle success feedback
                })
                .catch((error) => {
                    console.error('Error:', error);
                    // Optionally handle error feedback
                });
        });
    </script>

</body>

</html>
