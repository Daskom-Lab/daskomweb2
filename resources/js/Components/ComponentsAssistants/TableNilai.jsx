import { useState } from "react";
import ModalInputNilai from "./ModalInputNilai";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function TableManageNilai() {
    const [isModalOpenInput, setIsModalOpenInput] = useState(false);
    const [message, setMessage] = useState("");
    const [nilaiDimasukkan, setNilaiDimasukkan] = useState(Array(10).fill(false));

    const handleOpenModalInput = () => {
        setIsModalOpenInput(true);
    };

    const handleCloseModalInput = () => {
        setIsModalOpenInput(false);
    };

    const handleConfirmInput = (index) => {
        setNilaiDimasukkan((prev) => {
            const newArray = [...prev];
            newArray[index] = true;
            return newArray;
        });
        setMessage("Nilai berhasil dimasukkan");
    };

    return (
        <div className="mt-5">
            {/* Header dengan div */}
            <div className="bg-deepForestGreen rounded-lg py-2 px-2 mb-2">
                <div className="grid grid-cols-5 gap-1">
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Tanggal</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">NIM</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Kelas</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Waktu</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Review</h1>
                    </div>
                </div>
            </div>

            {/* Kontainer untuk tabel scrollable */}
            <div className="overflow-x-auto max-h-96">
                {[...Array(10)].map((_, index) => (
                    <div
                        key={index}
                        className="grid grid-cols-5 gap-1 bg-white border border-forestGreen py-1 px-2 mb-2 rounded-lg"
                    >
                        <div className="flex items-center justify-center h-full py-1 px-2">29/06/2{index + 1}</div>
                        <div className="flex items-center justify-center h-full py-1 px-2">NIM{index + 1}</div>
                        <div className="flex items-center justify-center h-full py-1 px-2">Kelas {index + 1}</div>
                        <div className="flex items-center justify-center h-full py-1 px-2">08:00</div>
                        <div className="flex justify-center items-center space-x-2">
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
                            <input
                                type="checkbox"
                                checked={nilaiDimasukkan[index]}
                                readOnly
                                className={`w-6 h-6 border-2 rounded-md ${nilaiDimasukkan[index] ? 'bg-deepForestGreen' : 'bg-fireRed'}`}
                            />
                        </div>
                    </div>
                ))}
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