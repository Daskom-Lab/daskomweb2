import { useState } from "react";
import ModalLaporan from "./ModalLaporan";

export default function TableHistory() {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => {
        setIsModalOpen(true);
    };

    const handleCloseModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className="mt-5">
            {/* Header dengan div */}
            <div className="bg-deepForestGreen rounded-lg py-2 px-2 mb-2">
                <div className="grid grid-cols-4 gap-1">
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Tanggal</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Modul</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Kelas</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Review</h1>
                    </div>
                </div>
            </div>

            {/* Kontainer untuk scroll tabel */}
            <div className="overflow-x-auto max-h-96">
                <div className="grid grid-cols-4 gap-1 bg-softIvory">
                    {[...Array(10)].map((_, index) => (
                        <>
                            <div
                                key={`tanggal-${index}`}
                                className="flex items-center justify-center h-full py-2 px-4 text-darkBrown border border-forestGreen"
                            >
                                29/06/24, 11:34:57
                            </div>
                            <div
                                key={`modul-${index}`}
                                className="flex items-center justify-center h-full py-2 px-4 text-darkBrown border border-forestGreen"
                            >
                                Pengantar Alogitma dan Pemrograman
                            </div>
                            <div
                                key={`kelas-${index}`}
                                className="flex items-center justify-center h-full py-2 px-4 text-darkBrown border border-forestGreen"
                            >
                                [ TF-46-04 ] Sabtu 2
                            </div>
                            <div
                                key={`review-${index}`}
                                className="flex items-center justify-center h-full py-2 px-2 border border-forestGreen"
                            >
                                <button
                                    onClick={handleOpenModal}
                                    className="flex justify-center items-center w-8 h-8 bg-forestGreen text-white rounded hover:bg-deepForestGreen transition-all"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        strokeWidth="2"
                                        stroke="currentColor"
                                        className="w-4 h-4"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </>
                    ))}
                </div>
            </div>

            {/* Modal Komponen */}
            {isModalOpen && <ModalLaporan onClose={handleCloseModal} />}
        </div>
    );
}
