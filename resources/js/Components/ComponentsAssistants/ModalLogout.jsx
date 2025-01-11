import React from 'react';

export default function ModalLogout({ onClose, onConfirm }) {
    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div className="bg-softGray p-6 rounded shadow-lg w-1/4 relative">
                {/* Tombol X untuk tutup */}
                <button
                    onClick={onClose}
                    className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-7 h-7 flex justify-center items-center"
                >
                    ×
                </button>

                <h2 className="text-2xl font-bold text-center mt-8 mb-5">Apakah Kamu Yakin?</h2>

                {/* Tombol Iya dan Tidak dengan gap kecil dan warna hijau untuk Iya, abu-abu untuk Tidak */}
                <div className="flex justify-center gap-2 mt-6">
                    <button
                        onClick={onConfirm}
                        className="w-1/3 p-2 bg-deepForestGreen text-white font-semibold rounded hover:bg-darkGreen"
                    >
                        Ya
                    </button>
                    <button
                        onClick={onClose}
                        className="w-1/3 p-2 bg-softRed text-white font-semibold rounded hover:bg-rustyRed"
                    >
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    );
}
