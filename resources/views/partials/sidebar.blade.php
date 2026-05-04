@php
    $currentRoute = $activeRoute ?? '';
    $isAdmin = Session::has('user_logged_in');
    $teacherId = session('user')['id'] ?? '';
    $userName = session('user')['name'] ?? 'Teacher';
    $initials = collect(explode(' ', trim($userName)))
        ->filter()
        ->take(2)
        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');

    $teacherMenus = [
        [
            'id' => 'teacher-input',
            'label' => 'Input',
            'routes' => ['absences', 'payments', 'assessments', 'repost-proofs'],
            'items' => [
                ['label' => 'Absen', 'href' => '/absences', 'route' => 'absences'],
                ['label' => 'Pembayaran', 'href' => '/payments', 'route' => 'payments'],
                ['label' => 'Input Nilai', 'href' => '/assessments', 'route' => 'assessments'],
                ['label' => 'Upload Bukti Repost', 'href' => '/repost-proofs/create', 'route' => 'repost-proofs'],
            ],
        ],
        [
            'id' => 'teacher-operational',
            'label' => 'Operasional',
            'routes' => ['recap-teacher-absences', 'teacher-schedules', 'teacher-schedule'],
            'items' => [
                ['label' => 'Riwayat Mengajar', 'href' => '/recap-teacher-absences?id=' . $teacherId, 'route' => 'recap-teacher-absences'],
                ['label' => 'Jadwal Mengajar', 'href' => '/schedule/teacher/' . $teacherId . '/schedule', 'route' => 'teacher-schedules', 'active_routes' => ['teacher-schedules', 'teacher-schedule']],
            ],
        ],
    ];

    $adminMenus = [
        [
            'id' => 'admin-operational',
            'label' => 'Operasional',
            'routes' => ['dashboard', 'daily-recap', 'daily-recap-payment', 'finance-entries'],
            'items' => [
                ['label' => 'Rekapitulasi Bulanan', 'href' => '/dashboard', 'route' => 'dashboard'],
                ['label' => 'Upah Guru', 'href' => '/daily-recap', 'route' => 'daily-recap'],
                ['label' => 'Pembayaran Murid', 'href' => '/daily-recap-payment', 'route' => 'daily-recap-payment'],
                ['label' => 'Buku Kas', 'href' => '/finance-entries', 'route' => 'finance-entries'],
            ],
        ],
        [
            'id' => 'admin-students',
            'label' => 'Siswa',
            'routes' => ['students', 'payments', 'getUnpaidStudents'],
            'items' => [
                ['label' => 'Data Siswa', 'href' => '/students', 'route' => 'students'],
                ['label' => 'Pembayaran', 'href' => '/payments', 'route' => 'payments'],
                ['label' => 'Tidak Bayar 2 Bulan', 'href' => '/getUnpaidStudents', 'route' => 'getUnpaidStudents'],
            ],
        ],
        [
            'id' => 'admin-schedules',
            'label' => 'Penjadwalan',
            'routes' => ['generate-semester', 'all-schedules', 'update-meeting', 'teacher-schedules', 'teacher-schedule'],
            'items' => [
                ['label' => 'Buat Jadwal', 'href' => route('schedule.generate.form'), 'route' => 'generate-semester'],
                ['label' => 'Cek Semua Jadwal', 'href' => route('schedule.all-schedule'), 'route' => 'all-schedules'],
            ],
        ],
        [
            'id' => 'admin-teachers',
            'label' => 'Guru',
            'routes' => ['teachers', 'recap-teacher-absences'],
            'items' => [
                ['label' => 'Data Guru', 'href' => '/teachers', 'route' => 'teachers'],
            ],
        ],
        [
            'id' => 'admin-courses',
            'label' => 'Kelas',
            'routes' => ['courses'],
            'items' => [
                ['label' => 'Data Kelas', 'href' => '/courses', 'route' => 'courses'],
            ],
        ],
        [
            'id' => 'admin-administration',
            'label' => 'Administrasi',
            'routes' => ['finance-categories'],
            'items' => [
                ['label' => 'Input Pengeluaran', 'href' => '/finance-categories', 'route' => 'finance-categories'],
            ],
        ],
    ];

    $menus = $isAdmin ? $adminMenus : $teacherMenus;
