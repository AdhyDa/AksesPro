import { useState } from 'react';
import { Head, Link } from '@inertiajs/react';
import UserDashboardLayout from '@/Layouts/UserDashboardLayout';

/**
 * User/Dashboard.jsx
 *
 * Props (dikirim dari UserDashboardController::index()):
 *  - user:          { name, points }
 *  - stats:         { active_subscriptions, total_transactions, points_collected, estimated_savings }
 *  - subscriptions: Array<{ name, package, end_date, status, product_slug, logo_path }>
 */
export default function Dashboard({ user, stats, subscriptions }) {
    const [credModal, setCredModal] = useState(null);
    const [showPass, setShowPass] = useState(false);

    const openCredModal = (sub) => {
        setCredModal(sub);
        setShowPass(false);
    };

    const copyToClipboard = (text, label) => {
        navigator.clipboard.writeText(text).then(() => alert(`${label} disalin!`));
    };

    /* ── Stat Cards data ──────────────────────────────────────────── */
    const statCards = [
        {
            label: 'Langganan Aktif',
            value: stats.active_subscriptions,
            sub: 'Aktif bulan ini',
            color: 'blue',
            icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />,
        },
        {
            label: 'Total Transaksi',
            value: stats.total_transactions,
            sub: '+2 dari bulan lalu',
            color: 'indigo',
            icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />,
        },
        {
            label: 'Poin Terkumpul',
            value: Number(stats.points_collected).toLocaleString('id-ID'),
            sub: '+50 dari Transaksi',
            color: 'cyan',
            icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />,
        },
        {
            label: 'Estimasi Penghematan',
            value: stats.estimated_savings,
            sub: 'Bulan ini',
            color: 'emerald',
            subGray: true,
            icon: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />,
        },
    ];

    const colorMap = {
        blue:    { bg: 'bg-blue-50',    text: 'text-blue-600' },
        indigo:  { bg: 'bg-indigo-50',  text: 'text-indigo-600' },
        cyan:    { bg: 'bg-cyan-50',    text: 'text-cyan-600' },
        emerald: { bg: 'bg-emerald-50', text: 'text-emerald-600' },
    };

    return (
        <UserDashboardLayout user={user} title="Dashboard">
            <Head title="Dashboard" />

            <div className="space-y-6">

                {/* ── Credential Modal ──────────────────────────────── */}
                {credModal && (
                    <div className="fixed inset-0 z-50 overflow-y-auto">
                        <div className="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:p-0">
                            {/* Backdrop */}
                            <div
                                className="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
                                onClick={() => setCredModal(null)}
                            />
                            {/* Modal Panel */}
                            <div className="relative inline-block w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all sm:my-8">
                                <div className="mb-5 flex items-center justify-between border-b border-gray-100 pb-4">
                                    <h3 className="text-lg font-bold text-gray-900">
                                        Kredensial {credModal.name}
                                    </h3>
                                    <button
                                        onClick={() => setCredModal(null)}
                                        className="rounded-lg p-1 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-500"
                                        aria-label="Tutup modal"
                                    >
                                        <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div className="space-y-4">
                                    {/* Email */}
                                    <div>
                                        <label className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            Email Akun
                                        </label>
                                        <div className="relative">
                                            <input
                                                type="text"
                                                readOnly
                                                value={credModal.email ?? '(belum tersedia)'}
                                                className="block w-full rounded-xl border border-gray-200 bg-gray-50 p-3 font-mono text-sm font-medium text-gray-900 focus:border-[#00E5FF] focus:ring-[#00E5FF]"
                                            />
                                            <button
                                                onClick={() => copyToClipboard(credModal.email ?? '', 'Email')}
                                                title="Salin Email"
                                                className="absolute right-2 top-2 rounded-lg border border-transparent p-1 text-gray-400 transition-colors hover:border-gray-200 hover:bg-white hover:text-[#0A2540]"
                                            >
                                                <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    {/* Password */}
                                    <div>
                                        <label className="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            Password
                                        </label>
                                        <div className="relative">
                                            <input
                                                type={showPass ? 'text' : 'password'}
                                                readOnly
                                                value={credModal.password ?? '(belum tersedia)'}
                                                className="block w-full rounded-xl border border-gray-200 bg-gray-50 p-3 font-mono text-sm font-medium text-gray-900 focus:border-[#00E5FF] focus:ring-[#00E5FF]"
                                            />
                                            <div className="absolute right-2 top-2 flex items-center gap-1">
                                                <button
                                                    onClick={() => setShowPass(!showPass)}
                                                    title="Lihat Password"
                                                    className="rounded-lg border border-transparent p-1 text-gray-400 transition-colors hover:border-gray-200 hover:bg-white hover:text-[#0A2540]"
                                                >
                                                    <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        {showPass ? (
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                        ) : (
                                                            <>
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </>
                                                        )}
                                                    </svg>
                                                </button>
                                                <button
                                                    onClick={() => copyToClipboard(credModal.password ?? '', 'Password')}
                                                    title="Salin Password"
                                                    className="rounded-lg border border-transparent p-1 text-gray-400 transition-colors hover:border-gray-200 hover:bg-white hover:text-[#0A2540]"
                                                >
                                                    <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Info */}
                                <div className="mt-6 flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4">
                                    <svg className="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p className="text-xs leading-relaxed text-blue-800">
                                        Gunakan kredensial ini untuk login ke aplikasi{' '}
                                        <strong>{credModal.name}</strong>. Dilarang mengganti password atau membagikan akun ini ke orang lain.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* ── Greeting Banner ───────────────────────────────── */}
                <div className="relative overflow-hidden rounded-2xl border border-[#0A2540]/50 bg-[#0A2540] p-6 shadow-lg sm:p-10">
                    <div className="absolute -mr-20 -mt-20 right-0 top-0 h-64 w-64 rounded-full bg-[#00E5FF]/10 blur-3xl" />
                    <div className="absolute bottom-0 right-40 h-40 w-40 rounded-full bg-blue-500/10 blur-2xl" />

                    <div className="relative z-10 flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                        <div>
                            <h1 className="mb-2 text-2xl font-bold text-white sm:text-3xl">
                                Selamat datang kembali, {user.name}! 👋
                            </h1>
                            <p className="max-w-xl text-sm text-blue-100 sm:text-base">
                                Kelola langganan digital premium Anda, nikmati akses tanpa batas, dan kumpulkan poin untuk ditukarkan dengan potongan harga menarik.
                            </p>
                        </div>
                        <div className="min-w-[200px] flex items-center gap-4 rounded-xl border border-white/20 bg-white/10 p-4 shadow-inner backdrop-blur-md">
                            <div className="flex h-12 w-12 items-center justify-center rounded-full bg-[#00E5FF]/20">
                                <svg className="h-6 w-6 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <div>
                                <p className="text-xs font-semibold uppercase tracking-wider text-white/70">Total Poin Anda</p>
                                <p className="text-2xl font-bold text-white">
                                    {Number(user.points).toLocaleString('id-ID')}
                                    <span className="ml-2 text-sm font-medium text-[#00E5FF]">Pts</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* ── 4 Stat Cards ──────────────────────────────────── */}
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    {statCards.map((card) => {
                        const c = colorMap[card.color];
                        return (
                            <div
                                key={card.label}
                                className="flex items-start gap-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition-shadow hover:shadow-md"
                            >
                                <div className={`flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg ${c.bg} ${c.text}`}>
                                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {card.icon}
                                    </svg>
                                </div>
                                <div>
                                    <p className="mb-1 text-sm font-medium text-gray-500">{card.label}</p>
                                    <h3 className="text-2xl font-bold text-gray-900">{card.value}</h3>
                                    <p className={`mt-1 flex items-center gap-1 text-xs font-medium ${card.subGray ? 'text-gray-400' : 'text-green-500'}`}>
                                        {!card.subGray && (
                                            <svg className="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                        )}
                                        {card.sub}
                                    </p>
                                </div>
                            </div>
                        );
                    })}
                </div>

                {/* ── Subscription Table ────────────────────────────── */}
                <div className="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                    <div className="flex flex-col items-start justify-between gap-4 border-b border-gray-100 p-6 sm:flex-row sm:items-center">
                        <h2 className="text-lg font-bold text-gray-900">Langganan Aktif Saya</h2>
                        {/* ✅ Navigasi internal pakai <Link> Inertia */}
                        <Link
                            href={route('user.langganan')}
                            className="rounded-lg bg-[#00E5FF]/10 px-4 py-2 text-sm font-semibold text-[#00b8cc] transition-colors hover:bg-[#00E5FF]/20"
                        >
                            Lihat Semua
                        </Link>
                    </div>

                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-sm text-gray-500">
                            <thead className="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th className="px-6 py-4">Nama Aplikasi</th>
                                    <th className="px-6 py-4">Paket</th>
                                    <th className="px-6 py-4">Tanggal Berakhir</th>
                                    <th className="px-6 py-4">Status</th>
                                    <th className="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {subscriptions.length === 0 ? (
                                    <tr>
                                        <td colSpan={5} className="px-6 py-10 text-center text-gray-400">
                                            Belum ada langganan aktif.{' '}
                                            <Link href={route('user.katalog')} className="text-[#00E5FF] hover:underline">
                                                Jelajahi Katalog
                                            </Link>
                                        </td>
                                    </tr>
                                ) : (
                                    subscriptions.map((sub, idx) => (
                                        <tr key={idx} className="border-b bg-white transition-colors hover:bg-gray-50">
                                            {/* Nama Aplikasi */}
                                            <td className="flex items-center gap-3 px-6 py-4 font-semibold text-gray-900">
                                                <div className="flex h-8 w-8 items-center justify-center overflow-hidden rounded bg-gray-100">
                                                    <img
                                                        src={`/${sub.logo_path}`}
                                                        alt={sub.name}
                                                        className="h-full w-full rounded-lg object-contain"
                                                    />
                                                </div>
                                                {sub.name}
                                            </td>

                                            {/* Paket */}
                                            <td className="px-6 py-4">
                                                <span className="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-600">
                                                    {sub.package}
                                                </span>
                                            </td>

                                            {/* Tanggal Berakhir */}
                                            <td className="px-6 py-4">{sub.end_date}</td>

                                            {/* Status */}
                                            <td className="px-6 py-4">
                                                {sub.status === 'Aktif' ? (
                                                    <span className="flex w-max items-center gap-1 rounded-md bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-600">
                                                        <div className="h-1.5 w-1.5 rounded-full bg-green-500" />
                                                        Aktif
                                                    </span>
                                                ) : (
                                                    <span className="flex w-max items-center gap-1 rounded-md bg-orange-50 px-2.5 py-1 text-xs font-semibold text-orange-600">
                                                        <div className="h-1.5 w-1.5 rounded-full bg-orange-500" />
                                                        {sub.status}
                                                    </span>
                                                )}
                                            </td>

                                            {/* Aksi */}
                                            <td className="px-6 py-4 text-center">
                                                <div className="flex items-center justify-center gap-2">
                                                    {/* Lihat Kredensial */}
                                                    <button
                                                        onClick={() => openCredModal(sub)}
                                                        title="Detail Kredensial"
                                                        className="rounded-lg p-2 text-gray-400 transition-colors hover:bg-blue-50 hover:text-blue-600"
                                                    >
                                                        <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>

                                                    {/* ✅ Perpanjang — navigasi internal pakai <Link> */}
                                                    <Link
                                                        href={route('user.katalog.detail', sub.product_slug)}
                                                        title="Perpanjang"
                                                        className="inline-block rounded-lg p-2 text-gray-400 transition-colors hover:bg-[#00E5FF]/10 hover:text-[#00E5FF]"
                                                    >
                                                        <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                    </Link>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </UserDashboardLayout>
    );
}
