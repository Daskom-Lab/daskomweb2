import { useState } from "react";
import closeIcon from "../../../assets/modal/iconClose.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function ModalActiveTP({ onClose }) {
    const [config, setConfig] = useState({
        PengenalanAlgoritmanDanPemrograman: false,
        SintaksDasarDanStrukturProgramC: false,
        KontrolAlurProgram: false,
        LoopingDanIterasi: false,
        Fungsi: false,
        Modul06: false,
        Modul07: false,
        Modul08: false,
        Modul09: false,
        Modul10: false,
        Modul01Eng: false,
        Modul02Eng: false,
        Modul03Eng: false,
        Modul04Eng: false,
        Modul05Eng: false,
        Modul06Eng: false,
        Modul07Eng: false,
        Modul08Eng: false,
        Modul09Eng: false,
        Modul10Eng: false,
    });

    const [showSuccess, setShowSuccess] = useState(false);

    const toggleSwitch = (key) => {
        setConfig((prevConfig) => ({
            ...prevConfig,
            [key]: !prevConfig[key],
        }));
    };

    const handleSave = () => {
        setShowSuccess(true);
        setTimeout(() => {
            setShowSuccess(false);
            onClose();
        }, 3000);
    };

    const configKeys = Object.keys(config);
    const group1 = configKeys.filter((_, index) => index % 2 === 0);
    const group2 = configKeys.filter((_, index) => index % 2 === 1);

    return (
        <>
            {/* Modal Utama */}
            <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div className="bg-white rounded-lg p-6 w-[1000px] shadow-lg relative">
                    {/* Header */}
                    <div className="flex justify-between items-center mb-4 border-b border-gray-300">
                        <h2 className="text-xl font-semibold flex items-center gap-2">
                            <img className="w-8" src={editIcon} alt="praktikum" /> Tugas Pendahuluan
                        </h2>
                        {/* Tombol X untuk tutup */}
                        <button
                            onClick={onClose}
                            className="absolute top-2 right-2 flex justify-center items-center"
                        >
                            <img className="w-9" src={closeIcon} alt="closeIcon" />
                        </button>
                    </div>

                    {/* Switch Options - Scrollable Table */}
                    <div className="max-h-[300px] overflow-y-auto">
                        <table className="w-full border-collapse">
                            <thead>
                                <tr>
                                    <th className="text-left py-2 px-4 border-b">Module</th>
                                    <th className="text-left py-2 px-4 border-b">Status</th>
                                    <th className="text-left py-2 px-4 border-b">Module</th>
                                    <th className="text-left py-2 px-4 border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {group1.map((key, index) => (
                                    <tr key={key} className="even:bg-gray-100">
                                        {/* Group 1 */}
                                        <td className="py-2 px-4 capitalize">
                                            {key.replace(/([A-Z])/g, " $1")}
                                        </td>
                                        <td className="py-2 px-4">
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
                                                    className={`w-20 h-8 flex items-center rounded-full px-2 transition-all duration-300 ${config[key] ? "bg-deepForestGreen" : "bg-fireRed"
                                                        }`}
                                                >
                                                    <div
                                                        className={`w-6 h-6 bg-white rounded-full shadow-md transform transition-transform ${config[key] ? "translate-x-10" : "translate-x-0"
                                                            }`}
                                                    ></div>
                                                </div>
                                            </label>
                                        </td>

                                        {/* Group 2 */}
                                        <td className="py-2 px-4 capitalize">
                                            {group2[index]
                                                ? group2[index].replace(/([A-Z])/g, " $1")
                                                : "-"}
                                        </td>
                                        <td className="py-2 px-4">
                                            {group2[index] && (
                                                <label className="inline-flex items-center cursor-pointer">
                                                    <span className="text-xs font-bold text-gray-700 mr-2">
                                                        {config[group2[index]] ? "ON" : "OFF"}
                                                    </span>
                                                    <input
                                                        type="checkbox"
                                                        checked={config[group2[index]]}
                                                        onChange={() => toggleSwitch(group2[index])}
                                                        className="hidden"
                                                    />
                                                    <div
                                                        className={`w-20 h-8 flex items-center rounded-full px-2 transition-all duration-300 ${config[group2[index]] ? "bg-deepForestGreen" : "bg-fireRed"
                                                            }`}
                                                    >
                                                        <div
                                                            className={`w-6 h-6 bg-white rounded-full shadow-md transform transition-transform ${config[group2[index]]
                                                                    ? "translate-x-10"
                                                                    : "translate-x-0"
                                                                }`}
                                                        ></div>
                                                    </div>
                                                </label>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* Save Button */}
                    <div className="flex justify-center mt-5">
                        <button
                            onClick={handleSave}
                            className="w-1/4 py-2 bg-deepForestGreen text-white font-semibold rounded-lg shadow-md hover:bg-darkGreen transition"
                        >
                            Simpan
                        </button>
                    </div>

                </div>
            </div>

            {/* Modal Notifikasi Berhasil */}
            {showSuccess && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                    <div className="bg-white rounded-lg p-4 w-80 shadow-lg text-center">
                        <h3 className="text-xl font-bold text-deepForestGreen">Berhasil Disimpan</h3>
                        <p className="text-darkBrown-500 mt-2">Konfigurasi telah berhasil disimpan.</p>
                    </div>
                </div>
            )}
        </>
    );
}
