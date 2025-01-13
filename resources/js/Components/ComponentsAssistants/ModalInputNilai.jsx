import { useState, useEffect } from "react";

import ModalJawabanTP from "./ModalJawabanTP";

export default function ModalInputNilai({ onClose, onConfirm }) {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => {
        setIsModalOpen(true);
    };

    const handleCloseModal = () => {
        setIsModalOpen(false);
    };

    const [tp, setTp] = useState(0);
    const [ta, setTa] = useState(0);
    const [d1, setD1] = useState(0);
    const [d2, setD2] = useState(0);
    const [d3, setD3] = useState(0);
    const [d4, setD4] = useState(0);
    const [l1, setL1] = useState(0);
    const [l2, setL2] = useState(0);
    const [totalNilai, setTotalNilai] = useState(0);
    const [feedback, setFeedback] = useState(""); // State untuk feedback
    const [isModalVisible, setIsModalVisible] = useState(false);

    const handleCalculateTotal = () => {
        const total = (tp + ta + d1 + d2 + d3 + d4 + l1 + l2) / 8;
        setTotalNilai(total || 0); // ga ada nun (aman)
    };

    useEffect(() => {
        handleCalculateTotal();
    }, [tp, ta, d1, d2, d3, d4, l1, l2]);

    const handleSubmit = () => {
        onConfirm({
            tp,
            ta,
            d1,
            d2,
            d3,
            d4,
            l1,
            l2,
            totalNilai,
            feedback,
        });
        setIsModalVisible(true);
        setTimeout(() => {
            setIsModalVisible(false);
            onClose(false);
        }, 3000);
    };

    return (
        <div>
            <div className="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-40">
                <div className="bg-white p-6 rounded-lg w-[900px]">
                    <h2 className="text-3xl font-bold text-center text-deepForestGreen mb-12">INPUT NILAI</h2>
                    <div className="space-y-4">
                        <div className="grid grid-cols-9 gap-4">
                            {[{ label: "TP", value: tp, setValue: setTp },
                            { label: "TA", value: ta, setValue: setTa },
                            { label: "D1", value: d1, setValue: setD1 },
                            { label: "D2", value: d2, setValue: setD2 },
                            { label: "D3", value: d3, setValue: setD3 },
                            { label: "D4", value: d4, setValue: setD4 },
                            { label: "L1", value: l1, setValue: setL1 },
                            { label: "L2", value: l2, setValue: setL2 },
                            ].map(({ label, value, setValue }) => (
                                <div key={label}>
                                    <label className="block mb-2 font-semibold">{label}</label>
                                    <input
                                        type="number"
                                        value={value}
                                        onChange={(e) => setValue(Number(e.target.value))}
                                        className="w-full p-2 border border-gray-300 rounded-md"
                                    />
                                </div>
                            ))}
                            <div>
                                <label className="block mb-2 font-semibold">Total Nilai</label>
                                <input
                                    type="number"
                                    value={totalNilai}
                                    readOnly
                                    className="w-full p-2 border border-gray-300 rounded-md"
                                />
                            </div>
                        </div>
                        <div>
                            <label className="block mb-2 font-semibold">Feedback Praktikan</label>
                            <textarea
                                value={feedback}
                                readOnly
                                placeholder="ini feedback dari praktikan"
                                className="w-full p-2 border border-gray-300 rounded-md bg-gray-100 focus:border-darkOliveGreen focus:outline-none"
                                rows="4"
                            />
                        </div>

                    </div>
                    <div className="mt-6 flex justify-between">
                        <button
                            onClick={handleOpenModal}
                            className="px-4 py-2 bg-darkBrown font-semibold text-white rounded-md"
                        >
                            Nilai TP
                        </button>
                        <div className="space-x-4">
                            <button
                                onClick={onClose}
                                className="px-4 py-2 bg-fireRed hover:bg-softRed font-semibold text-white rounded-md"
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
            </div>
            {isModalVisible && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-4 w-80 shadow-lg text-center">
                        <h3 className="text-lg font-semibold">Berhasil Disimpan</h3>
                        <p className="text-gray-500 mt-2">Nilai telah berhasil disimpan.</p>
                    </div>
                </div>
            )}

            {isModalOpen && <ModalJawabanTP onClose={handleCloseModal} />}
        </div>
    );
}
