import { useState } from "react";
import closeIcon from "../../../assets/modal/iconClose.svg";
import failedIcon from "../../../assets/modal/failedSymbol.png"

export default function ModalPasswordAssistant({ onClose }) {
    const [newPassword, setNewPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [isSuccess, setIsSuccess] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');

    const handleChangePassword = () => {
        if (!newPassword || !confirmPassword) {
            setErrorMessage('Semua kolom harus diisi.');
        } else if (newPassword !== confirmPassword) {
            setErrorMessage('Password tidak cocok.');
        } else {
            setErrorMessage('');
            setIsSuccess(true);
        }
    };

    const closeSuccessModal = () => {
        setIsSuccess(false);
        onClose();
    };

    const closeErrorModal = () => {
        setErrorMessage('');
    };

    return (
        <div>
            {/* Modal utama untuk ganti password */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div className="bg-softGray p-8 rounded shadow-lg w-[30%] relative">
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 flex justify-center items-center"
                    >
                        <img className="w-9" src={closeIcon} alt="closeIcon" />
                    </button>

                    <h2 className="text-3xl font-bold text-center mt-4 mb-9">Ganti Password</h2>

                    {/* Form untuk mengganti password */}
                    <div className="mb-4">
                        <input
                            type="password"
                            placeholder="Password Baru"
                            value={newPassword}
                            onChange={(e) => setNewPassword(e.target.value)}
                            className="w-full p-2 border border-gray-300 rounded"
                        />
                    </div>

                    <div className="mb-4">
                        <input
                            type="password"
                            placeholder="Konfirmasi Password Baru"
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

            {errorMessage && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-softGray p-8 rounded shadow-lg w-[30%] relative flex flex-col items-center">
                        {/* Tombol X untuk tutup */}
                        <button
                            onClick={closeErrorModal}
                            className="absolute top-2 right-2 flex justify-center items-center"
                        >
                            <img className="w-9" src={closeIcon} alt="closeIcon" />
                        </button>

                        {/* Ikon error */}
                        <img className="w-28 mb-4" src={failedIcon} alt="failedIcon" />

                        {/* Pesan error */}
                        <p className="text-center mb-6 text-xl font-semibold text-darkGreen">{errorMessage}</p>

                        {/* Tombol OK */}
                        <button
                            onClick={closeErrorModal}
                            className="w-full p-2 bg-deepForestGreen text-white font-semibold rounded hover:bg-darkGreen"
                        >
                            OK
                        </button>
                    </div>
                </div>
            )}

            {isSuccess && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-softGray p-8 rounded shadow-lg w-[30%] relative flex flex-col items-center">
                        {/* Tombol X untuk tutup */}
                        <button
                            onClick={closeSuccessModal}
                            className="absolute top-2 right-2 flex justify-center items-center"
                        >
                            <img className="w-9" src={closeIcon} alt="closeIcon" />
                        </button>

                        {/* Pesan sukses */}
                        <p className="text-center mt-4 text-xl font-semibold text-darkGreen">Password Anda telah berhasil diganti.</p>

                    </div>
                </div>
            )}

        </div>
    );
}
