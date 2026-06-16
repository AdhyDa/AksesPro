import { Link, router, usePage } from '@inertiajs/react';
import { useState } from 'react';

/**
 * UserDashboardLayout — Layout utama untuk semua halaman user dashboard.
 *
 * Props:
 *  - user: { name, points }  — data user dari controller
 *  - children                — konten halaman
 *  - title                   — judul halaman (untuk <title>)
 */
export default function UserDashboardLayout({ user, children, title = 'Dashboard' }) {
    const { url } = usePage();

    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState('');

    /* ── Navigasi Sidebar ─────────────────────────────────────────── */
    const navItems = [
        {
            href: route('user.dashboard'),
            label: 'Beranda',
            routeName: 'user.dashboard',
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
            href: route('user.katalog'),
            label: 'Katalog Produk',
            routeName: 'user.katalog',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                />
            ),
        },
        {
            href: route('user.langganan'),
            label: 'Langganan Aktif',
            routeName: 'user.langganan',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            ),
        },
        {
            href: route('user.transaksi'),
            label: 'Riwayat Transaksi',
            routeName: 'user.transaksi',
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
            href: route('user.poin'),
            label: 'Tukar Poin',
            routeName: 'user.poin',
            icon: (
                <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            ),
        },
    ];

    const supportItem = {
        href: route('user.bantuan'),
        label: 'Bantuan & Support',
        routeName: 'user.bantuan',
        icon: (
            <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
            />
        ),
    };

    /* ── Active Route Detection ───────────────────────────────────── */
    const isActive = (routeName) => {
        try {
            return route().current(routeName);
        } catch {
            return url.includes(routeName.replace('user.', '/user/'));
        }
    };

    /* ── Logout Handler ───────────────────────────────────────────── */
    const handleLogout = (e) => {
        e.preventDefault();
        router.post(route('logout'));
    };

    /* ── Search Handler ───────────────────────────────────────────── */
    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('user.katalog'), { search: searchQuery }, { preserveState: true });
    };

    /* ── Avatar URL ───────────────────────────────────────────────── */
    const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(user?.name ?? 'User')}&background=0A2540&color=fff`;

    /* ── Sidebar NavLink ──────────────────────────────────────────── */
    const NavItem = ({ item, hasBorderTop = false }) => {
        const active = isActive(item.routeName);
        return (
            <Link
                href={item.href}
                className={`flex items-center gap-3 px-4 py-3 rounded-xl transition-colors ${
                    hasBorderTop ? 'mt-4 border-t border-white/10 pt-4' : ''
                } ${
                    active
                        ? 'bg-white/10 text-[#00E5FF]'
                        : 'text-white/70 hover:bg-white/5 hover:text-white'
                }`}
            >
                <svg className="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    {item.icon}
                </svg>
                <span className={active ? 'font-semibold' : 'font-medium'}>{item.label}</span>
            </Link>
        );
    };

    return (
        <>
            <div className="flex h-screen bg-gray-50 font-sans antialiased text-[#0A2540]">

                {/* ── Mobile Sidebar Overlay ── */}
                {sidebarOpen && (
                    <div
                        className="fixed inset-0 z-20 bg-black/50 lg:hidden"
                        onClick={() => setSidebarOpen(false)}
                    />
                )}

                {/* ── Sidebar ── */}
                <aside
                    className={`fixed inset-y-0 left-0 z-30 w-64 bg-[#0A2540] text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col ${
                        sidebarOpen ? 'translate-x-0' : '-translate-x-full'
                    }`}
                >
                    {/* Sidebar Header */}
                    <div className="flex h-20 items-center border-b border-white/10 px-6">
                        {/* ⚠️ Link ke luar tidak perlu navigasi Inertia, gunakan <a> biasa untuk beranda publik */}
                        <a href="/" className="flex items-center gap-3">
                            <img
                                src="/Logo.png"
                                alt="AksesPro Logo"
                                className="h-10 w-10 flex-shrink-0 object-contain transition-all duration-300 group-hover:brightness-110"
                            />
                            <span className="text-xl font-bold text-white flex items-center">
                                Akses<span className="text-[#FFD700]">Pro</span>
                            </span>
                        </a>
                    </div>

                    {/* Sidebar Menu */}
                    <div className="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                        {navItems.map((item) => (
                            <NavItem key={item.routeName} item={item} />
                        ))}
                        <NavItem item={supportItem} />
                    </div>

                    {/* Sidebar Footer — Kembali ke Beranda */}
                    <div className="p-4 border-t border-white/10">
                        {/* ⚠️ Ini navigasi ke halaman publik (landing page), gunakan <a> bukan <Link> */}
                        <a
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
                        </a>
                    </div>
                </aside>

                {/* ── Main Content Wrapper ── */}
                <div className="flex flex-1 flex-col overflow-hidden">

                    {/* Top Navbar */}
                    <header className="relative z-40 flex h-20 items-center justify-between border-b border-gray-200 bg-white px-6">
                        <div className="flex items-center gap-4">
                            {/* Mobile Hamburger */}
                            <button
                                onClick={() => setSidebarOpen(true)}
                                className="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden"
                                aria-label="Buka menu"
                            >
                                <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>

                            {/* Search Bar — submit → Inertia router.get */}
                            <form onSubmit={handleSearch} className="relative hidden sm:block">
                                <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg className="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input
                                    type="text"
                                    id="search-katalog"
                                    name="search"
                                    value={searchQuery}
                                    onChange={(e) => setSearchQuery(e.target.value)}
                                    placeholder="Cari sesuatu..."
                                    className="block w-64 rounded-full border border-gray-300 bg-gray-50 py-2.5 pl-10 pr-4 text-sm text-gray-900 transition-shadow focus:border-[#00E5FF] focus:ring-[#00E5FF]"
                                />
                            </form>
                        </div>

                        <div className="flex items-center gap-4 sm:gap-6">
                            {/* Profile Dropdown */}
                            <div className="relative">
                                <button
                                    id="profile-menu-btn"
                                    onClick={() => setProfileOpen(!profileOpen)}
                                    className="flex items-center gap-3 focus:outline-none"
                                    aria-expanded={profileOpen}
                                    aria-haspopup="true"
                                >
                                    <div className="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full border border-[#00E5FF]/50 bg-[#00E5FF]/20">
                                        <img src={avatarUrl} alt="Avatar" className="h-full w-full object-cover" />
                                    </div>
                                    <div className="hidden text-left sm:block">
                                        <p className="text-sm font-semibold leading-none text-gray-800">
                                            {user?.name ?? 'User'}
                                        </p>
                                        <p className="mt-1 text-xs text-gray-500">Member</p>
                                    </div>
                                    <svg className="hidden h-4 w-4 text-gray-400 sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {/* Dropdown */}
                                {profileOpen && (
                                    <div
                                        id="profile-dropdown"
                                        className="absolute right-0 mt-2 w-48 rounded-xl border border-gray-100 bg-white py-2 shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                        onMouseLeave={() => setProfileOpen(false)}
                                    >
                                        <Link
                                            href={route('profile.edit')}
                                            className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#0A2540]"
                                        >
                                            Profil Saya
                                        </Link>
                                        <div className="my-1 border-t border-gray-100" />
                                        <button
                                            onClick={handleLogout}
                                            id="logout-btn"
                                            className="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
                                        >
                                            Logout
                                        </button>
                                    </div>
                                )}
                            </div>
                        </div>
                    </header>

                    {/* Main Content */}
                    <main className="flex-1 overflow-y-auto overflow-x-hidden bg-gray-50 p-6 lg:p-8">
                        {children}
                    </main>
                </div>
            </div>

            {/* Hidden logout form for legacy Dusk tests support */}
            <form action={route('logout')} method="POST" style={{ display: 'none' }}>
                <input type="hidden" name="_token" value={usePage().props.csrf_token || ''} />
            </form>
        </>
    );
}
