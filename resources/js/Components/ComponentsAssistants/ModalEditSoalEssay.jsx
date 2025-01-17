import { useState } from "react";
import closeIcon from "../../../assets/modal/iconClose.svg"

export default function ModalEditSoalEssay({ onClose, initialSoal, onSave }) {
    const [soal, setSoal] = useState(initialSoal || "");
    const [showSuccessModal, setShowSuccessModal] = useState(false);

    const handleSave = () => {
        // ini dipanggil
        onSave(soal); 
        // di tunjukin
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
                <div className="flex justify-between items-center mb-6 border-b border-deepForestGreen">
                    <h2 className="text-2xl font-bold text-darkGreen">Edit Soal</h2>
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 flex justify-center items-center"
                    >        
                        <img className="w-9" src={closeIcon} alt="closeIcon" />
                    </button>
                </div>

                {/* Edit soal */}
                <textarea
                    className="w-full p-2 border rounded"
                    rows="10"
                    placeholder="Edit soal..."
                    value={soal}
                    onChange={(e) => setSoal(e.target.value)}
                ></textarea>

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
                            Soal berhasil diedit!
                        </h2>
                    </div>
                </div>
            )}
        </div>
    );
}