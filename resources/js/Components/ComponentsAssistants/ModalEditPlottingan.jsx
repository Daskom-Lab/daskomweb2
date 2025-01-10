import React, { useState } from "react";

export default function ModalEditPlotting({ onClose }) {
    const [showSuccessModal, setShowSuccessModal] = useState(false);

    const handleSave = () => {
        setShowSuccessModal(true);

        setTimeout(() => {
            setShowSuccessModal(false);
            onClose();
        }, 3000); 
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            {/* Modal Utama */}
            <div className="bg-white rounded-lg p-6 w-[700px] shadow-lg relative">
                {/* Header */}
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-xl font-bold text-darkGreen">Edit Jadwal</h2>
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-7 flex justify-center items-center"
                    >
                        ×
                    </button>
                </div>

                {/* Input Informasi Jadwal */}
                <div className="grid grid-cols-4 gap-4 mb-4">
                    <div>
                        <label htmlFor="kelas" className="block text-black text-sm font-medium">
                            Kelas
                        </label>
                        <input
                            id="kelas"
                            type="text"
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                            placeholder="Kelas"
                        />
                    </div>
                    <div>
                        <label htmlFor="hari" className="block text-black text-sm font-medium">
                            Hari
                        </label>
                        <input
                            id="hari"
                            type="text"
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                            placeholder="Hari"
                        />
                    </div>
                    <div>
                        <label htmlFor="shift" className="block text-black text-sm font-medium">
                            Shift
                        </label>
                        <input
                            id="shift"
                            type="number"
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                            placeholder="Shift"
                        />
                    </div>
                    <div>
                        <label htmlFor="kelompok" className="block text-black text-sm font-medium">
                            Kelompok
                        </label>
                        <input
                            id="kelompok"
                            type="number"
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                            placeholder="Kelompok"
                        />
                    </div>
                </div>

                {/* Daftar Checkbox */}
                <div className="max-h-60 overflow-y-auto border-t border-gray-300 pt-4">
                    {Array.from({ length: 12 }).map((_, index) => (
                        <div
                            key={index}
                            className="flex items-center gap-2 p-2 border rounded-md mb-2"
                        >
                            <input
                                type="checkbox"
                                id={`checkbox-${index}`}
                                className="w-4 h-4"
                            />
                            <label
                                htmlFor={`checkbox-${index}`}
                                className="text-gray-700"
                            >
                                DEY | Dhea Aisyah Putri
                            </label>
                        </div>
                    ))}
                </div>

                {/* Tombol Simpan */}
                <div className="mt-4 text-right">
                    <button
                        onClick={onClose}
                        className="px-6 py-2 bg-gray-300 text-darkBrown font-semibold rounded-md shadow hover:bg-gray-400 transition duration-300 mr-2"
                    >
                        Batal
                    </button>
                    <button
                        onClick={handleSave}
                        className="px-6 py-2 bg-deepForestGreen text-white font-semibold rounded-md shadow hover:bg-darkGreen transition duration-300"
                    >
                        Simpan
                    </button>
                </div>
            </div>

            {/* Modal Notifikasi */}
            {showSuccessModal && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-6 w-[400px] shadow-lg text-center">
                        <h2 className="text-2xl font-bold text-darkGreen text-center p-3">
                            Jadwal berhasil diedit!
                        </h2>
                    </div>
                </div>
            )}
        </div>
    );
}
