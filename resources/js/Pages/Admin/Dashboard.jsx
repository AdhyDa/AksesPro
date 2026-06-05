import { useState } from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import FlashMessage from '@/Components/FlashMessage';

/**
 * Admin/Dashboard.jsx
 *
 * Props dari AdminDashboardController::index():
 *   - admin:              { name }
 *   - stats:              { monthly_revenue, revenue_trend, total_users, users_trend,
 *                           successful_orders, orders_trend, complaint_tickets, tickets_trend }
 *   - recentTransactions: Array<{ user, product, total, payment, status }>
 *   - chartLabels:        string[]
 *   - chartData:          number[]
 *   - categoryLabels:     string[]
 *   - categoryData:       number[]
 *   - recentUsers:        Array<{ name, email, points, date, status }>
 *   - periode:            'bulan-ini' | 'bulan-lalu' | 'tahun-ini'
 *
 * Shared via HandleInertiaRequests:
 *   - auth.user:  { id, name, email, role, points }
 *   - flash:      { success, error, warning }
 */
export default function AdminDashboard({
    admin,
    stats,
    recentTransactions,
    chartLabels,
    chartData,
    categoryLabels,
    categoryData,
    recentUsers,
    periode,
}) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);

    /* ── Periode Filter ───────────────────────────────────────────── */
    const periodeOptions = [
        { value: 'bulan-ini',   label: 'Bulan Ini' },
        { value: 'bulan-lalu',  label: 'Bulan Lalu' },
        { value: 'tahun-ini',   label: 'Tahun Ini' },
    ];

    const handlePeriodeChange = (val) => {
        router.get(route('admin.dashboard'), { periode: val }, { preserveState: false });
    };

    /* ── Logout ───────────────────────────────────────────────────── */
    const handleLogout = (e) => {
        e.preventDefault();
        router.post(route('logout'));
    };

    /* ── Sidebar Nav Items ────────────────────────────────────────── */
    const navItems = [
        { href: route('admin.dashboard'), label: 'Dashboard', routeName: 'admin.dashboard', icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /> },
        { href: route('admin.produk'),    label: 'Produk',    routeName: 'admin.produk',    icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /> },
        { href: route('admin.transaksi'), label: 'Transaksi', routeName: 'admin.transaksi', icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /> },
        { href: route('admin.pengguna'), label: 'Pengguna',   routeName: 'admin.pengguna',  icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /> },
        { href: route('admin.laporan'),  label: 'Laporan',    routeName: 'admin.laporan',   icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /> },
        { href: route('admin.pengaturan'), label: 'Pengaturan', routeName: 'admin.pengaturan', icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />, icon2: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /> },
    ];

    const isActive = (routeName) => {
        try { return route().current(routeName); } catch { return false; }
    };

    /* ── Stat Cards ───────────────────────────────────────────────── */
    const statCards = [
        { label: 'Pendapatan Bulan Ini', value: stats.monthly_revenue, trend: stats.revenue_trend, color: 'blue',   isPositive: stats.revenue_trend?.startsWith('+'), icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /> },
        { label: 'Total Pengguna',       value: stats.total_users,     trend: stats.users_trend,   color: 'indigo', isPositive: true, icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /> },
        { label: 'Transaksi Sukses',     value: stats.successful_orders, trend: stats.orders_trend, color: 'emerald', isPositive: stats.orders_trend?.startsWith('+'), icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /> },
        { label: 'Tiket Komplain',       value: stats.complaint_tickets, trend: stats.tickets_trend, color: 'orange', isPositive: false, icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /> },
    ];

    const colorMap = {
        blue:    { bg: 'bg-blue-50',    text: 'text-blue-600' },
        indigo:  { bg: 'bg-indigo-50',  text: 'text-indigo-600' },
        emerald: { bg: 'bg-emerald-50', text: 'text-emerald-600' },
        orange:  { bg: 'bg-orange-50',  text: 'text-orange-600' },
    };

    const statusBadge = (status) => {
        const map = {
            'Sukses': 'bg-green-50 text-green-700',
            'Menunggu': 'bg-yellow-50 text-yellow-700',
            'Gagal': 'bg-red-50 text-red-700',
        };
        return map[status] ?? 'bg-gray-50 text-gray-700';
    };

    const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(auth?.user?.name ?? 'Admin')}&background=0A2540&color=fff`;

    return (
        <div className="flex h-screen bg-gray-50 font-sans antialiased text-[#0A2540]">
            <Head title="Dashboard Admin — AksesPro" />

            {/* ── Mobile Overlay ── */}
            {sidebarOpen && (
                <div className="fixed inset-0 z-20 bg-black/50 lg:hidden" onClick={() => setSidebarOpen(false)} />
            )}

            {/* ── Sidebar ── */}
            <aside className={`fixed inset-y-0 left-0 z-30 w-64 bg-[#0A2540] text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col ${sidebarOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                {/* Sidebar Header */}
                <div className="flex h-20 items-center border-b border-white/10 px-6">
                    {/* ⚠️ Beranda publik → <a> biasa, bukan <Link> */}
                    <a href="/" className="flex items-center gap-3">
                        <img src="/Logo.png" alt="AksesPro" className="h-10 w-10 flex-shrink-0 object-contain" />
                        <span className="text-xl font-bold">Akses<span className="text-[#FFD700]">Pro</span></span>
                    </a>
                </div>

                {/* Badge Admin */}
                <div className="px-4 pt-4">
                    <div className="rounded-xl bg-white/10 px-4 py-2 text-center">
                        <p className="text-xs font-semibold uppercase tracking-widest text-white/50">Panel Admin</p>
                    </div>
                </div>

                {/* Nav */}
                <nav className="flex-1 overflow-y-auto py-4 px-4 space-y-1">
                    {navItems.map((item) => {
                        const active = isActive(item.routeName);
                        return (
                            <Link
                                key={item.routeName}
                                href={item.href}
                                className={`flex items-center gap-3 rounded-xl px-4 py-3 transition-colors ${active ? 'bg-white/10 text-[#00E5FF]' : 'text-white/70 hover:bg-white/5 hover:text-white'}`}
                            >
                                <svg className="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {item.icon}
                                    {item.icon2}
                                </svg>
                                <span className={active ? 'font-semibold' : 'font-medium'}>{item.label}</span>
                            </Link>
                        );
                    })}
                </nav>

                {/* Sidebar Footer */}
                <div className="p-4 border-t border-white/10">
                    <Link href={route('user.dashboard')}
                        className="flex items-center gap-3 rounded-xl px-4 py-3 text-white/70 hover:bg-white/10 hover:text-white transition-colors"
                    >
                        <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span className="font-medium">Lihat Toko</span>
                    </Link>
                </div>
            </aside>

            {/* ── Main ── */}
            <div className="flex flex-1 flex-col overflow-hidden">
                {/* Topbar */}
                <header className="relative z-40 flex h-20 items-center justify-between border-b border-gray-200 bg-white px-6">
                    <div className="flex items-center gap-4">
                        <button onClick={() => setSidebarOpen(true)} className="text-gray-500 lg:hidden">
                            <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h1 className="text-lg font-bold text-[#0A2540]">Dashboard Admin</h1>
                            <p className="text-xs text-gray-400">Selamat datang, {auth?.user?.name ?? admin?.name}</p>
                        </div>
                    </div>

                    <div className="flex items-center gap-4">
                        {/* Periode Selector */}
                        <select
                            value={periode}
                            onChange={(e) => handlePeriodeChange(e.target.value)}
                            className="hidden sm:block rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-medium text-gray-700 focus:border-[#00E5FF] focus:ring-[#00E5FF]"
                            id="periode-selector"
                        >
                            {periodeOptions.map((opt) => (
                                <option key={opt.value} value={opt.value}>{opt.label}</option>
                            ))}
                        </select>

                        {/* Profile Dropdown */}
                        <div className="relative">
                            <button
                                id="admin-profile-btn"
                                onClick={() => setProfileOpen(!profileOpen)}
                                className="flex items-center gap-2"
                            >
                                <img src={avatarUrl} alt="Avatar" className="h-9 w-9 rounded-full border-2 border-[#00E5FF]/30" />
                                <div className="hidden sm:block text-left">
                                    <p className="text-sm font-semibold text-gray-800">{auth?.user?.name ?? admin?.name}</p>
                                    <p className="text-xs text-gray-500">Administrator</p>
                                </div>
                            </button>
                            {profileOpen && (
                                <div
                                    id="admin-profile-dropdown"
                                    className="absolute right-0 mt-2 w-48 rounded-xl border border-gray-100 bg-white py-2 shadow-lg z-50"
                                    onMouseLeave={() => setProfileOpen(false)}
                                >
                                    <Link href={route('profile.edit')} className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</Link>
                                    <div className="my-1 border-t border-gray-100" />
                                    <button onClick={handleLogout} id="admin-logout-btn" className="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </div>
                            )}
                        </div>
                    </div>
                </header>

                {/* Content */}
                <main className="flex-1 overflow-y-auto p-6 lg:p-8 space-y-6">
                    {/* Flash Messages */}
                    <FlashMessage />

                    {/* Stat Cards */}
                    <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                        {statCards.map((card) => {
                            const c = colorMap[card.color];
                            return (
                                <div key={card.label} className="flex items-start gap-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                                    <div className={`flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg ${c.bg} ${c.text}`}>
                                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">{card.icon}</svg>
                                    </div>
                                    <div>
                                        <p className="text-sm font-medium text-gray-500">{card.label}</p>
                                        <h3 className="text-2xl font-bold text-gray-900">{card.value}</h3>
                                        <p className={`mt-1 text-xs font-medium ${card.isPositive ? 'text-green-500' : 'text-red-500'}`}>
                                            {card.trend} vs. periode lalu
                                        </p>
                                    </div>
                                </div>
                            );
                        })}
                    </div>

                    {/* Recent Transactions + Recent Users */}
                    <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        {/* Recent Transactions */}
                        <div className="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div className="flex items-center justify-between border-b border-gray-100 p-5">
                                <h2 className="font-bold text-gray-900">Transaksi Terbaru</h2>
                                <Link href={route('admin.transaksi')} className="text-xs font-semibold text-[#00b8cc] hover:underline">
                                    Lihat Semua →
                                </Link>
                            </div>
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm">
                                    <thead className="bg-gray-50 text-xs uppercase text-gray-500">
                                        <tr>
                                            <th className="px-5 py-3 text-left">Pengguna</th>
                                            <th className="px-5 py-3 text-left">Produk</th>
                                            <th className="px-5 py-3 text-left">Total</th>
                                            <th className="px-5 py-3 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {(recentTransactions ?? []).length === 0 ? (
                                            <tr><td colSpan={4} className="px-5 py-8 text-center text-gray-400">Belum ada transaksi.</td></tr>
                                        ) : (
                                            (recentTransactions ?? []).map((trx, idx) => (
                                                <tr key={idx} className="border-b hover:bg-gray-50">
                                                    <td className="px-5 py-3 font-medium text-gray-800">{trx.user}</td>
                                                    <td className="px-5 py-3 text-gray-600">{trx.product}</td>
                                                    <td className="px-5 py-3 font-semibold text-gray-800">{trx.total}</td>
                                                    <td className="px-5 py-3">
                                                        <span className={`rounded-md px-2 py-1 text-xs font-semibold ${statusBadge(trx.status)}`}>
                                                            {trx.status}
                                                        </span>
                                                    </td>
                                                </tr>
                                            ))
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {/* Recent Users */}
                        <div className="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                            <div className="flex items-center justify-between border-b border-gray-100 p-5">
                                <h2 className="font-bold text-gray-900">Pengguna Baru</h2>
                                <Link href={route('admin.pengguna')} className="text-xs font-semibold text-[#00b8cc] hover:underline">
                                    Lihat Semua →
                                </Link>
                            </div>
                            <div className="divide-y divide-gray-50">
                                {(recentUsers ?? []).length === 0 ? (
                                    <div className="px-5 py-8 text-center text-gray-400">Belum ada pengguna baru.</div>
                                ) : (
                                    (recentUsers ?? []).map((usr, idx) => (
                                        <div key={idx} className="flex items-center gap-4 px-5 py-3 hover:bg-gray-50">
                                            <img
                                                src={`https://ui-avatars.com/api/?name=${encodeURIComponent(usr.name)}&background=e0f2fe&color=0284c7&size=32`}
                                                alt={usr.name}
                                                className="h-8 w-8 rounded-full flex-shrink-0"
                                            />
                                            <div className="min-w-0 flex-1">
                                                <p className="truncate text-sm font-medium text-gray-800">{usr.name}</p>
                                                <p className="truncate text-xs text-gray-500">{usr.email}</p>
                                            </div>
                                            <div className="text-right flex-shrink-0">
                                                <p className="text-xs font-semibold text-[#00b8cc]">{usr.points} Pts</p>
                                                <p className="text-xs text-gray-400">{usr.date}</p>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div className="grid grid-cols-2 gap-4 sm:grid-cols-4">
                        {[
                            { href: route('admin.produk'),    label: 'Kelola Produk',   color: 'bg-blue-600' },
                            { href: route('admin.transaksi'), label: 'Cek Transaksi',   color: 'bg-indigo-600' },
                            { href: route('admin.pengguna'),  label: 'Kelola User',     color: 'bg-emerald-600' },
                            { href: route('admin.laporan'),   label: 'Lihat Laporan',   color: 'bg-orange-600' },
                        ].map((btn) => (
                            <Link
                                key={btn.label}
                                href={btn.href}
                                className={`${btn.color} flex items-center justify-center rounded-xl py-4 text-center text-sm font-bold text-white shadow-sm transition-all hover:opacity-90 hover:shadow-md`}
                            >
                                {btn.label}
                            </Link>
                        ))}
                    </div>
                </main>
            </div>
        </div>
    );
}
