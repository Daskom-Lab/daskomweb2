import React from 'react';

export default function ModalBlokPraktikum({ onClose }) {
    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div className="bg-white p-6 rounded-lg w-96 text-center">
                <h2 className="text-2xl font-bold mb-4 text-fireRed">Waktu Mulai Sudah Terlewati!</h2>
                <p className="mb-4">Silakan pilih waktu mulai yang valid untuk memulai praktikum.</p>
                <div className="flex justify-center mt-6">
                    <button
                        onClick={onClose}
                        className="px-4 py-1 bg-rustyRed text-white font-semibold rounded-lg hover:bg-softRed"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    );
}
