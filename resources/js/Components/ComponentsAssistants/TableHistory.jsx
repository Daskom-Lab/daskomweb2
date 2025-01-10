import ModalLaporan from "./ModalLaporan";
import { useState } from "react";

export default function TableHistory() {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => {
        setIsModalOpen(true);
    };

    const handleCloseModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className="mt-8">
            {/* Kontainer untuk scroll tabel */}
            <div className="overflow-x-auto max-h-96"> {/* Menambahkan max-h-96 di sini untuk memberikan batas tinggi */}
                <table className="min-w-full table-auto border-collapse border border-forestGreen">
                    <thead>
                        <tr className="bg-deepForestGreen text-xl font-bold text-center text-white">
                            <th className="py-2 px-7 border-b">Tanggal</th>
                            <th className="py-2 px-7 border-b">Modul</th>
                            <th className="py-2 px-7 border-b">Kelas</th>
                            <th className="py-2 px-7 border-b">Review</th>
                        </tr>
                    </thead>
                    <tbody className="bg-softIvory">
                        {[...Array(10)].map((_, index) => ( // Ubah jumlah baris sesuai kebutuhan
                            <tr key={index} className="text-darkBrown">
                                <td className="py-2 px-4 border-b text-center">29/06/24, 11:34:57</td>
                                <td className="py-2 px-4 border-b">Pengantar Alogitma dan Pemrograman</td>
                                <td className="py-2 px-4 border-b text-center">[ TF-46-04 ] Sabtu 2</td>
                                <td className="py-2 px-4 border-b text-center">
                                    <div className="flex justify-center items-center">
                                        <button
                                            onClick={handleOpenModal}
                                            className="flex justify-center items-center p-2 bg-forestGreen text-white rounded hover:bg-deepForestGreen transition-all"
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
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {/* Modal Komponen */}
            {isModalOpen && <ModalLaporan onClose={handleCloseModal} />}
        </div>
    );
}
