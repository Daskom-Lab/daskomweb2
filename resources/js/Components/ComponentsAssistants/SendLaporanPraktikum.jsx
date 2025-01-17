import { useState } from "react";
import closeIcon from "../../../assets/modal/iconClose.svg";

export default function ModalLaporanPraktikum({ onClose }) {
    const [showSuccessModal, setShowSuccessModal] = useState(false);
    const [judul, setJudul] = useState("");
    const [deskripsi, setDeskripsi] = useState("");
    const [kodeAsisten, setKodeAsisten] = useState("");
    const [kodeAsistenError, setKodeAsistenError] = useState("");

    const handleSave = () => {
        if (kodeAsistenError) {
            return;
        }
        setShowSuccessModal(true);

        setTimeout(() => {
            setShowSuccessModal(false);
            onClose();
        }, 3000);
    };

    const handleKodeAsistenChange = (e) => {
        const value = e.target.value.toUpperCase();

        // validasi ini
        if (value === "" || /^[A-Z-]+$/.test(value)) {
            setKodeAsisten(value);
            setKodeAsistenError("");
        } else {
            setKodeAsistenError("Kode asisten tidak valid. Pastikan formatnya benar, misalnya: ALL-DEY-FYN.");
        }
    };


    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            {/* Modal Utama */}
            <div className="bg-white rounded-lg p-6 w-[800px] shadow-lg relative">
                {/* Header */}
                <div className="flex justify-between items-center border-b border-deepForestGreen mb-6">
                    <h2 className="text-2xl font-bold text-darkGreen">Laporan Praktikum</h2>
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 flex justify-center items-center"
                    >
                        <img className="w-9" src={closeIcon} alt="closeIcon" />
                    </button>
                </div>

                {/* Container */}
                <div>
                    {/* Input Kode Asisten */}
                    <div className="mb-4">
                        <label htmlFor="kodeAsisten" className="block text-lg font-semibold text-darkGreen mb-2">
                            Asisten Yang Mengajar
                        </label>
                        <input
                            id="kodeAsisten"
                            value={kodeAsisten}
                            onChange={handleKodeAsistenChange}
                            className="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-deepForestGreen"
                            placeholder="ex: ALL-DHY-FYN-DEY-JIN"
                        />
                        {/* peringatan aja */}
                        {kodeAsistenError && (
                            <p className="text-red-500 text-sm mt-2">{kodeAsistenError}</p>
                        )}
                    </div>

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
                            rows="7"
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
