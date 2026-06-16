import React, { useState } from 'react';
import { Head, usePage, useForm, router } from '@inertiajs/react';
import DashboardLayout from '@/Layouts/DashboardLayout';
import axios from 'axios';

/**
 * Admin/Pengguna.jsx
 *
 * Props:
 *   - admin: { name }
 *   - users: Array<{ id, name, email, role, points, join_date, status }>
 */
export default function Pengguna({ admin, users }) {
    const { flash } = usePage().props;

    const [search, setSearch] = useState('');
    const [filterRole, setFilterRole] = useState('Semua Peran');
    const [showToast, setShowToast] = useState(false);
    const [toastMessage, setToastMessage] = useState('');

    const [openAddModal, setOpenAddModal] = useState(false);
    const [openEditModal, setOpenEditModal] = useState(false);
    const [editUserId, setEditUserId] = useState('');

    // Inertia form for adding new user
    const { data: addData, setData: setAddData, post: postAdd, reset: resetAdd, errors: addErrors, processing: addProcessing } = useForm({
        name: '',
        email: '',
        password: '',
    });

    // Inertia form for editing user
    const { data: editData, setData: setEditData, put: putEdit, reset: resetEdit, errors: editErrors, processing: editProcessing } = useForm({
        name: '',
        email: '',
        password: '',
    });

    const handleOpenEdit = (user) => {
        setEditUserId(user.id);
        setEditData({
            name: user.name,
            email: user.email,
            password: '',
        });
        setOpenEditModal(true);
    };

    const submitAdd = (e) => {
        e.preventDefault();
        postAdd('/admin/pengguna', {
            onSuccess: () => {
                setOpenAddModal(false);
                resetAdd();
                setToastMessage('User berhasil ditambahkan.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    const submitEdit = (e) => {
        e.preventDefault();
        putEdit(`/admin/pengguna/${editUserId}`, {
            onSuccess: () => {
                setOpenEditModal(false);
                resetEdit();
                setToastMessage('User berhasil diperbarui.');
                setShowToast(true);
                setTimeout(() => setShowToast(false), 2000);
            }
        });
    };

    const handleToggleStatus = (id, name) => {
        axios.post(`/admin/pengguna/${id}/toggle-status`)
            .then(res => {
                if (res.data.success) {
                    setToastMessage(`Status ${name} berhasil diubah`);
                    setShowToast(true);
                    setTimeout(() => {
                        setShowToast(false);
                        router.reload({ preserveScroll: true });
                    }, 1500);
                }
            })
            .catch(err => {
                console.error(err);
            });
    };

    const handleDelete = (id, name) => {
        if (confirm(`Apakah Anda yakin ingin menghapus pengguna ${name}?`)) {
            router.delete(`/admin/pengguna/${id}`, {
                onSuccess: () => {
                    setToastMessage(`Pengguna ${name} berhasil dihapus`);
                    setShowToast(true);
                    setTimeout(() => setShowToast(false), 2000);
                }
            });
        }
    };

    // Filter users
    const filteredUsers = users.filter(u => {
        const matchesSearch = u.name.toLowerCase().includes(search.toLowerCase()) || 
                             u.email.toLowerCase().includes(search.toLowerCase());
        const matchesRole = filterRole === 'Semua Peran' || u.role.toLowerCase() === filterRole.toLowerCase();
        return matchesSearch && matchesRole;
    });

    const formatPoints = (points) => {
        return new Intl.NumberFormat('id-ID').format(points);
    };

    const formatDate = (dateString) => {
        if (!dateString) return '';
        const options = { day: '2-digit', month: 'short', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    };

    return (
        <DashboardLayout admin={admin} title="Kelola Pengguna">
            <Head title="Kelola Pengguna" />

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
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
                        <p className="text-sm text-gray-500 mt-1">Daftar anggota terdaftar dan riwayat aktivitas mereka.</p>
                    </div>

                    <button
                        onClick={() => setOpenAddModal(true)}
                        className="px-5 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-white font-bold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2"
                    >
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Tambah Pengguna
                    </button>
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

                {/* Filter / Search */}
                <div className="flex flex-col sm:flex-row gap-4">
                    <div className="relative flex-1">
                        <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full pl-10 p-3"
                            placeholder="Cari nama atau email pengguna..."
                        />
                    </div>

                    <select
                        value={filterRole}
                        onChange={(e) => setFilterRole(e.target.value)}
                        className="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] p-3 min-w-[150px]"
                    >
                        <option>Semua Peran</option>
                        <option>Member</option>
                        <option>Admin</option>
                    </select>
                </div>

                {/* Users Table */}
                <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th scope="col" className="px-6 py-4">Pengguna</th>
                                    <th scope="col" className="px-6 py-4">Peran</th>
                                    <th scope="col" className="px-6 py-4">Total Poin</th>
                                    <th scope="col" className="px-6 py-4">Tanggal Daftar</th>
                                    <th scope="col" className="px-6 py-4">Status</th>
                                    <th scope="col" className="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {filteredUsers.map((u) => (
                                    <tr key={u.id} className="bg-white hover:bg-gray-50 transition-colors">
                                        <td className="px-6 py-4 flex items-center gap-3">
                                            <img
                                                src={`https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=f3f4f6&color=0A2540`}
                                                alt={u.name}
                                                className="w-10 h-10 rounded-full border border-gray-200"
                                            />
                                            <div>
                                                <div className="font-bold text-gray-900">{u.name}</div>
                                                <div className="text-xs text-gray-500">{u.email}</div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="px-2.5 py-1 bg-[#0A2540]/5 text-[#0A2540] border border-[#0A2540]/10 rounded-md text-xs font-semibold">
                                                {u.role}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="font-bold text-[#00b8cc] flex items-center gap-1">
                                                <svg className="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {formatPoints(u.points)}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            {formatDate(u.join_date)}
                                        </td>
                                        <td className="px-6 py-4">
                                            {u.status === 'Aktif' ? (
                                                <span className="px-2.5 py-1 bg-green-50 text-green-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                                    <div className="w-1.5 h-1.5 rounded-full bg-green-500"></div> Aktif
                                                </span>
                                            ) : (
                                                <span className="px-2.5 py-1 bg-red-50 text-red-600 rounded-md text-xs font-semibold flex items-center gap-1 w-max">
                                                    <div className="w-1.5 h-1.5 rounded-full bg-red-500"></div> Suspended
                                                </span>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <div className="flex justify-center gap-2">
                                                <button
                                                    onClick={() => handleOpenEdit(u)}
                                                    className="p-2 bg-gray-50 text-gray-500 hover:bg-[#00E5FF]/10 hover:text-[#00b8cc] rounded-lg transition-colors"
                                                    title="Edit Pengguna"
                                                >
                                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    onClick={() => handleToggleStatus(u.id, u.name)}
                                                    className="p-2 bg-gray-50 text-gray-500 hover:bg-orange-100 hover:text-orange-600 rounded-lg transition-colors"
                                                    title="Banned / Suspend"
                                                >
                                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </button>
                                                <button
                                                    onClick={() => handleDelete(u.id, u.name)}
                                                    className="p-2 bg-gray-50 text-gray-500 hover:bg-red-100 hover:text-red-600 rounded-lg transition-colors"
                                                    title="Hapus Pengguna"
                                                >
                                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <span className="text-sm text-gray-500 font-medium">Menampilkan {filteredUsers.length} dari {users.length} total pengguna</span>
                    </div>
                </div>
            </div>

            {/* Modal: Tambah Pengguna */}
            {openAddModal && (
                <div className="fixed inset-0 z-50 overflow-y-auto">
                    <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div className="fixed inset-0 transition-opacity" onClick={() => setOpenAddModal(false)}>
                            <div className="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div className="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                            <form onSubmit={submitAdd}>
                                <div className="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                                    <h3 className="text-lg font-bold text-gray-900 mb-4">Tambah Pengguna Member</h3>
                                    <div className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                            <input
                                                type="text"
                                                value={addData.name}
                                                onChange={(e) => setAddData('name', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {addErrors.name && <div className="text-red-500 text-xs mt-1">{addErrors.name}</div>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Alamat Email</label>
                                            <input
                                                type="email"
                                                value={addData.email}
                                                onChange={(e) => setAddData('email', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {addErrors.email && <div className="text-red-500 text-xs mt-1">{addErrors.email}</div>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Password</label>
                                            <input
                                                type="password"
                                                value={addData.password}
                                                onChange={(e) => setAddData('password', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {addErrors.password && <div className="text-red-500 text-xs mt-1">{addErrors.password}</div>}
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                                    <button
                                        type="submit"
                                        disabled={addProcessing}
                                        className="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-base font-bold text-white sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                                    >
                                        Simpan
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => setOpenAddModal(false)}
                                        className="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                                    >
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}

            {/* Modal: Edit Pengguna */}
            {openEditModal && (
                <div className="fixed inset-0 z-50 overflow-y-auto">
                    <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div className="fixed inset-0 transition-opacity" onClick={() => setOpenEditModal(false)}>
                            <div className="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span className="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div className="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                            <form onSubmit={submitEdit}>
                                <div className="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                                    <h3 className="text-lg font-bold text-gray-900 mb-4">Edit Pengguna</h3>
                                    <div className="space-y-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                            <input
                                                type="text"
                                                value={editData.name}
                                                onChange={(e) => setEditData('name', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {editErrors.name && <div className="text-red-500 text-xs mt-1">{editErrors.name}</div>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">Alamat Email</label>
                                            <input
                                                type="email"
                                                value={editData.email}
                                                onChange={(e) => setEditData('email', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                                required
                                            />
                                            {editErrors.email && <div className="text-red-500 text-xs mt-1">{editErrors.email}</div>}
                                        </div>
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700">
                                                Password Baru <span className="text-xs text-gray-400">(kosongkan jika tidak diubah)</span>
                                            </label>
                                            <input
                                                type="password"
                                                value={editData.password}
                                                onChange={(e) => setEditData('password', e.target.value)}
                                                className="mt-1 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#00E5FF] focus:border-[#00E5FF] block w-full p-2.5"
                                            />
                                            {editErrors.password && <div className="text-red-500 text-xs mt-1">{editErrors.password}</div>}
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-2">
                                    <button
                                        type="submit"
                                        disabled={editProcessing}
                                        className="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-[#0A2540] hover:bg-[#0d2e59] text-base font-bold text-white sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                                    >
                                        Simpan
                                    </button>
                                    <button
                                        type="button"
                                        onClick={() => setOpenEditModal(false)}
                                        className="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm"
                                    >
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}
        </DashboardLayout>
    );
}
