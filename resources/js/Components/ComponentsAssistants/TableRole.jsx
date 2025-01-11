import { useState } from "react";

import ModalDeleteRole from "./ModalDeleteRole";
import ModalEditRole from "./ModalEditRole";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function TableManageRole() {
    const [isModalOpenDelete, setIsModalOpenDelete] = useState(false);
    const [isModalOpenEdit, setIsModalOpenEdit] = useState(false);
    const [message, setMessage] = useState("");

    const handleOpenModalDelete = () => {
        setIsModalOpenDelete(true);
    };

    const handleCloseModalDelete = () => {
        setIsModalOpenDelete(false);
    };

    const handleOpenModalEdit = () => {
        setIsModalOpenEdit(true);
    };

    const handleCloseModalEdit = () => {
        setIsModalOpenEdit(false);
    };

    const handleConfirmDelete = () => {
        setMessage("Role berhasil dihapus");
    };

    return (
        <div className="mt-8">
            {/* Scrollable table container */}
            <div className="overflow-x-auto max-h-96">
                <table className="min-w-full table-auto border-collapse border border-forestGreen">
                    <thead>
                        <tr className="bg-deepForestGreen text-xl font-bold text-center text-white">
                            <th className="py-2 px-4 border-b">No</th>
                            <th className="py-2 px-4 border-b">Nama</th>
                            <th className="py-2 px-4 border-b">Kode</th>
                            <th className="py-2 px-4 border-b">Role</th>
                            <th className="py-2 px-4 border-b">Set Role</th>
                            <th className="py-2 px-4 border-b">Review</th>
                        </tr>
                    </thead>
                    <tbody className="bg-softIvory">
                        {[...Array(10)].map((_, index) => (
                            <tr key={index} className="text-darkBrown">
                                <td className="py-2 px-4 border-b text-center">{index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">Nama {index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">Kode {index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">Role {index + 1}</td>
                                <td className="py-2 px-4 border-b text-center">
                                    <button className="px-3 py-1 bg-darkBrown text-white font-semibold rounded-md shadow transition duration-300">
                                        Fitur Aslab (Regular)
                                    </button>
                                </td>
                                <td className="py-2 px-4 border-b text-center">
                                    <div className="flex justify-center items-center space-x-2">
                                        {/* Delete button */}
                                        <button
                                            onClick={handleOpenModalDelete}
                                            className="flex justify-center items-center p-2 text-fireRed font-semibold hover:underline transition-all"
                                        >
                                            <img
                                                className="w-6"
                                                src={trashIcon}
                                                alt="delete icon"
                                            />
                                            Delete
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
            {isModalOpenDelete && (
                <ModalDeleteRole
                    onClose={handleCloseModalDelete}
                    onConfirm={handleConfirmDelete}
                    message={message}
                />
            )}

            {isModalOpenEdit && (
                <ModalEditRole onClose={handleCloseModalEdit} />
            )}
        </div>
    );
}
