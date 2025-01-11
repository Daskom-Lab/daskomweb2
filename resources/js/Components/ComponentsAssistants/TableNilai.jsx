import { useState } from "react";

import ModalInputNilai from "./ModalInputNilai";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function TableManageNilai() {
    const [isModalOpenInput, setIsModalOpenInput] = useState(false);
    const [message, setMessage] = useState("");
    const [nilaiDimasukkan, setNilaiDimasukkan] = useState(Array(10).fill(false)); // Menyimpan status input nilai

    const handleOpenModalInput = () => {
        setIsModalOpenInput(true);
    };

    const handleCloseModalInput = () => {
        setIsModalOpenInput(false);
    };

    const handleConfirmInput = (index) => {
        setNilaiDimasukkan((prev) => {
            const newArray = [...prev];
            newArray[index] = true; // Tandai nilai sudah dimasukkan
            return newArray;
        });
        setMessage("Nilai berhasil dimasukkan");
    };

    return (
        <div className="mt-8">
            {/* Scrollable table container */}
            <div className="overflow-x-auto max-h-96">
                <table className="min-w-full table-auto border-collapse border border-forestGreen">
                    <thead>
                        <tr className="bg-deepForestGreen text-xl font-bold text-center text-white">
                            <th className="py-2 px-4 border-b">Tanggal</th>
                            <th className="py-2 px-4 border-b">NIM</th>
                            <th className="py-2 px-4 border-b">Kelas</th>
                            <th className="py-2 px-4 border-b">Waktu</th>
                            <th className="py-2 px-4 border-b">Review</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white">
                        {[...Array(10)].map((_, index) => (
                            <tr key={index} className="text-darkBrown">
                                <td className="py-2 px-4 border-b text-center">2025-01-0{index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">NIM{index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">Kelas {index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">08:00</td>
                                <td className="py-2 px-4 border-b text-center">
                                    <div className="flex justify-center items-center space-x-2">
                                        {/* Edit button */}
                                        <button
                                            onClick={handleOpenModalInput}
                                            className="flex justify-center items-center p-2 text-darkBrown font-semibold hover:underline transition-all"
                                        >
                                            <img
                                                className="w-6"
                                                src={editIcon}
                                                alt="edit icon"
                                            />
                                            Input Nilai
                                        </button>

                                        {/* Status input nilai - Colored box */}
                                        <input
                                            type="checkbox"
                                            checked={nilaiDimasukkan[index]}
                                            readOnly
                                            className={`w-6 h-6 border-2 rounded-md ${nilaiDimasukkan[index] ? 'bg-deepForestGreen' : 'bg-fireRed'}`}
                                        />
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {/* Modal components */}
            {isModalOpenInput && (
                <ModalInputNilai
                    onClose={handleCloseModalInput}
                    onConfirm={handleConfirmInput}
                />
            )}
        </div>
    );
}
