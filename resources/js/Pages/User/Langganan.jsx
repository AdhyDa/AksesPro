import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

/**
 * User/Langganan.jsx
 *
 * Props:
 *  - user:          { name, points }
 *  - subscriptions: Array<{ name, package, start_date, end_date, status, auto_renew, product_slug, logo_path }>
 */
export default function Langganan({ user, subscriptions }) {
    const [credModal, setCredModal] = useState(null);
    const [showPass, setShowPass] = useState(false);

    const openCredModal = (sub, index) => {
        // Generate fallback mock credentials if not returned from backend, matching the Blade template logic
        const mockEmail = sub.email || `user${index + 1}@aksespro.com`;
        const mockPassword = sub.password || `AksesPro${new Date().getFullYear()}${index + 1}`;
        setCredModal({
            name: sub.name,
            email: mockEmail,
            password: mockPassword
        });
        setShowPass(false);
    };

    const copyToClipboard = (text, label) => {
        navigator.clipboard.writeText(text).then(() => alert(`${label} disalin!`));
    };

    return (
        <UserDashboardLayout user={user} title="Langganan Aktif">
            <Head title="Langganan Aktif — AksesPro" />

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
                                                value={credModal.email}
                                                className="block w-full rounded-xl border border-gray-200 bg-gray-50 p-3 font-mono text-sm font-medium text-gray-900 focus:border-[#00E5FF] focus:ring-[#00E5FF]"
                                            />
                                            <button
                                                onClick={() => copyToClipboard(credModal.email, 'Email')}
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
                                                value={credModal.password}
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
                                                    onClick={() => copyToClipboard(credModal.password, 'Password')}
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

                {/* ── Header Section ─────────────────────────────────── */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Langganan Aktif</h1>
                        <p className="text-sm text-gray-500 mt-1">
                            Kelola dan pantau semua layanan langganan Anda yang sedang berjalan.
                        </p>
                    </div>

                    <Link
                        href={route('user.katalog')}
                        className="px-5 py-2.5 bg-[#00E5FF] hover:bg-[#00c9e0] text-[#0A2540] font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2"
                    >
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Langganan
                    </Link>
                </div>

                {/* ── Cards List Grid ────────────────────────────────── */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {subscriptions.length === 0 ? (
                        <div className="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-12 flex flex-col items-center justify-center text-center">
                            <div className="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg className="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 mb-2">Belum ada langganan aktif</h3>
                            <p className="text-gray-500 mb-6 max-w-sm">
                                Anda belum memiliki paket langganan yang sedang berjalan. Mulai berlangganan sekarang untuk menikmati akses premium.
                            </p>
                            <Link
                                href={route('user.katalog')}
                                className="px-6 py-3 bg-[#00E5FF] hover:bg-[#00c9e0] text-[#0A2540] font-bold rounded-xl transition-colors shadow-sm"
                            >
                                Jelajahi Katalog
                            </Link>
                        </div>
                    ) : (
                        subscriptions.map((sub, idx) => {
                            // Calculate elapsed percentage
                            const start = new Date(sub.start_date).getTime();
                            const end = new Date(sub.end_date).getTime();
                            const now = Date.now();

                            let percent = 0;
                            if (now < start) {
                                percent = 0;
                            } else if (now > end) {
                                percent = 100;
                            } else {
                                percent = Math.round(((now - start) / (end - start)) * 100);
                            }

                            let daysLeft = Math.round((end - now) / (1000 * 60 * 60 * 24));
                            if (daysLeft < 0) daysLeft = 0;

                            const isWarning = daysLeft <= 7;

                            // Formatted dates
                            const startStr = new Date(sub.start_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                            const endStr = new Date(sub.end_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

                            return (
                                <div key={idx} className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                                    {/* Card Header */}
                                    <div className="flex items-start justify-between mb-6">
                                        <div className="flex items-center gap-4">
                                            <div className="w-14 h-14 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center overflow-hidden p-1">
                                                <img
                                                    src={sub.logo_path ? `/${sub.logo_path.replace(/^\//, '')}` : '/image/canva.jpg'}
                                                    alt={sub.name}
                                                    className="w-full h-full object-contain rounded-lg"
                                                    onError={(e) => { e.target.src = '/image/canva.jpg'; }}
                                                />
                                            </div>
                                            <div>
                                                <h3 className="text-lg font-bold text-gray-900">{sub.name}</h3>
                                                <p className="text-sm text-gray-500">Paket: {sub.package}</p>
                                            </div>
                                        </div>

                                        {sub.status === 'Aktif' ? (
                                            <span className="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-bold border border-green-100 flex items-center gap-1">
                                                <div className="w-1.5 h-1.5 rounded-full bg-green-500" />
                                                Aktif
                                            </span>
                                        ) : (
                                            <span className="px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold border border-orange-100 flex items-center gap-1">
                                                <div className="w-1.5 h-1.5 rounded-full bg-orange-500" />
                                                {sub.status}
                                            </span>
                                        )}
                                    </div>

                                    {/* Progress / Timeline */}
                                    <div className="mb-6">
                                        <div className="flex justify-between text-xs font-semibold text-gray-500 mb-2">
                                            <span>Aktif sejak: {startStr}</span>
                                            <span className={isWarning ? 'text-orange-500' : 'text-[#00b8cc]'}>
                                                {daysLeft} hari tersisa
                                            </span>
                                        </div>
                                        <div className="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden border border-gray-200/50">
                                            <div
                                                className={`h-2.5 rounded-full ${isWarning ? 'bg-orange-500' : 'bg-[#0A2540]'} transition-all duration-500`}
                                                style={{ width: `${percent}%` }}
                                            />
                                        </div>
                                        <div className="flex justify-end text-xs font-semibold text-gray-400 mt-2">
                                            <span>Berakhir: {endStr}</span>
                                        </div>
                                    </div>

                                    {/* Footer / Actions */}
                                    <div className="flex items-center justify-between pt-4 border-t border-gray-50">
                                        <div className="flex items-center gap-2">
                                            <label className="relative inline-flex items-center cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    defaultChecked={sub.auto_renew}
                                                    className="sr-only peer"
                                                />
                                                <div className="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#00E5FF]" />
                                                <span className="ml-3 text-xs font-medium text-gray-600">Auto-Renew</span>
                                            </label>
                                        </div>

                                        <div className="flex gap-2">
                                            <button
                                                onClick={() => openCredModal(sub, idx)}
                                                className="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-xs font-bold transition-colors"
                                            >
                                                Credential
                                            </button>
                                            <Link
                                                href={route('user.katalog.detail', sub.product_slug)}
                                                className="px-4 py-2 bg-[#0A2540] text-white hover:bg-[#0d2e59] rounded-xl text-xs font-bold transition-colors shadow-sm text-center"
                                            >
                                                Perpanjang
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            );
                        })
                    )}
                </div>

            </div>
        </UserDashboardLayout>
    );
}
