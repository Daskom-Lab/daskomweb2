import { useState } from "react";

import editIcon from "../../../assets/nav/Icon-Edit.svg"

export default function ModalOpenKJ({ onClose }) {
    const [config, setConfig] = useState({
        Modul01: false,
        Modul02: false,
        Modul03: false,
        Modul04: false,
        Modul05: false,
        Modul06: false,
        Modul07: false,
        Modul08: false,
        Modul09: false,
        Modul10: false,
    });

    const [showSuccess, setShowSuccess] = useState(false);

    const toggleSwitch = (key) => {
        setConfig((prevConfig) => ({
            ...prevConfig,
            [key]: !prevConfig[key],
        }));
    };

    const handleSave = () => {
        console.log("Saved configuration:", config);
        setShowSuccess(true);
        setTimeout(() => {
            setShowSuccess(false);
            onClose();
        }, 3000);
    };

    const configKeys = Object.keys(config);
    const leftKeys = configKeys.slice(0, 5);
    const rightKeys = configKeys.slice(5);

    return (
        <>
            {/* Modal Utama */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div className="bg-white rounded-lg p-6 w-[550px] shadow-lg relative">
                    {/* Header */}
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-xl font-semibold flex items-center gap-2">
                            <img
                                className="w-8"
                                src={editIcon}
                                alt="praktikum"
                            /> Configuration
                        </h2>
                        {/* Tombol X untuk tutup */}
                        <button
                            onClick={onClose}
                            className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-7 flex justify-center items-center"
                        >
                            ×
                        </button>
                    </div>

                    {/* Switch Options - Two Columns */}
                    <div className="grid grid-cols-2 gap-8">
                        {/* Left Column */}
                        <div className="space-y-4">
                            {leftKeys.map((key) => (
                                <div key={key} className="flex gap-6 items-center">
                                    <span className="capitalize">
                                        {key.replace(/([A-Z])/g, " $1")}
                                    </span>
                                    <label className="inline-flex items-center cursor-pointer">
                                        <span className="text-xs font-bold text-gray-700 mr-2">
                                            {config[key] ? "ON" : "OFF"}
                                        </span>
                                        <input
                                            type="checkbox"
                                            checked={config[key]}
                                            onChange={() => toggleSwitch(key)}
                                            className="hidden"
                                        />
                                        <div
                                            className={`w-20 h-8 flex items-center rounded-full px-2 transition-all duration-300 ${config[key] ? "bg-green-500" : "bg-redredDark"
                                                }`}
                                        >
                                            <div
                                                className={`w-6 h-6 bg-white rounded-full shadow-md transform transition-transform ${config[key] ? "translate-x-10" : "translate-x-0"
                                                    }`}
                                            ></div>
                                        </div>
                                    </label>
                                </div>
                            ))}
                        </div>
                        {/* Right Column */}
                        <div className="space-y-4">
                            {rightKeys.map((key) => (
                                <div key={key} className="flex gap-6 items-center">
                                    <span className="capitalize">
                                        {key.replace(/([A-Z])/g, " $1")}
                                    </span>
                                    <label className="inline-flex items-center cursor-pointer">
                                        <span className="text-xs font-bold text-gray-700 mr-2">
                                            {config[key] ? "ON" : "OFF"}
                                        </span>
                                        <input
                                            type="checkbox"
                                            checked={config[key]}
                                            onChange={() => toggleSwitch(key)}
                                            className="hidden"
                                        />
                                        <div
                                            className={`w-20 h-8 flex items-center rounded-full px-2 transition-all duration-300 ${config[key] ? "bg-green-500" : "bg-redredDark"
                                                }`}
                                        >
                                            <div
                                                className={`w-6 h-6 bg-white rounded-full shadow-md transform transition-transform ${config[key] ? "translate-x-10" : "translate-x-0"
                                                    }`}
                                            ></div>
                                        </div>
                                    </label>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="text-right text-sm font-semibold text-dustyBlue mt-5">
                        <span>Edit by ALL</span>
                    </div>

                    {/* Save Button */}
                    <button
                        onClick={handleSave}
                        className="mt-5 w-full py-2 bg-darkGreen text-white font-semibold rounded-lg shadow-md shadow-darkGreen hover:bg-darkGreen transition"
                    >
                        Simpan
                    </button>
                </div>
            </div>

            {/* Modal Notifikasi Berhasil */}
            {showSuccess && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-4 w-80 shadow-lg text-center">
                        <h3 className="text-lg font-semibold">Berhasil Disimpan</h3>
                        <p className="text-gray-500 mt-2">Konfigurasi telah berhasil disimpan.</p>
                    </div>
                </div>
            )}
        </>
    );
}
