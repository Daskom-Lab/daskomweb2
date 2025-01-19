import { useState } from "react";
import closeIcon from "../../../assets/modal/iconClose.svg"

export default function ModalEditProfile({ isOpen, onClose }) {
    const [isSuccessModalOpen, setSuccessModalOpen] = useState(false);
    const [avatar, setAvatar] = useState(null); // State untuk menyimpan avatar yang diunggah

    const handleSave = () => {
        setSuccessModalOpen(true);
        setTimeout(() => {
            setSuccessModalOpen(false);
            onClose();
        }, 3000);
    };

    const handleAvatarUpload = (e) => {
        const file = e.target.files[0];
        if (file) {
            setAvatar(URL.createObjectURL(file)); // Preview gambar
        }
    };

    const handleDeleteAvatar = () => {
        setAvatar(null); // Hapus avatar
    };

    if (!isOpen) return null;

    return (
        <>
            {/* Modal Edit Profile */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div className="bg-white w-[550px] p-6 rounded-lg shadow-lg relative">
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 flex justify-center items-center"
                    >        
                        <img className="w-9" src={closeIcon} alt="closeIcon" />
                    </button>

                    <form>
                        <div className="flex gap-4 justify-between p-4">
                            <div>
                                {/* WhatsApp */}
                                <div className="mb-4">
                                    <label className="block text-black font-bold mb-1">
                                        WhatsApp:
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full border rounded p-2"
                                        placeholder="WhatsApp"
                                    />
                                </div>
                                {/* ID Line */}
                                <div className="mb-4">
                                    <label className="block text-black font-bold mb-1">
                                        ID Line:
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full border rounded p-2"
                                        placeholder="ID Line"
                                    />
                                </div>
                                {/* Instagram */}
                                <div className="mb-4">
                                    <label className="block text-black font-bold mb-1">
                                        Instagram:
                                    </label>
                                    <input
                                        type="text"
                                        className="w-full border rounded p-2"
                                        placeholder="Instagram"
                                    />
                                </div>
                            </div>
                            {/* Avatar */}
                            <div className="flex flex-col items-center mb-4 mr-12 mt-6">
                                <div className="bg-gray-100 w-32 h-32 rounded-full flex justify-center items-center overflow-hidden mb-4">
                                    {avatar ? (
                                        <img
                                            src={avatar}
                                            alt="Avatar"
                                            className="w-full h-full object-cover"
                                        />
                                    ) : (
                                        <span className="text-gray-400 text-4xl">👤</span>
                                    )}
                                </div>
                                <div className="flex flex-col items-center gap-2">
                                    <label
                                        htmlFor="avatarUpload"
                                        className="px-4 py-1 bg-forestGreen text-white font-semibold text-md rounded-sm shadow-md cursor-pointer text-center"
                                    >
                                        Change Avatar
                                    </label>
                                    <input
                                        id="avatarUpload"
                                        type="file"
                                        className="hidden"
                                        accept="image/*"
                                        onChange={handleAvatarUpload}
                                    />
                                    <button
                                        type="button"
                                        className="px-5 py-1 bg-lightGray text-white font-semibold text-md rounded-sm shadow-md"
                                        onClick={handleDeleteAvatar}
                                    >
                                        Delete Avatar
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* About Me */}
                        <div className="mb-4">
                            <label className="block text-black font-bold mb-1">
                                About Me:
                            </label>
                            <textarea
                                className="w-full border rounded p-2"
                                placeholder="Description"
                                rows="4"
                            ></textarea>
                        </div>

                        {/* Save Button */}
                        <div className="flex justify-center">
                            <button
                                type="button"
                                className="px-32 py-1 bg-forestGreen hover:bg-darkGreen text-white font-semibold rounded-lg shadow-md shadow-darkGreen"
                                onClick={handleSave}
                            >
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {/* Modal Berhasil Disimpan */}
            {isSuccessModalOpen && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white w-[300px] p-4 rounded-lg shadow-lg text-center">
                        <h3 className="text-lg font-bold text-forestGreen">
                            Berhasil Disimpan!
                        </h3>
                    </div>
                </div>
            )}
        </>
    );
}
