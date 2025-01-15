import { useState } from "react";

export default function ModalEditSoalPG({ soalItem, onClose, onConfirm }) {
    const [soal, setSoal] = useState(soalItem.soal);
    const [pilihan, setPilihan] = useState(soalItem.pilihan);
    const [mode] = useState(soalItem.mode);

    const handleSoalChange = (index, value) => {
        const updatedSoal = [...soal];
        updatedSoal[index] = value;
        setSoal(updatedSoal);
    };

    const handlePilihanChange = (index, value) => {
        const updatedPilihan = [...pilihan];
        updatedPilihan[index] = value;
        setPilihan(updatedPilihan);
    };

    const handleConfirm = () => {
        const updatedSoalItem = { ...soalItem, soal, pilihan };
        onConfirm(updatedSoalItem);
    };

    return (
        <div className="modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="modal-content bg-white rounded-lg p-6 w-[1000px] max-h-[90vh] shadow-lg overflow-y-auto relative">
                <h2 className="text-xl font-bold text-darkGreen mb-4">Edit Soal</h2>
                <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-7 flex justify-center items-center"
                    >
                        ×
                    </button>
                {mode === "kode" ? (
                    <div>
                        <input
                            type="text"
                            value={soal[0]}
                            onChange={(e) => handleSoalChange(0, e.target.value)}
                            placeholder="Deskripsi soal"
                            className="input w-full border border-gray-300 rounded-lg p-2 mb-4"
                        />
                        <textarea
                            value={soal[1]}
                            rows="10"
                            onChange={(e) => handleSoalChange(1, e.target.value)}
                            placeholder="Kode soal"
                            className="textarea w-full border border-gray-300 rounded-lg p-2 mb-4"
                        ></textarea>
                        <textarea
                            value={soal[2]}
                            rows="4"
                            onChange={(e) => handleSoalChange(2, e.target.value)}
                            placeholder="Soal terkait kode"
                            className="textarea w-full border border-gray-300 rounded-lg p-2 mb-4"
                        ></textarea>
                    </div>
                ) : (
                    soal.map((item, index) => (
                        <textarea
                            key={index}
                            value={item}
                            rows="10"  // nambah rows flexibel aja, tambahin @zaidan kalau kurang
                            onChange={(e) => handleSoalChange(index, e.target.value)}
                            placeholder="Edit soal..."
                            className="textarea w-full border border-gray-300 rounded-lg p-2 mb-4"
                        ></textarea>
                    ))
                )}
                <label className="block text-gray-700 font-medium mb-2">Pilihan Jawaban:</label>
                <div className="grid grid-cols-1 gap-4">
                    {pilihan.map((pil, index) => (
                        <input
                            key={index}
                            value={pil}
                            onChange={(e) => handlePilihanChange(index, e.target.value)}
                            placeholder={`Pilihan ${String.fromCharCode(65 + index)}`}
                            className="input w-full border border-gray-300 rounded-lg p-2"
                        />
                    ))}
                </div>
                <div className="modal-actions flex justify-end gap-4 mt-6">
                    <button
                        onClick={handleConfirm}
                        className="button-confirm px-6 py-2 bg-deepForestGreen text-white font-semibold rounded-md shadow hover:bg-darkGreen transition duration-300"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    );
}
