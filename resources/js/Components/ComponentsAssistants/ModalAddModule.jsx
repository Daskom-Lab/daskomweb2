import { useState } from "react";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";

export default function ButtonAddModule({ onClose }) {
    const [showSuccessModal, setShowSuccessModal] = useState(false);
    const [points, setPoints] = useState(["", "", ""]); // batas hanya 3 poin
    const [link1, setLink1] = useState(""); // link ppt
    const [link2, setLink2] = useState(""); // link ytb
    const [link3, setLink3] = useState(""); // link modul
    const [title, setTitle] = useState(""); // judul
    const [isSwitchOn, setIsSwitchOn] = useState(false);

    const handleSave = () => {
        setShowSuccessModal(true);

        setTimeout(() => {
            setShowSuccessModal(false);
            onClose();
        }, 3000);
    };

    const handlePointChange = (index, value) => {
        const newPoints = [...points];
        newPoints[index] = value;
        setPoints(newPoints);
    };

    const handleAddPoint = () => {
        if (points.length < 3) {
            setPoints([...points, ""]);
        }
    };

    const handleRemovePoint = (index) => {
        if (points.length > 1) {
            const newPoints = points.filter((_, i) => i !== index);
            setPoints(newPoints);
        }
    };

    const toggleSwitch = () => {
        setIsSwitchOn(!isSwitchOn);
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            {/* Modal Utama */}
            <div className="bg-white rounded-lg p-6 w-[700px] shadow-lg relative overflow-y-auto max-h-[80vh]">
                {/* Header */}
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-2xl font-bold text-deepForestGreen">Tambah Modul</h2>
                    {/* Tombol X untuk tutup */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-7 flex justify-center items-center"
                    >
                        ×
                    </button>
                </div>

                {/* Input Judul Modul */}
                <div className="mb-4">
                    <label htmlFor="judul" className="block text-darkGreen text-md font-medium">
                        Judul Modul
                    </label>
                    <input
                        id="judul"
                        type="text"
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                        placeholder="Masukkan judul modul"
                        value={title}
                        onChange={(e) => setTitle(e.target.value)}
                    />
                </div>

                {/* Input Poin-poin Pembelajaran */}
                <div className="mb-4">
                    <label className="block text-darkGreen text-md font-medium">Poin-poin Pembelajaran</label>
                    {points.map((point, index) => (
                        <div key={index} className="flex items-center gap-2 mb-2">
                            <input
                                type="text"
                                className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                                placeholder={`Poin ${index + 1}`}
                                value={point}
                                onChange={(e) => handlePointChange(index, e.target.value)}
                            />
                            {points.length > 1 && (
                                <button
                                    type="button"
                                    onClick={() => handleRemovePoint(index)}
                                >
                                    <img
                                        className="w-6"
                                        src={trashIcon}
                                        alt="delete icon"
                                    />
                                </button>
                            )}
                        </div>
                    ))}
                    {points.length < 3 && (
                        <button
                            type="button"
                            onClick={handleAddPoint}
                            className="text-deepForestGreen hover:text-darkGreen hover:underline"
                        >
                            Tambah Poin
                        </button>
                    )}
                </div>

                {/* Input Link 1 */}
                <div className="mb-4">
                    <label htmlFor="link1" className="block text-green-700  text-md font-medium">
                        Link PPT
                    </label>
                    <input
                        id="link1"
                        type="url"
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                        placeholder="Masukkan link PPT"
                        value={link1}
                        onChange={(e) => setLink1(e.target.value)}
                    />
                </div>

                {/* Input Link 2 */}
                <div className="mb-4">
                    <label htmlFor="link2" className="block text-red-700 text-md font-medium">
                        Link Video Youtube
                    </label>
                    <input
                        id="link2"
                        type="url"
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                        placeholder="Masukkan link video youtube"
                        value={link2}
                        onChange={(e) => setLink2(e.target.value)}
                    />
                </div>

                {/* Input Link 3 */}
                <div className="mb-4">
                    <label htmlFor="link3" className="block text-blue-700 text-md font-medium">
                        Link Modul
                    </label>
                    <input
                        id="link3"
                        type="url"
                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-darkBrown focus:border-darkBrown"
                        placeholder="Masukkan modul"
                        value={link3}
                        onChange={(e) => setLink3(e.target.value)}
                    />
                </div>

                <div className="flex justify-between">
                    {/* switch isEnglish */}
                    <div className="flex items-center gap-2">
                        <label className="text-sm font-medium text-gray-700">
                            isEnglish
                        </label>
                        <div
                            onClick={toggleSwitch}
                            className={`w-10 h-5 flex items-center rounded-full p-1 cursor-pointer transition ${isSwitchOn ? "bg-deepForestGreen" : "bg-fireRed"
                                }`}
                        >
                            <div
                                className={`w-4 h-4 bg-white rounded-full shadow-md transform transition ${isSwitchOn ? "translate-x-5" : "translate-x-0"
                                    }`}
                            />
                        </div>
                    </div>

                    {/* Tombol Simpan */}
                    <div className="mt-4 text-right">
                        <button
                            onClick={onClose}
                            className="px-6 py-2 bg-gray-300 text-darkBrown font-semibold rounded-md shadow hover:bg-gray-400 transition duration-300 mr-2"
                        >
                            Batal
                        </button>
                        <button
                            onClick={handleSave}
                            className="px-6 py-2 bg-deepForestGreen text-white font-semibold rounded-md shadow hover:bg-darkGreen transition duration-300"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            {/* Modal Notifikasi */}
            {showSuccessModal && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-6 w-[400px] shadow-lg text-center">
                        <h2 className="text-xl font-bold text-darkGreen text-center p-3">
                            Modul berhasil ditambahkan!
                        </h2>
                    </div>
                </div>
            )}
        </div>
    );
}
