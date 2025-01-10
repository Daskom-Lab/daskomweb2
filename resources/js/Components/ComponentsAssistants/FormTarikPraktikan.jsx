import React, { useState } from 'react';

export default function FormTarikPraktikan() {
    const [nim, setNim] = useState('');
    const [module, setModule] = useState('');
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modalMessage, setModalMessage] = useState('');
    const [isSuccess, setIsSuccess] = useState(false);

    const handleSubmit = () => {
        if (!nim || !module) {
            setModalMessage('Harap isi semua kolom, jangan tertinggal!');
            setIsSuccess(false);
            setIsModalOpen(true);
            return;
        }

        setModalMessage('Data praktikan berhasil ditarik');
        setIsSuccess(true);
        setIsModalOpen(true);

        console.log('NIM:', nim);
        console.log('Modul:', module);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className="bg-softIvory p-6 rounded shadow-lg shadow-deepForestGreen w-[750px]">
            <h2 className="text-xl font-bold mb-6 text-start text-black">Tarik Praktikan</h2>
            <div className="flex items-center gap-4">
                {/* Input NIM */}
                <div className="flex-1">
                    <label htmlFor="nim" className="block text-sm font-medium mb-2">
                        NIM
                    </label>
                    <input
                        type="text"
                        id="nim"
                        value={nim}
                        onChange={(e) => setNim(e.target.value)}
                        placeholder="1101223083"
                        className="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    />
                </div>
                {/* Dropdown Modul */}
                <div className="flex-1">
                    <label htmlFor="module" className="block text-sm font-medium mb-2">
                        Modul
                    </label>
                    <select
                        id="module"
                        value={module}
                        onChange={(e) => setModule(e.target.value)}
                        className="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                        <option value="" disabled>
                            Pilih Modul
                        </option>
                        <option value="Modul 1">Modul 1</option>
                        <option value="Modul 2">Modul 2</option>
                        <option value="Modul 3">Modul 3</option>
                        <option value="Modul 4">Modul 4</option>
                        <option value="Modul 5">Modul 5</option>
                        <option value="Modul 6">Modul 6</option>
                    </select>
                </div>
                {/* Tombol Tarik */}
                <div className="flex-shrink-0 mt-6">
                    <button
                        onClick={handleSubmit}
                        className="h-10 px-6 bg-deepForestGreen text-white font-semibold rounded hover:bg-darkGreen transition duration-200"
                    >
                        Tarik
                    </button>
                </div>
            </div>

            {/* Modal */}
            {isModalOpen && (
                <div className="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                    <div className="bg-white p-8 rounded shadow-lg w-[30%]">
                        <h3 className="text-2xl font-bold mb-4 text-center">
                            {isSuccess ? 'Berhasil Ditambahkan' : 'Gagal Ditambahkan'}
                        </h3>
                        <p className="text-center text-md mt-6">{modalMessage}</p>
                        <div className="mt-6 text-center">
                            <button
                                onClick={closeModal}
                                className="px-4 py-1 bg-deepForestGreen text-white rounded hover:bg-darkGreen"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
