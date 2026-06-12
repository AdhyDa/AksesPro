import UserDashboardLayout from '@/Layouts/UserDashboardLayout';
import { Head, Link } from '@inertiajs/react';

export default function Transaksi({ user, transactions }) {
    return (
        <UserDashboardLayout user={user} title="Riwayat Transaksi">
            <Head title="Riwayat Transaksi — AksesPro" />

            <div className="space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">Riwayat Transaksi</h1>
                    <p className="text-sm text-gray-500 mt-1">Daftar semua pembelian dan transaksi tukar poin Anda.</p>
                </div>

                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead className="bg-gray-50 text-xs uppercase text-gray-500 font-semibold">
                                <tr>
                                    <th className="px-6 py-4 text-left">Invoice</th>
                                    <th className="px-6 py-4 text-left">Tanggal</th>
                                    <th className="px-6 py-4 text-left">Produk</th>
                                    <th className="px-6 py-4 text-left">Jumlah</th>
                                    <th className="px-6 py-4 text-left">Metode</th>
                                    <th className="px-6 py-4 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {transactions.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="px-6 py-12 text-center text-gray-400">
                                            Belum ada riwayat transaksi.
                                        </td>
                                    </tr>
                                ) : (
                                    transactions.map((trx, index) => (
                                        <tr key={index} className="hover:bg-gray-50/50">
                                            <td className="px-6 py-4 font-mono font-bold text-[#0A2540]">{trx.id}</td>
                                            <td className="px-6 py-4 text-gray-600">{trx.date}</td>
                                            <td className="px-6 py-4 text-gray-900 font-medium">{trx.product}</td>
                                            <td className="px-6 py-4 text-gray-900 font-semibold">
                                                Rp {parseFloat(trx.amount).toLocaleString('id-ID')}
                                            </td>
                                            <td className="px-6 py-4 text-gray-600">{trx.method}</td>
                                            <td className="px-6 py-4">
                                                <span className={`font-semibold px-2.5 py-1 rounded-md text-xs ${
                                                    trx.status === 'Berhasil'
                                                        ? 'bg-emerald-50 text-emerald-700'
                                                        : trx.status === 'Menunggu'
                                                        ? 'bg-yellow-50 text-yellow-700'
                                                        : 'bg-red-50 text-red-700'
                                                }`}>
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
            </div>
        </UserDashboardLayout>
    );
}
