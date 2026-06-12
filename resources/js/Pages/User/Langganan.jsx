import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';

export default function Langganan({ user, subscriptions }) {
    return (
        <UserDashboardLayout user={user} title="Langganan Aktif">
            <Head title="Langganan Aktif — AksesPro" />

            <div className="space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Langganan Aktif</h1>
                    <p className="text-sm text-gray-500 mt-1">Daftar semua akun premium Anda yang sedang aktif saat ini.</p>
                </div>

                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead className="bg-gray-50 text-xs uppercase text-gray-500 font-semibold">
                                <tr>
                                    <th className="px-6 py-4 text-left">Produk</th>
                                    <th className="px-6 py-4 text-left">Paket</th>
                                    <th className="px-6 py-4 text-left">Tanggal Mulai</th>
                                    <th className="px-6 py-4 text-left">Tanggal Berakhir</th>
                                    <th className="px-6 py-4 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {subscriptions.length === 0 ? (
                                    <tr>
                                        <td colSpan={5} className="px-6 py-12 text-center text-gray-400">
                                            Anda belum memiliki langganan aktif.
                                        </td>
                                    </tr>
                                ) : (
                                    subscriptions.map((sub, index) => (
                                        <tr key={index} className="hover:bg-gray-50/50">
                                            <td className="px-6 py-4 flex items-center gap-3">
                                                <img
                                                    src={sub.logo_path ? `/${sub.logo_path.replace(/^\//, '')}` : '/image/canva.jpg'}
                                                    alt={sub.name}
                                                    className="w-8 h-8 object-contain rounded"
                                                    onError={(e) => { e.target.src = '/image/canva.jpg'; }}
                                                />
                                                <span className="font-bold text-gray-900">{sub.name}</span>
                                            </td>
                                            <td className="px-6 py-4 text-gray-600">{sub.package}</td>
                                            <td className="px-6 py-4 text-gray-600">{sub.start_date}</td>
                                            <td className="px-6 py-4 text-gray-600">{sub.end_date}</td>
                                            <td className="px-6 py-4">
                                                <span className="bg-emerald-50 text-emerald-700 font-semibold px-2.5 py-1 rounded-md text-xs">
                                                    {sub.status}
                                                </span>
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
