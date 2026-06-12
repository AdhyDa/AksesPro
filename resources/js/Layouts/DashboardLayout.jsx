import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function DashboardLayout({ children, title = 'Dashboard' }) {
    const { auth } = usePage().props;
    const user = auth?.user || { name: 'User', role: 'member', points: 0 };
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [profileOpen, setProfileOpen] = useState(false);

    // Dynamic class helper for active sidebar links
    const isUrlActive = (routeName) => {
        try {
            return route().current(routeName);
        } catch (e) {
            return false;
        }
    };

    const linkClass = (routeName) => {
        return isUrlActive(routeName)
            ? 'flex items-center gap-3 px-4 py-3 rounded-xl transition-colors bg-white/10 text-[#00E5FF]'
            : 'flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-white/70 hover:bg-white/5 hover:text-white';
    };

    const handleLogout = (e) => {
        e.preventDefault();
        import('@inertiajs/react').then(({ router }) => {
            router.post(route('logout'));
        });
    };

    return (
        <div className="flex h-screen bg-gray-50 font-sans antialiased text-[#0A2540] overflow-hidden">
            {/* Mobile Sidebar Overlay */}
            {sidebarOpen && (
                <div
                    className="fixed inset-0 z-20 bg-black/50 lg:hidden transition-opacity duration-300"
                    onClick={() => setSidebarOpen(false)}
                />
            )}

            {/* Sidebar */}
            <aside
                className={`fixed inset-y-0 left-0 z-30 w-64 bg-[#0A2540] text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col ${
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
                                e.target.src = 'https://ui-avatars.com/api/?name=AksesPro&background=0A2540&color=fff';
                            }}
                        />
                        <span className="text-xl font-bold text-white flex items-center">
                            Akses<span className="text-[#FFD700]">Pro</span>
                        </span>
                    </Link>
                </div>

                {/* Sidebar Menu */}
                <div className="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                    <Link href={route('user.dashboard')} className={linkClass('user.dashboard')}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span className="font-semibold">Beranda</span>
                    </Link>

                    <Link href={route('user.katalog')} className={linkClass('user.katalog')}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span className="font-medium">Katalog Produk</span>
                    </Link>

                    <Link href={route('user.langganan')} className={linkClass('user.langganan')}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span className="font-medium">Langganan Aktif</span>
                    </Link>

                    <Link href={route('user.transaksi')} className={linkClass('user.transaksi')}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span className="font-medium">Riwayat Transaksi</span>
                    </Link>

                    <Link href={route('user.poin')} className={linkClass('user.poin')}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span className="font-medium">Tukar Poin</span>
                    </Link>

                    <Link href={route('user.bantuan')} className={linkClass('user.bantuan')}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span className="font-medium">Bantuan & Support</span>
                    </Link>
                </div>

                {/* Sidebar Footer */}
                <div className="p-4 border-t border-white/10">
                    <a
                        href={route('home')}
                        className="flex items-center gap-3 px-4 py-3 text-white/70 hover:bg-white/10 hover:text-white rounded-xl transition-colors w-full group"
                    >
                        <svg className="w-5 h-5 text-white/50 group-hover:text-[#00E5FF] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span className="font-medium">Kembali ke Beranda</span>
                    </a>
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
                        >
                            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        {/* Search Bar */}
                        <form
                            action={user.role === 'admin' ? route('admin.produk') : route('user.katalog')}
                            method="GET"
                            className="hidden sm:block relative"
                        >
                            <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg className="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="search"
                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-64 pl-10 p-2.5 transition-shadow"
                                placeholder="Cari sesuatu..."
                            />
                        </form>
                    </div>

                    <div className="flex items-center gap-4 sm:gap-6">
                        {/* Profile Dropdown */}
                        <div className="relative">
                            <button
                                onClick={() => setProfileOpen(!profileOpen)}
                                className="flex items-center gap-3 focus:outline-none"
                            >
                                <div className="w-9 h-9 rounded-full bg-[#00E5FF]/20 text-[#0A2540] flex items-center justify-center font-bold border border-[#00E5FF]/50 overflow-hidden">
                                    <img
                                        src={`https://ui-avatars.com/api/?name=${encodeURIComponent(
                                            user.name
                                        )}&background=0A2540&color=fff`}
                                        alt="Avatar"
                                        className="w-full h-full object-cover"
                                    />
                                </div>
                                <div className="hidden sm:block text-left">
                                    <p className="text-sm font-semibold text-gray-800 leading-none">{user.name}</p>
                                    <p className="text-xs text-gray-500 mt-1 capitalize">{user.role}</p>
                                </div>
                                <svg className="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {/* Dropdown Menu */}
                            {profileOpen && (
                                <>
                                    <div className="fixed inset-0 z-40" onClick={() => setProfileOpen(false)} />
                                    <div className="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 ring-1 ring-black ring-opacity-5 z-50">
                                        <Link
                                            href={route('profile.edit')}
                                            className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#0A2540]"
                                            onClick={() => setProfileOpen(false)}
                                        >
                                            Profil Saya
                                        </Link>
                                        <div className="border-t border-gray-100 my-1"></div>
                                        <button
                                            onClick={handleLogout}
                                            className="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left"
                                        >
                                            Logout
                                        </button>
                                    </div>
                                </>
                            )}
                        </div>
                    </div>
                </header>

                {/* Main Content */}
                <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-8">
                    {children}
                </main>
            </div>
        </div>
    );
}
