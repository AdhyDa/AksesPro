import { useState } from 'react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

/**
 * Auth/Login.jsx — Halaman Login AksesPro
 *
 * Props dari AuthenticatedSessionController::create():
 *   - status:          string|null  — pesan session (misal: "Link reset dikirim")
 *   - canResetPassword: boolean
 *
 * Flash dari HandleInertiaRequests middleware:
 *   - flash.error: string|null — pesan error dari GoogleAuthController
 */
export default function Login({ status, canResetPassword }) {
    const { flash } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        email:    '',
        password: '',
        remember: false,
    });

    const [isStudentMode, setIsStudentMode] = useState(false);

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <div className="min-h-screen flex bg-[#0A2540]">
            {/* ── Left Panel — Branding ──────────────────────────── */}
            <div className="hidden lg:flex lg:w-1/2 flex-col items-center justify-center px-16 relative overflow-hidden">
                {/* Decorative blobs */}
                <div className="absolute top-0 left-0 w-96 h-96 rounded-full bg-[#00E5FF]/10 blur-3xl -translate-x-1/2 -translate-y-1/2" />
                <div className="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-blue-500/10 blur-3xl translate-x-1/2 translate-y-1/2" />

                <div className="relative z-10 text-center">
                    <img src="/Logo.png" alt="AksesPro Logo" className="h-20 w-auto mx-auto mb-6" />
                    <h1 className="text-4xl font-black text-white mb-4">
                        Akses<span className="text-[#FFD700]">Pro</span>
                    </h1>
                    <p className="text-blue-100/70 text-lg max-w-sm">
                        Platform patungan langganan digital yang aman, legal, dan bergaransi untuk semua.
                    </p>

                    <div className="mt-10 space-y-3 text-left">
                        {['Netflix, Spotify, Canva & 50+ app premium', 'Harga mulai Rp 10.000/bulan', 'Garansi aktif selama masa berlangganan'].map((item) => (
                            <div key={item} className="flex items-center gap-3 text-blue-100/80 text-sm">
                                <div className="w-1.5 h-1.5 rounded-full bg-[#00E5FF] flex-shrink-0" />
                                {item}
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* ── Right Panel — Form ─────────────────────────────── */}
            <div className="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white rounded-l-none lg:rounded-l-3xl">
                <div className="w-full max-w-md">
                    <Head title="Masuk — AksesPro" />

                    {/* Logo mobile */}
                    <div className="flex items-center gap-3 mb-8 lg:hidden">
                        <img src="/Logo.png" alt="AksesPro" className="h-10 w-auto" />
                        <span className="text-2xl font-black text-[#0A2540]">
                            Akses<span className="text-[#FFD700]">Pro</span>
                        </span>
                    </div>

                    <h2 className="text-2xl font-bold text-[#0A2540] mb-1">Selamat Datang!</h2>
                    <p className="text-gray-500 text-sm mb-8">Masuk untuk mengelola langganan digital Anda.</p>

                    {/* Flash messages dari middleware share */}
                    {flash?.error && (
                        <div className="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {flash.error}
                        </div>
                    )}
                    {status && (
                        <div className="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                            {status}
                        </div>
                    )}

                    {/* ── TASK 3: Google SSO Button ─────────────────────
                     * ⚠️ KRITIKAL: Gunakan <a href="..."> HTML biasa — BUKAN <Link> Inertia!
                     * Alasan: <Link> Inertia membuat XHR request. Midtrans & Google OAuth
                     * membutuhkan full-page redirect (302) yang tidak bisa ditangkap XHR.
                     * window.location.href juga merupakan alternatif yang valid.
                     */}
                    <a
                        href="/auth/google/redirect"
                        id="google-sso-btn"
                        className="flex items-center justify-center w-full gap-3 rounded-xl border-2 border-gray-200 bg-white py-3 px-4 text-sm font-semibold text-gray-700 transition-all hover:border-gray-300 hover:shadow-md mb-6"
                    >
                        <svg className="h-5 w-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                        Lanjutkan dengan Google
                    </a>

                    {/* Divider */}
                    <div className="relative mb-6">
                        <div className="absolute inset-0 flex items-center">
                            <div className="w-full border-t border-gray-200" />
                        </div>
                        <div className="relative flex justify-center text-xs text-gray-400">
                            <span className="bg-white px-3">atau masuk dengan email</span>
                        </div>
                    </div>

                    {/* Student Mode Toggle */}
                    <div className="flex items-center justify-between mb-5">
                        <label className="text-sm font-medium text-gray-700">Mode Mahasiswa</label>
                        <button
                            type="button"
                            onClick={() => setIsStudentMode(!isStudentMode)}
                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors ${isStudentMode ? 'bg-[#00E5FF]' : 'bg-gray-200'}`}
                        >
                            <span className={`inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform ${isStudentMode ? 'translate-x-6' : 'translate-x-1'}`} />
                        </button>
                    </div>

                    {isStudentMode && (
                        <p className="mb-4 text-xs text-blue-600 bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                            Gunakan email instansi (.ac.id) untuk mendapatkan +100 bonus poin!
                        </p>
                    )}

                    <form onSubmit={submit} className="space-y-4">
                        {/* Email */}
                        <div>
                            <InputLabel htmlFor="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full rounded-xl border-gray-300 focus:border-[#0A2540] focus:ring-[#0A2540] px-4 py-3"
                                autoComplete="username"
                                isFocused={true}
                                placeholder={isStudentMode ? 'nama@student.um.ac.id' : 'Masukkan Email'}
                                onChange={(e) => setData('email', e.target.value)}
                            />
                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        {/* Password */}
                        <div>
                            <InputLabel htmlFor="password" value="Password" />
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full rounded-xl border-gray-300 focus:border-[#0A2540] focus:ring-[#0A2540] px-4 py-3"
                                autoComplete="current-password"
                                placeholder="Password"
                                onChange={(e) => setData('password', e.target.value)}
                            />
                            <InputError message={errors.password} className="mt-2" />
                        </div>

                        {/* Remember + Forgot */}
                        <div className="flex items-center justify-between">
                            <label className="flex items-center gap-2">
                                <Checkbox
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                />
                                <span className="text-sm text-gray-600">Ingat saya</span>
                            </label>

                            {canResetPassword && (
                                <Link
                                    href={route('password.request')}
                                    className="text-sm text-[#0A2540] hover:underline font-medium"
                                >
                                    Lupa sandi?
                                </Link>
                            )}
                        </div>

                        {/* Submit */}
                        <button
                            type="submit"
                            id="login-submit-btn"
                            disabled={processing}
                            className="w-full rounded-xl bg-[#0A2540] py-3 px-4 text-sm font-bold text-white transition-all hover:bg-[#112233] disabled:opacity-60"
                        >
                            {processing ? 'Memproses...' : isStudentMode ? 'Lanjutkan dengan Akun Mahasiswa' : 'Lanjutkan dengan Email'}
                        </button>
                    </form>

                    <p className="mt-6 text-center text-sm text-gray-600">
                        Belum punya akun?{' '}
                        <Link href={route('register')} className="font-semibold text-[#0A2540] hover:underline">
                            Daftar Sekarang
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    );
}
