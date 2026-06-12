import { useState } from 'react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

export default function Register() {
    const { flash } = usePage().props;

    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const [isStudentMode, setIsStudentMode] = useState(false);

    const submit = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
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
                    <img src="/image/mockup.png" alt="AksesPro Preview" className="w-full max-w-md mx-auto drop-shadow-2xl mb-8 transform transition hover:scale-105 duration-500" onError={(e) => { e.target.style.display = 'none'; }} />
                    <h1 className="text-4xl font-black text-white mb-4 leading-tight">
                        Akses Premium<br />Harga Mahasiswa
                    </h1>
                    <p className="text-blue-100/70 text-lg max-w-sm mx-auto">
                        One access to all your professional tools.
                    </p>
                </div>
            </div>

            {/* ── Right Panel — Form ─────────────────────────────── */}
            <div className="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-white rounded-l-none lg:rounded-l-3xl">
                <div className="w-full max-w-md">
                    <Head title="Daftar — AksesPro" />

                    {/* Logo mobile */}
                    <div className="flex items-center justify-center gap-3 mb-8 lg:hidden">
                        <img src="/Logo.png" alt="AksesPro" className="h-10 w-auto" />
                        <span className="text-2xl font-black text-[#0A2540]">
                            Akses<span className="text-[#FFD700]">Pro</span>
                        </span>
                    </div>

                    <div className="text-center mb-8">
                        <div className="hidden lg:flex items-center justify-center gap-2 mb-4">
                            <img src="/Logo.png" alt="AksesPro Logo" className="h-14" onError={(e) => { e.target.style.display = 'none'; }} />
                            <span className="text-3xl font-bold text-gray-900 flex items-center">
                                Akses<span className="text-[#FFD700]">Pro</span>
                            </span>
                        </div>
                        <h2 className="text-3xl font-bold text-gray-900 mb-2">Selamat Datang di AksesPro!</h2>
                        <p className="text-gray-500">Masuk atau daftar untuk mulai berhemat hari ini.</p>
                    </div>

                    {/* Flash messages dari middleware share */}
                    {flash?.error && (
                        <div className="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            {flash.error}
                        </div>
                    )}

                    {/* SSO Buttons */}
                    <div className="space-y-4 mb-8">
                        {/* Google SSO */}
                        <a
                            href="/auth/google/redirect"
                            id="btn-google-sso"
                            className="flex items-center justify-center w-full gap-3 rounded-full border border-gray-300 bg-white py-3 px-4 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-50 hover:shadow-sm"
                        >
                            <svg className="h-5 w-5" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                            </svg>
                            Continue with Google
                        </a>

                        {/* Student Account */}
                        <button
                            type="button"
                            id="btn-student-toggle"
                            onClick={() => setIsStudentMode(!isStudentMode)}
                            className={`w-full flex flex-col items-center justify-center gap-1 border rounded-full py-2 px-4 font-semibold transition shadow-sm ${isStudentMode ? 'border-blue-500 bg-blue-50 ring-2 ring-blue-200 text-blue-600' : 'border-gray-300 bg-white hover:bg-gray-50 text-gray-700'}`}
                        >
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className={`w-5 h-5 transition-colors ${isStudentMode ? 'text-blue-600' : 'text-gray-700'}`}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                </svg>
                                <span>Continue with Student Account</span>
                            </div>
                            <span className={`text-[10px] ${isStudentMode ? 'text-blue-500' : 'text-gray-400'}`}>Dapatkan bonus +100 poin</span>
                        </button>
                    </div>

                    {/* Divider */}
                    <div className="relative flex items-center py-5 mb-4">
                        <div className="flex-grow border-t border-gray-200"></div>
                        <span className="flex-shrink-0 mx-4 text-gray-400 text-sm">atau</span>
                        <div className="flex-grow border-t border-gray-200"></div>
                    </div>

                    <form onSubmit={submit} className="space-y-4">
                        {isStudentMode && (
                            <div className="text-center mb-4">
                                <p className="text-sm text-gray-600">Masukkan Email Mahasiswa Anda!</p>
                            </div>
                        )}

                        {/* Name */}
                        <div>
                            <TextInput
                                id="name"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                                autoComplete="name"
                                placeholder="Nama Lengkap"
                                isFocused={true}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                            />
                            <InputError message={errors.name} className="mt-2" />
                        </div>

                        {/* Email */}
                        <div>
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                                autoComplete="username"
                                placeholder={isStudentMode ? 'nama@student.um.ac.id' : 'Masukkan Email'}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                            />
                            <InputError message={errors.email} className="mt-2" />
                        </div>

                        {/* Password */}
                        <div>
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                                autoComplete="new-password"
                                placeholder="Password"
                                onChange={(e) => setData('password', e.target.value)}
                                required
                            />
                            <InputError message={errors.password} className="mt-2" />
                        </div>

                        {/* Confirm Password */}
                        <div>
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                className="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#1A3147] focus:ring-[#1A3147] px-4 py-3"
                                autoComplete="new-password"
                                placeholder="Konfirmasi Password"
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                required
                            />
                            <InputError message={errors.password_confirmation} className="mt-2" />
                        </div>

                        {/* Submit Button */}
                        <div className="pt-2">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full bg-[#1A3147] hover:bg-[#112233] text-white font-semibold rounded-lg py-3 px-4 transition duration-200 disabled:opacity-60"
                            >
                                {processing ? 'Memproses...' : isStudentMode ? 'Lanjutkan dengan Akun Mahasiswa' : 'Daftar dengan Email'}
                            </button>
                        </div>

                        <div className="text-center mt-4">
                            {isStudentMode && (
                                <p className="text-xs text-gray-500 mb-4">
                                    Gunakan email instansi (.ac.id) untuk mendapatkan benefit poin tambahan.
                                </p>
                            )}
                            <p className="text-sm text-gray-600">
                                Sudah punya akun?{' '}
                                <Link href={route('login')} className="font-medium text-[#1A3147] hover:underline">
                                    Masuk
                                </Link>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
