import { useState } from "react";

export default function ModalPasswordAssistant({ onClose }) {
    const [newPassword, setNewPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [isSuccess, setIsSuccess] = useState(false); 

    const handleChangePassword = () => {
        if (newPassword !== confirmPassword) {
            alert('Passwords do not match');
        } else {
            console.log('Password changed successfully');
            setIsSuccess(true); // Menampilkan modal sukses
        }
    };

    const closeSuccessModal = () => {
        setIsSuccess(false); // Menutup modal sukses
        onClose(); // Menutup modal utama
    };

    return (
        <div>
            {/* Modal utama untuk ganti password */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div className="bg-softGray p-8 rounded shadow-lg w-[30%] relative">
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-7 h-7 flex justify-center items-center"
                    >
                        ×
                    </button>

                    <h2 className="text-3xl font-bold text-center mt-4 mb-9">Ganti Password</h2>

                    {/* Form untuk mengganti password */}
                    <div className="mb-4">
                        <input
                            type="password"
                            placeholder='Password Baru'
                            value={newPassword}
                            onChange={(e) => setNewPassword(e.target.value)}
                            className="w-full p-2 border border-gray-300 rounded"
                        />
                    </div>

                    <div className="mb-4">
                        <input
                            type="password"
                            placeholder='Konfirmasi Password Baru'
                            value={confirmPassword}
                            onChange={(e) => setConfirmPassword(e.target.value)}
                            className="w-full p-2 border border-gray-300 rounded"
                        />
                    </div>

                    <button
                        onClick={handleChangePassword}
                        className="w-full p-2 bg-deepForestGreen text-white font-semibold rounded hover:bg-darkGreen"
                    >
                        Simpan
                    </button>
                </div>
            </div>

            {/* Modal konfirmasi sukses */}
            {isSuccess && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-white p-8 rounded shadow-lg w-[30%] text-center">
                        <h2 className="text-2xl font-bold mb-4">Berhasil Disimpan</h2>
                        <p className="mb-6">Password Anda telah berhasil diganti.</p>
                        <button
                            onClick={closeSuccessModal}
                            className="w-full p-2 bg-deepForestGreen text-white font-semibold rounded hover:bg-darkGreen"
                        >
                            OK
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}
