import { useState } from "react";

export default function ModalLaporanPraktikum({ onClose }) {
    const [showSuccessModal, setShowSuccessModal] = useState(false);
    const [judul, setJudul] = useState("");
    const [deskripsi, setDeskripsi] = useState("");

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
            <div className="bg-white rounded-lg p-6 w-[800px] shadow-lg relative">
                {/* Header */}
                <div className="flex justify-between items-center border-b border-deepForestGreen mb-6">
                    <h2 className="text-2xl font-bold text-darkGreen">Laporan Praktikum</h2>
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-7 flex justify-center items-center"
                    >
                        ×
                    </button>
                </div>

                {/* Container */}
                <div>
                    {/* Input Deskripsi */}
                    <div className="mb-4">
                        <label htmlFor="deskripsi" className="block text-lg font-semibold text-darkGreen mb-2">
                            Deskripsi
                        </label>
                        <textarea
                            id="deskripsi"
                            value={deskripsi}
                            onChange={(e) => setDeskripsi(e.target.value)}
                            className="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-deepForestGreen"
                            rows="10"
                            placeholder="Masukkan deskripsi laporan"
                        />
                    </div>
                </div>

                {/* Tombol Simpan */}
                <div className="mt-4 text-right">
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
                            Laporan berhasil dikirim!
                        </h2>
                    </div>
                </div>
            )}
        </div>
    );
}
