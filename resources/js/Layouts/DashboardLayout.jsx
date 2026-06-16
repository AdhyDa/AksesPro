import React, { useState } from 'react';
import { Link, usePage, router } from '@inertiajs/react';

/**
 * DashboardLayout — Layout utama untuk semua halaman admin dashboard.
 *
 * Props:
 *  - children                — konten halaman
 *  - title                   — judul halaman (untuk <title>)
 */
export default function DashboardLayout({ children, title = 'Admin Dashboard' }) {
    const { auth, flash, csrf_token } = usePage().props;
    const admin = auth?.user || { name: 'Superadmin', role: 'admin' };
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);

    /* ── Navigasi Sidebar ─────────────────────────────────────────── */
    const navItems = [
        {
            href: route('admin.dashboard'),
            label: 'Dashboard',
            routeName: 'admin.dashboard',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                />
            ),
        },
        {
            href: route('admin.produk'),
            label: 'Kelola Produk',
            routeName: 'admin.produk',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                />
            ),
        },
        {
            href: route('admin.transaksi'),
            label: 'Data Transaksi',
            routeName: 'admin.transaksi',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            ),
        },
        {
            href: route('admin.pengguna'),
            label: 'Kelola Pengguna',
            routeName: 'admin.pengguna',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                />
            ),
        },
        {
            href: route('admin.laporan'),
            label: 'Laporan Pendapatan',
            routeName: 'admin.laporan',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
            ),
        },
        {
            href: route('admin.pengaturan'),
            label: 'Pengaturan Sistem',
            routeName: 'admin.pengaturan',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                />
            ),
            icon2: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
            ),
        },
    ];

    /* ── Active Route Detection ───────────────────────────────────── */
    const isActive = (routeName) => {
        try {
            return route().current(routeName);
        } catch {
            return false;
        }
    };

    /* ── Logout Handler ───────────────────────────────────────────── */
    const handleLogout = (e) => {
        e.preventDefault();
        router.post(route('logout'));
    };

    /* ── Avatar URL ───────────────────────────────────────────────── */
    const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(admin?.name ?? 'Admin')}&background=0a2540&color=fff`;

    return (
        <>
            <div className="flex h-screen bg-gray-50 font-sans antialiased text-[#0A2540] overflow-hidden">
                
                {/* Mobile Sidebar Overlay */}
                <div
                    className={`fixed inset-0 z-20 bg-black/50 lg:hidden transition-opacity duration-300 ${
                        sidebarOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'
                    }`}
                    onClick={() => setSidebarOpen(false)}
                />

                {/* Sidebar */}
                <aside
                    className={`fixed inset-y-0 left-0 z-30 w-64 bg-navy text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col ${
                        sidebarOpen ? 'translate-x-0' : '-translate-x-full'
                    }`}
                >
                    {/* Sidebar Header */}
                    <div className="flex h-20 border-b border-white/10 px-6 items-center">
                        <Link href="/" className="flex items-center gap-3">
                            <img
                                src="/Logo.png"
                                alt="AksesPro Logo"
                                className="w-10 h-10 flex-shrink-0 object-contain hover:brightness-110 transition-all duration-300"
                                onError={(e) => {
                                    e.target.src = 'https://ui-avatars.com/api/?name=AksesPro&background=0a2540&color=fff';
                                }}
                            />
                            <span className="text-xl font-bold text-white flex items-center">
                                Akses<span className="text-[#FFD700]">Pro</span>
                            </span>
                        </Link>
                    </div>

                    {/* Sidebar Menu */}
                    <nav className="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                        {navItems.map((item) => {
                            const active = isActive(item.routeName);
                            return (
                                <Link
                                    key={item.routeName}
                                    href={item.href}
                                    className={`flex items-center gap-3 px-4 py-3 rounded-xl transition-colors ${
                                        active
                                            ? 'bg-white/10 text-[#00E5FF]'
                                            : 'text-white/70 hover:bg-white/5 hover:text-white'
                                    }`}
                                >
                                    <svg className="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <Link
                            href={route('home')}
                            className="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/10 hover:text-white rounded-xl transition-colors w-full group"
                        >
                            <svg
                                className="w-5 h-5 text-white/50 group-hover:text-[#00E5FF] transition-colors"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            <span className="font-medium">Kembali ke Beranda</span>
                        </Link>
                    </div>
                </aside>

                {/* Main Content Wrapper */}
                <div className="flex-1 flex flex-col overflow-hidden">
                    {/* Top Navbar */}
                    <header className="flex items-center justify-between h-20 px-6 bg-white border-b border-gray-200 relative z-40">
                        <div className="flex items-center gap-4">
                            {/* Mobile Hamburger */}
                            <button
                                onClick={() => setSidebarOpen(true)}
                                className="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden"
                                aria-label="Buka menu"
                            >
                                <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>

                        <div className="flex items-center gap-4 sm:gap-6">
                            {/* Profile Dropdown */}
                            <div className="relative">
                                <button
                                    onClick={() => setProfileOpen(!profileOpen)}
                                    className="flex items-center gap-3 focus:outline-none"
                                    aria-expanded={profileOpen}
                                >
                                    <div className="w-9 h-9 rounded-full bg-[#00E5FF]/20 text-[#0A2540] flex items-center justify-center font-bold border border-[#00E5FF]/50 overflow-hidden">
                                        <img
                                            src={avatarUrl}
                                            alt="Avatar"
                                            className="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div className="hidden sm:block text-left">
                                        <p className="text-sm font-semibold text-gray-800 leading-none">{admin.name}</p>
                                        <p className="text-xs text-gray-500 mt-1 uppercase">Administrator</p>
                                    </div>
                                    <svg className="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {/* Backdrop overlay for clicking outside */}
                                {profileOpen && (
                                    <div className="fixed inset-0 z-40" onClick={() => setProfileOpen(false)} />
                                )}
                                {/* Dropdown Menu */}
                                <div className={`absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 ring-1 ring-black ring-opacity-5 z-50 transition-all duration-200 transform origin-top-right ${
                                    profileOpen ? 'opacity-100 scale-100' : 'opacity-0 scale-95 pointer-events-none'
                                }`}>
                                    <Link
                                        href={route('profile.edit')}
                                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-navy"
                                        onClick={() => setProfileOpen(false)}
                                    >
                                        Profil Saya
                                    </Link>
                                    <div className="border-t border-gray-100 my-1"></div>
                                    <button
                                        onClick={handleLogout}
                                        className="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                    >
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </header>

                    {/* Main Content Area */}
                    <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-8">
                        {children}
                    </main>
                </div>
            </div>

            {/* Hidden logout form for legacy Dusk tests support */}
            <form action={route('logout')} method="POST" style={{ display: 'none' }}>
                <input type="hidden" name="_token" value={csrf_token || ''} />
            </form>
        </>
    );
}
