import React, { useState } from "react";
import closeIcon from "../../../assets/modal/iconClose.svg"

export default function ModalEditRole({ onClose }) {
    const roles = ["Aslab(SK)", "Aslab(R)", "ATC", "HRD", "DDC", "MLC", "CMD", "RDC"];
    const [selectedRole, setSelectedRole] = useState("");
    const [isSuccessModalOpen, setIsSuccessModalOpen] = useState(false);

    const handleRoleChange = (event) => {
        setSelectedRole(event.target.value);
    };

    const handleSave = () => {
        if (selectedRole) {
            setIsSuccessModalOpen(true);

            setTimeout(() => {
                setIsSuccessModalOpen(false);
                onClose();
            }, 3000);
        }
    };

    return (
        <div>
            {/* Modal Edit Role */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                <div className="bg-white p-6 rounded-lg shadow-xl w-[430px] text-center relative">
                    {/* Header */}
                    <div className="flex justify-between items-center mb-6 border-b border-deepForestGreen">
                        <h2 className="text-2xl text-center font-bold text-darkGreen">Upgrade Role</h2>
                        {/* Tombol X untuk tutup */}
                        <button
                            onClick={onClose}
                            className="absolute top-2 right-2 flex justify-center items-center"
                        >
                            <img className="w-9" src={closeIcon} alt="closeIcon" />
                        </button>
                    </div>

                    {/* List Role dalam Grid 3 kolom */}
                    <div className="grid grid-cols-3 gap-4 mt-4 text-left">
                        {roles.map((role, index) => (
                            <label key={index} className="flex items-center space-x-2">
                                <input
                                    type="radio"
                                    name="role"
                                    value={role}
                                    checked={selectedRole === role}
                                    onChange={handleRoleChange}
                                    className="h-5 w-5 text-deepForestGreen"
                                />
                                <span className="text-lg">{role}</span>
                            </label>
                        ))}
                    </div>

                    {/* Tombol Simpan */}
                    <div className="mt-6 flex justify-center">
                        <button
                            onClick={handleSave}
                            className="text-md font-bold text-white bg-darkGreen hover:bg-softGreen rounded-md px-6 py-1"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            {/* Modal Konfirmasi */}
            {isSuccessModalOpen && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-softGray p-6 rounded-lg shadow-xl w-96 text-center relative">
                        <h3 className="text-2xl font-bold text-deepForestGreen mt-2">
                            Role Berhasil di Upgrade
                        </h3>
                    </div>
                </div>
            )}
        </div>
    );
}
