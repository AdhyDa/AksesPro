import React, { useState } from 'react';
import { Head, usePage, useForm } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';

/**
 * Admin/Pengaturan.jsx
 *
 * Props:
 *   - admin:    { name }
 *   - settings: { system_name, system_description, logo, midtrans_environment, midtrans_merchant_id, midtrans_client_key, midtrans_server_key, mail_mailer, mail_host, mail_port, mail_encryption, mail_username, mail_password }
 */
export default function Pengaturan({ admin, settings }) {
    const { flash } = usePage().props;

    const [activeTab, setActiveTab] = useState(
        typeof window !== 'undefined' ? (localStorage.getItem('setting_tab') || 'umum') : 'umum'
    );
    const [showToast, setShowToast] = useState(false);
    const [toastMessage, setToastMessage] = useState('');
    const [logoPreview, setLogoPreview] = useState(null);

    const handleTabChange = (tab) => {
        setActiveTab(tab);
        if (typeof window !== 'undefined') {
            localStorage.setItem('setting_tab', tab);
        }
    };

    // Form 1: Pengaturan Umum
    const { data: umumData, setData: setUmumData, post: postUmum, errors: umumErrors, processing: umumProcessing } = useForm({
        system_name: settings.system_name || 'AksesPro',
        system_description: settings.system_description || '',
        logo: null,
    });

    // Form 2: Payment Gateway
    const { data: payData, setData: setPayData, post: postPay, errors: payErrors, processing: payProcessing } = useForm({
        midtrans_environment: settings.midtrans_environment || 'sandbox',
        midtrans_merchant_id: settings.midtrans_merchant_id || '',
        midtrans_client_key: settings.midtrans_client_key || '',
        midtrans_server_key: settings.midtrans_server_key || '',
    });

    // Form 3: SMTP Email
    const { data: emailData, setData: setEmailData, post: postEmail, errors: emailErrors, processing: emailProcessing } = useForm({
        mail_mailer: settings.mail_mailer || 'smtp',
        mail_host: settings.mail_host || '',
        mail_port: settings.mail_port || '',
        mail_encryption: settings.mail_encryption || 'ssl',
        mail_username: settings.mail_username || '',
        mail_password: settings.mail_password || '',
    });

    const submitUmum = (e) => {
        e.preventDefault();
        postUmum('/admin/pengaturan/umum', {
            forceFormData: true,
            onSuccess: () => {
                setToastMessage('Pengaturan umum berhasil disimpan.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    const submitPay = (e) => {
        e.preventDefault();
        postPay('/admin/pengaturan/pembayaran', {
            onSuccess: () => {
                setToastMessage('Kredensial payment gateway berhasil disimpan.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    const submitEmail = (e) => {
        e.preventDefault();
        postEmail('/admin/pengaturan/email', {
            onSuccess: () => {
                setToastMessage('Konfigurasi SMTP email berhasil disimpan.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    const handleLogoChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setUmumData('logo', file);
            setLogoPreview(URL.createObjectURL(file));
        }
    };

    return (
        <DashboardLayout admin={admin} title="Pengaturan Sistem">
            <Head title="Pengaturan Sistem" />

            <div className="space-y-6">
                {/* Toast Notification */}
                {showToast && (
                    <div className="fixed bottom-4 right-4 z-50 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-300">
                        <svg className="w-5 h-5 text-[#00E5FF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span className="text-sm font-medium">{toastMessage}</span>
                    </div>
                )}

                {/* Header Section */}
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
                    <p className="text-sm text-gray-500 mt-1">Konfigurasi umum, pembayaran, dan preferensi aplikasi.</p>
                </div>

                {/* Flash Success Message */}
                {flash?.success && (
                    <div className="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
                        <div className="flex">
                            <div className="flex-shrink-0">
                                <svg className="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <div className="ml-3">
                                <p className="text-sm font-semibold text-emerald-800">{flash.success}</p>
                            </div>
                        </div>
                    </div>
                )}

                {/* System Settings Main Card */}
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
                    {/* Tabs Navigation */}
                    <div className="w-full md:w-64 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-100 p-4 sm:p-6 flex-shrink-0">
                        <nav className="flex md:flex-col gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
                            <button
                                onClick={() => handleTabChange('umum')}
                                className={`flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full ${
                                    activeTab === 'umum'
                                        ? 'bg-white text-[#0A2540] shadow-sm border-gray-200'
                                        : 'text-gray-500 hover:bg-gray-100 border-transparent bg-transparent'
                                }`}
                            >
                                <svg className="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Umum
                            </button>
                            <button
                                onClick={() => handleTabChange('pembayaran')}
                                className={`flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full ${
                                    activeTab === 'pembayaran'
                                        ? 'bg-white text-[#0A2540] shadow-sm border-gray-200'
                                        : 'text-gray-500 hover:bg-gray-100 border-transparent bg-transparent'
                                }`}
                            >
                                <svg className="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Payment Gateway
                            </button>
                            <button
                                onClick={() => handleTabChange('email')}
                                className={`flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all border whitespace-nowrap text-left w-full ${
                                    activeTab === 'email'
                                        ? 'bg-white text-[#0A2540] shadow-sm border-gray-200'
                                        : 'text-gray-500 hover:bg-gray-100 border-transparent bg-transparent'
                                }`}
                            >
                                <svg className="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                SMTP Email
                            </button>
                        </nav>
                    </div>

                    {/* Tab Contents */}
                    <div className="flex-1 p-6 sm:p-8">
                        {/* Tab: Umum */}
                        {activeTab === 'umum' && (
                            <div className="space-y-6">
                                <h2 className="text-xl font-bold text-gray-900 mb-6">Pengaturan Umum</h2>

                                <form onSubmit={submitUmum} className="space-y-6 max-w-2xl" encType="multipart/form-data">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                                        <input
                                            type="text"
                                            value={umumData.system_name}
                                            onChange={(e) => setUmumData('system_name', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                            required
                                        />
                                        {umumErrors.system_name && <div className="text-red-500 text-xs mt-1">{umumErrors.system_name}</div>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                                        <textarea
                                            value={umumData.system_description}
                                            onChange={(e) => setUmumData('system_description', e.target.value)}
                                            rows="3"
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                            required
                                        ></textarea>
                                        {umumErrors.system_description && <div className="text-red-500 text-xs mt-1">{umumErrors.system_description}</div>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>
                                        <div className="flex items-center gap-4">
                                            <div className="w-16 h-16 bg-[#0A2540] rounded-xl flex items-center justify-center p-2 border border-gray-200 overflow-hidden">
                                                <img
                                                    src={logoPreview || settings.logo}
                                                    alt="System Logo"
                                                    className="w-full h-full object-contain"
                                                />
                                            </div>
                                            <input
                                                type="file"
                                                id="logo-input"
                                                className="hidden"
                                                onChange={handleLogoChange}
                                                accept="image/*"
                                            />
                                            <button
                                                type="button"
                                                onClick={() => document.getElementById('logo-input').click()}
                                                className="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors"
                                            >
                                                Pilih Logo
                                            </button>
                                            {umumData.logo && (
                                                <span className="text-xs text-gray-500 font-mono">
                                                    {umumData.logo.name}
                                                </span>
                                            )}
                                        </div>
                                        {umumErrors.logo && <div className="text-red-500 text-xs mt-1">{umumErrors.logo}</div>}
                                    </div>
                                    <div className="pt-6 border-t border-gray-100">
                                        <button
                                            type="submit"
                                            disabled={umumProcessing}
                                            className="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto disabled:opacity-50"
                                        >
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        )}

                        {/* Tab: Payment Gateway */}
                        {activeTab === 'pembayaran' && (
                            <div className="space-y-6">
                                <h2 className="text-xl font-bold text-gray-900 mb-6">Konfigurasi Payment Gateway</h2>

                                <div className="bg-[#00E5FF]/10 border border-[#00E5FF]/30 rounded-xl p-4 mb-6 flex gap-3">
                                    <svg className="w-6 h-6 text-[#00b8cc] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p className="text-sm text-[#0A2540]">
                                        Saat ini menggunakan Midtrans sebagai <em>payment gateway</em> utama. Pastikan Environment di set ke <strong>Sandbox</strong> saat pengembangan.
                                    </p>
                                </div>

                                <form onSubmit={submitPay} className="space-y-6 max-w-2xl">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Midtrans Environment</label>
                                        <select
                                            value={payData.midtrans_environment}
                                            onChange={(e) => setPayData('midtrans_environment', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                            required
                                        >
                                            <option value="sandbox">Sandbox (Testing)</option>
                                            <option value="production">Production (Live)</option>
                                        </select>
                                        {payErrors.midtrans_environment && <div className="text-red-500 text-xs mt-1">{payErrors.midtrans_environment}</div>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Merchant ID</label>
                                        <input
                                            type="text"
                                            value={payData.midtrans_merchant_id}
                                            onChange={(e) => setPayData('midtrans_merchant_id', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono"
                                            required
                                        />
                                        {payErrors.midtrans_merchant_id && <div className="text-red-500 text-xs mt-1">{payErrors.midtrans_merchant_id}</div>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Client Key</label>
                                        <input
                                            type="text"
                                            value={payData.midtrans_client_key}
                                            onChange={(e) => setPayData('midtrans_client_key', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono"
                                            required
                                        />
                                        {payErrors.midtrans_client_key && <div className="text-red-500 text-xs mt-1">{payErrors.midtrans_client_key}</div>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Server Key</label>
                                        <input
                                            type="text"
                                            value={payData.midtrans_server_key}
                                            onChange={(e) => setPayData('midtrans_server_key', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3 font-mono"
                                            required
                                        />
                                        {payErrors.midtrans_server_key && <div className="text-red-500 text-xs mt-1">{payErrors.midtrans_server_key}</div>}
                                    </div>
                                    <div className="pt-6 border-t border-gray-100">
                                        <button
                                            type="submit"
                                            disabled={payProcessing}
                                            className="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto disabled:opacity-50"
                                        >
                                            Simpan Kredensial
                                        </button>
                                    </div>
                                </form>
                            </div>
                        )}

                        {/* Tab: Email */}
                        {activeTab === 'email' && (
                            <div className="space-y-6">
                                <h2 className="text-xl font-bold text-gray-900 mb-6">Konfigurasi SMTP Email</h2>

                                <form onSubmit={submitEmail} className="space-y-6 max-w-2xl">
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">Mail Mailer</label>
                                            <input
                                                type="text"
                                                value={emailData.mail_mailer}
                                                onChange={(e) => setEmailData('mail_mailer', e.target.value)}
                                                className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                                required
                                            />
                                            {emailErrors.mail_mailer && <div className="text-red-500 text-xs mt-1">{emailErrors.mail_mailer}</div>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">Mail Host</label>
                                            <input
                                                type="text"
                                                value={emailData.mail_host}
                                                onChange={(e) => setEmailData('mail_host', e.target.value)}
                                                className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                                required
                                            />
                                            {emailErrors.mail_host && <div className="text-red-500 text-xs mt-1">{emailErrors.mail_host}</div>}
                                        </div>
                                    </div>
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">Mail Port</label>
                                            <input
                                                type="text"
                                                value={emailData.mail_port}
                                                onChange={(e) => setEmailData('mail_port', e.target.value)}
                                                className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                                required
                                            />
                                            {emailErrors.mail_port && <div className="text-red-500 text-xs mt-1">{emailErrors.mail_port}</div>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 mb-2">Mail Encryption</label>
                                            <select
                                                value={emailData.mail_encryption}
                                                onChange={(e) => setEmailData('mail_encryption', e.target.value)}
                                                className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                                required
                                            >
                                                <option value="tls">TLS</option>
                                                <option value="ssl">SSL</option>
                                            </select>
                                            {emailErrors.mail_encryption && <div className="text-red-500 text-xs mt-1">{emailErrors.mail_encryption}</div>}
                                        </div>
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Mail Username</label>
                                        <input
                                            type="email"
                                            value={emailData.mail_username}
                                            onChange={(e) => setEmailData('mail_username', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                            required
                                        />
                                        {emailErrors.mail_username && <div className="text-red-500 text-xs mt-1">{emailErrors.mail_username}</div>}
                                    </div>
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-2">Mail App Password</label>
                                        <input
                                            type="password"
                                            value={emailData.mail_password}
                                            onChange={(e) => setEmailData('mail_password', e.target.value)}
                                            className="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-3"
                                            required
                                        />
                                        {emailErrors.mail_password && <div className="text-red-500 text-xs mt-1">{emailErrors.mail_password}</div>}
                                    </div>
                                    <div className="pt-6 border-t border-gray-100">
                                        <button
                                            type="submit"
                                            disabled={emailProcessing}
                                            className="px-6 py-3 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm w-full sm:w-auto disabled:opacity-50"
                                        >
                                            Simpan Konfigurasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </DashboardLayout>
    );
}