@endphp

<aside id="sidebar"
    class="fixed top-0 left-0 z-20 hidden h-full w-64 flex-shrink-0 pt-20 transition-transform duration-200 lg:flex lg:translate-x-0"
    aria-label="Sidebar">
    <div class="relative flex min-h-screen flex-1 flex-col border-r border-gray-200 bg-white dark:border-slate-700 dark:bg-slate-900">
        <div class="flex flex-1 flex-col overflow-y-auto px-3 pb-4 pt-5">
            <div class="mb-4 rounded-2xl border border-gray-200 bg-gray-50 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 text-sm font-bold text-white shadow-md shadow-blue-900/20">
                        {{ $initials !== '' ? $initials : 'PB' }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-xs uppercase tracking-[0.18em] text-gray-500 dark:text-slate-400">{{ $isAdmin ? 'Administrator' : 'Teacher Panel' }}</p>
                        <h3 class="truncate text-base font-semibold text-gray-900 dark:text-white">{{ $userName }}</h3>
                    </div>
                </div>
            </div>

            <ul class="space-y-2">
                @foreach ($menus as $menu)
                    @php
                        $isOpen = in_array($currentRoute, $menu['routes'], true);
                    @endphp
                    <li class="sidebar-group rounded-2xl border border-transparent bg-white/70 dark:bg-transparent">
                        <button
                            type="button"
                            class="sidebar-toggle flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-left text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-900 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white {{ $isOpen ? 'bg-gray-100 text-gray-900 dark:bg-slate-800 dark:text-white' : '' }}"
                            data-sidebar-target="{{ $menu['id'] }}"
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-slate-200">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M10 3a1 1 0 0 1 .993.883L11 4v5h5a1 1 0 0 1 .117 1.993L16 11h-5v5a1 1 0 0 1-1.993.117L9 16v-5H4a1 1 0 0 1-.117-1.993L4 9h5V4a1 1 0 0 1 1-1Z"/>
                                </svg>
                            </span>
                            <span class="flex-1">{{ $menu['label'] }}</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200 {{ $isOpen ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="{{ $menu['id'] }}" class="sidebar-panel {{ $isOpen ? '' : 'hidden' }}">
                            <ul class="mt-2 space-y-1 border-l border-gray-200 pb-2 pl-4 dark:border-slate-700">
                                @foreach ($menu['items'] as $item)
                                    @php
                                        $itemRoutes = $item['active_routes'] ?? [$item['route']];
                                        $isActive = in_array($currentRoute, $itemRoutes, true);
                                    @endphp
                                    <li>
                                        <a href="{{ $item['href'] }}"
                                            class="flex items-center rounded-xl px-3 py-2 text-sm transition {{ $isActive ? 'bg-blue-50 font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-200' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>

<div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarToggles = document.querySelectorAll('.sidebar-toggle');

        const closeAllPanels = (exceptId = null) => {
            sidebarToggles.forEach((toggle) => {
                const targetId = toggle.dataset.sidebarTarget;
                const panel = document.getElementById(targetId);
                const icon = toggle.querySelector('svg:last-child');
                const shouldKeepOpen = exceptId && targetId === exceptId;

                if (!panel || shouldKeepOpen) {
                    return;
                }

                panel.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.classList.remove('bg-gray-100', 'text-gray-900', 'dark:bg-slate-800', 'dark:text-white');
                if (icon) {
                    icon.classList.remove('rotate-180');
                }
            });
        };

        sidebarToggles.forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const targetId = toggle.dataset.sidebarTarget;
                const panel = document.getElementById(targetId);
                const icon = toggle.querySelector('svg:last-child');

                if (!panel) {
                    return;
                }

                const willOpen = panel.classList.contains('hidden');
                closeAllPanels(willOpen ? targetId : null);

                panel.classList.toggle('hidden', !willOpen);
                toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                toggle.classList.toggle('bg-gray-100', willOpen);
                toggle.classList.toggle('text-gray-900', willOpen);
                toggle.classList.toggle('dark:bg-slate-800', willOpen);
                toggle.classList.toggle('dark:text-white', willOpen);

                if (icon) {
                    icon.classList.toggle('rotate-180', willOpen);
                }
            });
        });
    });
</script>
