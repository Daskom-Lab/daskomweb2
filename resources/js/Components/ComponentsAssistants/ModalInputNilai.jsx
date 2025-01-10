import { useState } from "react";

export default function ModalInputNilai({ onClose, onConfirm }) {
    const [tp, setTp] = useState(0);
    const [ta, setTa] = useState(0);
    const [d1, setD1] = useState(0);
    const [d2, setD2] = useState(0);
    const [d3, setD3] = useState(0);
    const [d4, setD4] = useState(0);
    const [l1, setL1] = useState(0);
    const [l2, setL2] = useState(0);
    const [totalNilai, setTotalNilai] = useState(0);
    const [isModalVisible, setIsModalVisible] = useState(false);

    const handleCalculateTotal = () => {
        const total = tp + ta + d1 + d2 + d3 + d4 + l1 + l2;
        setTotalNilai(total);
    };

    const handleSubmit = () => {
        handleCalculateTotal();
        onConfirm();

      
        setIsModalVisible(true);
        setTimeout(() => {
            setIsModalVisible(false);
            onClose(false);
        }, 3000);
    };

    return (
        <div>
            <div className="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div className="bg-white p-6 rounded-lg w-[900px]">
                    <h2 className="text-3xl font-bold text-center text-fireRed mb-12">INPUT NILAI</h2>

                    <div className="space-y-4">
                        {/* Input Fields */}
                        <div className="grid grid-cols-9 gap-4">
                            <div>
                                <label className="block mb-2 font-semibold">TP</label>
                                <input
                                    type="number"
                                    value={tp}
                                    onChange={(e) => setTp(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">TA</label>
                                <input
                                    type="number"
                                    value={ta}
                                    onChange={(e) => setTa(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">D1</label>
                                <input
                                    type="number"
                                    value={d1}
                                    onChange={(e) => setD1(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">D2</label>
                                <input
                                    type="number"
                                    value={d2}
                                    onChange={(e) => setD2(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">D3</label>
                                <input
                                    type="number"
                                    value={d3}
                                    onChange={(e) => setD3(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">D4</label>
                                <input
                                    type="number"
                                    value={d4}
                                    onChange={(e) => setD4(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">L1</label>
                                <input
                                    type="number"
                                    value={l1}
                                    onChange={(e) => setL1(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            <div>
                                <label className="block mb-2 font-semibold">L2</label>
                                <input
                                    type="number"
                                    value={l2}
                                    onChange={(e) => setL2(Number(e.target.value))}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                            {/* Total Nilai */}
                            <div>
                                <label className="block mb-2 font-semibold">Total Nilai</label>
                                <input
                                    type="number"
                                    value={totalNilai}
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                        </div>

                        {/* Deskripsi */}
                        <div className="mt-4 text-md text-gray-600">
                            <p><strong>TP:</strong> Tugas Pendahuluan</p>
                            <p><strong>TA:</strong> Tugas Awal</p>
                            <p><strong>D1, D2, D3, D4:</strong> Detail Penilaian dari keaktifan praktikum</p>
                            <p><strong>L1:</strong> Tugas Keterampilan (TK)</p>
                            <p><strong>L2:</strong> Tugas Mandiri</p>
                        </div>
                    </div>

                    {/* Action Buttons */}
                    <div className="mt-6 flex justify-end space-x-4">
                        <button
                            onClick={onClose}
                            className="px-4 py-2 bg-darkBrown font-semibold text-white rounded-md"
                        >
                            Cancel
                        </button>
                        <button
                            onClick={handleSubmit}
                            className="px-4 py-2 bg-deepForestGreen hover:bg-darkGreen font-semibold text-white rounded-md"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            {/* Modal Konfirmasi */}
            {isModalVisible && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-4 w-80 shadow-lg text-center">
                        <h3 className="text-lg font-semibold">Berhasil Disimpan</h3>
                        <p className="text-gray-500 mt-2">Nilai telah berhasil disimpan.</p>
                    </div>
                </div>
            )}
        </div>
    );
}
