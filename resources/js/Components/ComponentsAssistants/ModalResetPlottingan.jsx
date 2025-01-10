import React, { useState } from "react";

export default function ButtonResetPlotting({ onClose }) {
    const [showSuccessModal, setShowSuccessModal] = useState(false);

    const handleSave = () => {
        console.log("Data telah direset.");
        setShowSuccessModal(true);
        setTimeout(() => {
            setShowSuccessModal(false); 
            onClose(); 
        }, 3000);
    };

    return (
        <>
            {/* Modal Konfirmasi Reset */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div className="bg-white rounded-lg p-6 w-[400px] shadow-xl relative animate-fade-in">
                    {/* Header */}
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-xl font-bold text-red-600">
                            Konfirmasi Reset
                        </h2>
                        <button
                            onClick={onClose}
                            className="text-xl font-bold text-darkBrown hover:text-red-500 transition duration-300"
                        >
                            ×
                        </button>
                    </div>

                    {/* Deskripsi Reset Modal */}
                    <div className="text-center mb-6">
                        <p className="text-black">
                            Semua data plottingan akan dihapus dan dikembalikan ke kondisi awal.
                            Apakah Anda yakin ingin mereset data?
                        </p>
                    </div>

                    {/* Tombol Aksi */}
                    <div className="flex justify-center gap-4">
                        <button
                            onClick={onClose}
                            className="px-6 py-2 bg-gray-300 text-darkBrown font-semibold rounded-md shadow hover:bg-gray-400 transition duration-300"
                        >
                            Batal
                        </button>
                        <button
                            onClick={handleSave}
                            className="px-6 py-2 bg-red-600 text-white font-semibold rounded-md shadow hover:bg-red-700 transition duration-300"
                        >
                            Reset Data
                        </button>
                    </div>
                </div>
            </div>

            {/* Modal Sukses */}
            {showSuccessModal && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-4 w-96 shadow-lg text-center">
                        <h3 className="text-lg font-semibold text-black">Berhasil Disimpan</h3>
                        <p className="text-redredDark mt-2">
                            Data telah berhasil direset ke kondisi awal.
                        </p>
                    </div>
                </div>
            )}
        </>
    );
}
