import { useState } from "react";
import ModalDeletePlottingan from "./ModalDelatePlottingan";
import ModalEditPlotting from "./ModalEditPlottingan";
import ModalPlotTeam from "./ModalPlotTeam";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function TablePlottingan() {
    const [isModalOpenDelate, setIsModalOpenDelate] = useState(false);
    const [isModalOpenEdit, setIsModalOpenEdit] = useState(false);
    const [isModalOpenPlot, setIsModalOpenPlot] = useState(false);
    const [message, setMessage] = useState("");

    const handleOpenModalDelate = () => {
        setIsModalOpenDelate(true);
    };

    const handleCloseModalDelate = () => {
        setIsModalOpenDelate(false);
    };

    const handleOpenModalEdit = () => {
        setIsModalOpenEdit(true);
    };

    const handleCloseModalEdit = () => {
        setIsModalOpenEdit(false);
    };

    const handleConfirmDelete = () => {
        setMessage("Shift berhasil dihapus");
    };

    const handleOpenModalPlot = () => {
        setIsModalOpenPlot(true);
    };

    const handleCloseModalPlot = () => {
        setIsModalOpenPlot(false);
    };
    return (
        <div className="mt-5">
            {/* Header dengan div */}
            <div className="bg-deepForestGreen rounded-lg py-2 px-2 mb-2">
                <div className="grid grid-cols-5 gap-1">
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Kelas</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Hari</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Shift</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Kelompok</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Review</h1>
                    </div>
                </div>
            </div>

            {/* Kontainer untuk scroll tabel */}
            <div className="overflow-x-auto max-h-96">
                <div className="grid grid-cols-5 gap-1 bg-softIvory">
                    {[...Array(10)].map((_, index) => (
                        <>
                            <div
                                key={`tanggal-${index}`}
                                className="flex items-center justify-center h-full py-1 px-4 text-darkBrown border border-forestGreen"
                            >
                                TT-46-09
                            </div>
                            <div
                                key={`modul-${index}`}
                                className="flex items-center justify-center h-full py-1 px-4 text-darkBrown border border-forestGreen"
                            >
                                Senin
                            </div>
                            <div
                                key={`kelas-${index}`}
                                className="flex items-center justify-center h-full py-1 px-4 text-darkBrown border border-forestGreen"
                            >
                                3
                            </div>
                            <div
                                key={`kelas-${index}`}
                                className="flex items-center justify-center h-full py-1 px-4 text-darkBrown border border-forestGreen"
                            >
                                12
                            </div>
                            <div
                                key={`review-${index}`}
                                className="flex items-center justify-center h-full py-1 px-2 border border-forestGreen space-x-2"
                            >
                                {/* Delete button */}
                                <button
                                    onClick={handleOpenModalDelate}
                                    className="flex justify-center items-center p-1 border-2 border-fireRed rounded"
                                >
                                    <img
                                        className="w-4"
                                        src={trashIcon}
                                        alt="delete icon"
                                    />
                                </button>

                                {/* Edit button */}
                                <button
                                    onClick={handleOpenModalEdit}
                                    className="flex justify-center items-center p-1 border-2 border-darkBrown rounded"
                                >
                                    <img
                                        className="w-4"
                                        src={editIcon}
                                        alt="edit icon"
                                    />
                                </button>
                                {/* plot button */}
                                <button
                                    onClick={handleOpenModalPlot}
                                    className="flex justify-center items-center p-1 border-2 border-deepForestGreen text-deepForestGreen font-semibold rounded"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        strokeWidth="2"
                                        stroke="currentColor"
                                        className="w-4"
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

            {/* Modal components */}
            {isModalOpenDelate && (
                <ModalDeletePlottingan
                    onClose={handleCloseModalDelate}
                    onConfirm={handleConfirmDelete}
                    message={message}
                />
            )}

            {isModalOpenEdit && (
                <ModalEditPlotting onClose={handleCloseModalEdit} />
            )}
            {isModalOpenPlot && (
                <ModalPlotTeam onClose={handleCloseModalPlot} />
            )}
        </div>
    );
}
