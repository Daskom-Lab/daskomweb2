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

    const dataRoles = [...Array(10)].map((_, index) => ({
        no: index + 1,
        nama: `Nama ${index + 1}`,
        kode: `Kode ${index + 1}`,
        role: `Role ${index + 1}`,
    }));

    return (
        <div className="mt-5">
            {/* Header dengan div */}
            <div className="bg-deepForestGreen rounded-lg py-2 px-2 mb-2">
                <div className="grid grid-cols-6 gap-1">
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">No</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Nama</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Kode</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Role</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Set Role</h1>
                    </div>
                    <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
                        <h1 className="font-bold text-white text-center">Review</h1>
                    </div>
                </div>
            </div>

            {/* Kontainer Tabel Scrollable */}
            <div className="overflow-x-auto max-h-96">
                <div className="">
                    {dataRoles.map((item, index) => (
                        <div
                            key={index}
                            className="grid grid-cols-6 gap-1 text-darkBrown bg-white border border-forestGreen py-1 px-2 mb-2 rounded-lg"
                        >
                            {/* Kolom Data */}
                            <div className="flex items-center justify-center h-full py-1 px-2 ">{item.no}</div>
                            <div className="flex items-center justify-center h-full py-1 px-2 ">{item.nama}</div>
                            <div className="flex items-center justify-center h-full py-1 px-2 ">{item.kode}</div>
                            <div className="flex items-center justify-center h-full py-1 px-2 ">{item.role}</div>
                            <div className="flex items-center justify-center h-full py-1 px-2 ">
                                <button className="px-2  bg-darkBrown text-white rounded-md">
                                    Aslab (SK)
                                </button>
                            </div>
                            <div className="flex items-center justify-center h-full py-1 px-2 ">
                                <div className="flex justify-center items-center space-x-2">
                                    {/* Tombol Hapus */}
                                    <button
                                        onClick={handleOpenModalDelete}
                                        className="flex justify-center items-center p-2 text-fireRed font-semibold hover:underline transition-all"
                                    >
                                        <img className="w-5" src={trashIcon} alt="delete icon" />
                                        Delete
                                    </button>

                                    {/* Tombol Edit */}
                                    <button
                                        onClick={handleOpenModalEdit}
                                        className="flex justify-center items-center p-2 text-darkBrown font-semibold hover:underline transition-all"
                                    >
                                        <img className="w-5" src={editIcon} alt="edit icon" />
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>

            {/* Modal */}
            {isModalOpenDelete && (
                <ModalDeleteRole
                    onClose={handleCloseModalDelete}
                    onConfirm={handleConfirmDelete}
                    message={message}
                />
            )}
            {isModalOpenEdit && <ModalEditRole onClose={handleCloseModalEdit} />}
        </div>
    );
}
