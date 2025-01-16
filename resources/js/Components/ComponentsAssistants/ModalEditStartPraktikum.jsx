import { useState } from "react";

export default function ButtonEditStartPraktikum({ onClose }) {
    const [showSuccessModal, setShowSuccessModal] = useState(false);
    const [formData, setFormData] = useState({
        tesAwalStart: "2024-08-17T18:00",
        tesAwalEnd: "2024-08-21T18:00",
        jurnalStart: "2024-08-17T18:00",
        jurnalEnd: "2024-08-21T18:00",
        mandiriStart: "2024-08-17T18:00",
        mandiriEnd: "2024-08-21T18:00",
        keterampilanStart: "2024-08-17T18:00",
        keterampilanEnd: "2024-08-21T18:00",
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

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
            <div className="bg-white rounded-lg p-6 w-[800px] shadow-lg relative overflow-y-auto max-h-[80vh]">
                {/* Header */}
                <div className="flex justify-between items-center mb-6 border-b border-deepForestGreen">
                    <h2 className="text-2xl font-bold text-deepForestGreen">Edit Start Praktikum</h2>
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-7 flex justify-center items-center"
                    >
                        ×
                    </button>
                </div>

                {/* content edit */}
                <div className="overflow-x-auto mt-4 mb-2">
                    <table className="table-auto w-auto text-left">
                        <tbody>
                            <tr>
                                <td className="px-4 py-1 text-black font-medium">Tes Awal</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="tesAwalStart"
                                        value={formData.tesAwalStart}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                                <td className="px-4 py-1">-</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="tesAwalEnd"
                                        value={formData.tesAwalEnd}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td className="px-4 py-1 text-black font-medium">Jurnal</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="jurnalStart"
                                        value={formData.jurnalStart}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                                <td className="px-4 py-1">-</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="jurnalEnd"
                                        value={formData.jurnalEnd}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td className="px-4 py-1 text-black font-medium">Mandiri</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="mandiriStart"
                                        value={formData.mandiriStart}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                                <td className="px-4 py-1">-</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="mandiriEnd"
                                        value={formData.mandiriEnd}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                            </tr>
                            <tr>
                                <td className="px-4 py-1 text-black font-medium">Tes Keterampilan</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="keterampilanStart"
                                        value={formData.keterampilanStart}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                                <td className="px-4 py-1">-</td>
                                <td className="px-4 py-1">
                                    <input
                                        type="datetime-local"
                                        name="keterampilanEnd"
                                        value={formData.keterampilanEnd}
                                        onChange={handleChange}
                                        className="border rounded px-2 py-1 w-full"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                        <h2 className="text-xl font-bold text-darkGreen text-center p-3">
                            Waktu praktikum berhasil diedit!
                        </h2>
                    </div>
                </div>
            )}
        </div>
    );
}
