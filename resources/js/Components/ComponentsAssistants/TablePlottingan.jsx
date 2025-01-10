import { useState } from "react";
import ModalDeletePlottingan from "./ModalDelatePlottingan";
import ModalEditPlotting from "./ModalEditPlottingan";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function TablePlottingan() {
    const [isModalOpenDelate, setIsModalOpenDelate] = useState(false);
    const [isModalOpenEdit, setIsModalOpenEdit] = useState(false); // State for edit modal
    const [message, setMessage] = useState(""); // To display success message

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
        setMessage("Shift berhasil dihapus"); // Set success message
    };

    return (
        <div className="mt-8">
            {/* Scrollable table container */}
            <div className="overflow-x-auto max-h-96">
                <table className="min-w-full table-auto border-collapse border border-forestGreen">
                    <thead>
                        <tr className="bg-deepForestGreen text-xl font-bold text-center text-white">
                            <th className="py-2 px-7 border-b">Kelas</th>
                            <th className="py-2 px-7 border-b">Hari</th>
                            <th className="py-2 px-7 border-b">Shift</th>
                            <th className="py-2 px-7 border-b">Kelompok</th>
                            <th className="py-2 px-7 border-b">Review</th>
                        </tr>
                    </thead>
                    <tbody className="bg-softIvory">
                        {[...Array(10)].map((_, index) => (
                            <tr key={index} className="text-darkBrown">
                                <td className="py-2 px-4 border-b text-center">TE-46-02</td>
                                <td className="py-2 px-4 border-b text-center">Senin</td>
                                <td className="py-2 px-4 border-b text-center">1</td>
                                <td className="py-2 px-4 border-b text-center">14</td>
                                <td className="py-2 px-4 border-b text-center">
                                    <div className="flex justify-center items-center space-x-2">
                                        {/* Delete button */}
                                        <button
                                            onClick={handleOpenModalDelate}
                                            className="flex justify-center items-center p-2 text-fireRed font-semibold hover:underline transition-all"
                                        >
                                            <img
                                                className="w-6"
                                                src={trashIcon}
                                                alt="delete icon"
                                            />
                                            Delate
                                        </button>

                                        {/* Edit button */}
                                        <button
                                            onClick={handleOpenModalEdit} 
                                            className="flex justify-center items-center p-2 text-darkBrown font-semibold hover:underline transition-all"
                                        >
                                            <img
                                                className="w-6"
                                                src={editIcon}
                                                alt="edit icon"
                                            />
                                            Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
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
        </div>
    );
}
