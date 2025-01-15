import { useState } from "react";
import ModalDelateSoal from "./ModalDelateSoal";
import ModalEditSoalPG from "./ModalEditSoalPG";
import ModalSaveSoal from "./ModalSaveSoal";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function SoalInputPG({ tipeSoal, modul, onModalSuccess, onModalValidation, addSoal, }) {
    const [soal, setSoal] = useState([""]);
    const [pilihan, setPilihan] = useState(["", "", "", ""]);
    const [soalList, setSoalList] = useState([]);
    const [isModalOpenDelate, setIsModalOpenDelate] = useState(false);
    const [selectedNomor, setSelectedNomor] = useState(null);
    const [isModalOpenSuccess, setIsModalOpenSuccess] = useState(false);
    const [isModalOpenEdit, setIsModalOpenEdit] = useState(false);
    const [editingSoal, setEditingSoal] = useState(null);
    const [mode, setMode] = useState("text");
    const [deskripsi, setDeskripsi] = useState(["", "", ""]);
    const [soalCounter, setSoalCounter] = useState(1); // jgn di ilangin buat counter global untuk soal

    const handlePilihanChange = (index, value) => {
        const updatedPilihan = [...pilihan];
        updatedPilihan[index] = value;
        setPilihan(updatedPilihan);
    };

    const handleDeskripsiChange = (index, value) => {
        const updatedDeskripsi = [...deskripsi];
        updatedDeskripsi[index] = value;
        setDeskripsi(updatedDeskripsi);
    };

    const handleSoalChange = (index, value) => {
        const updatedSoal = [...soal];
        updatedSoal[index] = value;
        setSoal(updatedSoal);
    };

    const handleTambahSoal = () => {
        if (mode === "text" && soal.some((item) => !item)) {
            onModalValidation();
            return;
        }
        if (mode === "kode" && deskripsi.some((item) => !item)) {
            onModalValidation();
            return;
        }
        if (pilihan.some((pil) => !pil)) {
            onModalValidation();
            return;
        }

        const soalBaru = {
            nomor: soalCounter, // counter soal
            tipeSoal,
            modul,
            soal: mode === "text" ? soal : deskripsi,
            pilihan,
            mode,
        };

        setSoalList([...soalList, soalBaru]);
        setSoal([""]);
        setPilihan(["", "", "", ""]);
        setDeskripsi(["", "", ""]);
        setSoalCounter(soalCounter + 1); // pake increment ( 0 + 1 = 1)
        onModalSuccess();
    };

    const handleSaveSoal = () => {
        if (soalList.length === 0) {
            onModalValidation();
            return;
        }

        soalList.forEach((soalBaru) => addSoal(soalBaru));
        setIsModalOpenSuccess(true);
    };

    const handleCloseSuccessModal = () => {
        setIsModalOpenSuccess(false);
    };

    const handleOpenModalDelate = (nomor) => {
        setSelectedNomor(nomor);
        setIsModalOpenDelate(true);
    };

    const handleCloseModalDelate = () => {
        setIsModalOpenDelate(false);
        setSelectedNomor(null);
    };

    const handleConfirmDelete = () => {
        setSoalList(soalList.filter((item) => item.nomor !== selectedNomor));
        handleCloseModalDelate();
    };

    const handleOpenModalEdit = (soalItem) => {
        setEditingSoal(soalItem);
        setIsModalOpenEdit(true);
    };

    const handleConfirmEdit = (updatedSoal) => {
        setSoalList(
            soalList.map((item) =>
                item.nomor === updatedSoal.nomor ? updatedSoal : item
            )
        );
        setIsModalOpenEdit(false);
    };

    const handleCloseModalEdit = () => {
        setEditingSoal(null);
        setIsModalOpenEdit(false);
    };

    const handleModeSwitch = () => {
        setMode(mode === "text" ? "kode" : "text");
    };

    return (
        <div>
            <div className="flex justify-between items-center mb-2">
                <label className="font-semibold text-lg">Soal</label>
                <button
                    className="border-2 border-darkBrown rounded-md shadow-md text-sm text-darkBrown text-left py-1 font-bold px-8"
                    onClick={handleModeSwitch}
                >
                    {mode === "text" ? "Mode Kode" : "Mode Text"}
                </button>
            </div>

            {mode === "kode" ? (
                <div>
                    <input
                        type="text"
                        className="w-full p-2 mb-2 border rounded"
                        placeholder="cth: Perhatikan Soal Berikut"
                        value={deskripsi[0]}
                        onChange={(e) => handleDeskripsiChange(0, e.target.value)}
                    />
                    <textarea
                        className="w-full p-2 mb-2 border rounded font-mono text-sm whitespace-pre overflow-auto max-h-64 resize-none"
                        rows="10"
                        placeholder="Tulis kode di sini..."
                        value={deskripsi[1]}
                        onChange={(e) => handleDeskripsiChange(1, e.target.value)}
                    ></textarea>
                    <textarea
                        className="w-full p-2 border rounded overflow-auto max-h-64 resize-none"
                        rows="4"
                        placeholder="Masukkan soal..."
                        value={deskripsi[2]}
                        onChange={(e) => handleDeskripsiChange(2, e.target.value)}
                    ></textarea>
                </div>
            ) : (
                <div>
                    {soal.map((item, index) => (
                        <textarea
                            key={index}
                            className="w-full p-2 mb-2 border rounded overflow-auto max-h-64 resize-none"
                            rows="4"
                            placeholder={"Masukkan soal..."}
                            value={item}
                            onChange={(e) => handleSoalChange(index, e.target.value)}
                        ></textarea>
                    ))}
                </div>
            )}

            <label className="block mb-2 font-medium">Pilihan Jawaban</label>
            {pilihan.map((pil, index) => (
                <input
                    key={index}
                    type="text"
                    className={`w-full p-2 mb-2 border rounded ${index === 0 ? "border-deepForestGreen" : "border-fireRed"}`}
                    placeholder={`Pilihan ${String.fromCharCode(65 + index)}`}
                    value={pil}
                    onChange={(e) => handlePilihanChange(index, e.target.value)}
                />
            ))}

            <div className="flex justify-end space-x-3 mt-3">
                <button
                    className="text-md py-1 px-8 font-bold border text-white bg-redredDark border-redredDark rounded-md shadow-sm"
                    onClick={handleTambahSoal}
                >
                    + Tambah Soal
                </button>
                {soalList.length > 0 && (
                    <button
                        className="text-md py-1 px-8 font-bold border text-white bg-deepForestGreen border-deepForestGreen rounded-md shadow-sm"
                        onClick={handleSaveSoal}
                    >
                        Save Soal
                    </button>
                )}
            </div>

            <div className="mt-5">
                <h3 className="font-bold mb-3">Soal yang telah ditambahkan:</h3>
                <ul className="space-y-3">
                    {soalList.map((soalItem, index) => (
                        <li key={index} className="relative p-7 border border-gray-300 rounded-lg bg-softIvory shadow-lg">
                            {soalItem.mode === "kode" ? (
                                <>
                                    <div>
                                        <div className="mb-2">
                                            <strong>Soal: {soalItem.nomor}</strong>
                                            <p className="ml-4">{soalItem.soal[0]}</p>
                                        </div>
                                        <div className="mb-2">
                                            <pre className="ml-4 bg-gray-200 p-2 rounded font-mono text-sm">
                                                {soalItem.soal[1]}
                                            </pre>
                                        </div>
                                        <div className="mb-2">
                                            <p className="ml-4">{soalItem.soal[2]}</p>
                                        </div>
                                    </div>
                                </>
                            ) : (
                                soalItem.soal.map((soalText, idx) => (
                                    <div key={idx} className="mb-2">
                                        <strong>Soal: {soalItem.nomor} </strong>
                                        <p className="ml-4">{soalText}</p>
                                    </div>
                                ))
                            )}

                            <div className="mb-2">
                                <strong>Pilihan:</strong>
                                <ul className="ml-4">
                                    {soalItem.pilihan.map((pilihan, idx) => (
                                        <li key={idx}>{`${String.fromCharCode(65 + idx)}. ${pilihan}`}</li>
                                    ))}
                                </ul>
                            </div>

                            <div className="absolute top-2 right-2 flex space-x-2">
                                <button
                                    onClick={() => handleOpenModalEdit(soalItem)}
                                    className="flex justify-center items-center p-1 border-2 border-darkBrown rounded bg-white"
                                >
                                    <img className="w-5" src={editIcon} alt="Edit" />
                                </button>
                                <button
                                    onClick={() => handleOpenModalDelate(soalItem.nomor)}
                                    className="flex justify-center items-center p-1 border-2 border-fireRed rounded bg-white"
                                >
                                    <img className="w-5 h-5" src={trashIcon} alt="Delete" />
                                </button>
                            </div>
                        </li>
                    ))}
                </ul>
            </div>

            {isModalOpenDelate && ( <ModalDelateSoal onClose={handleCloseModalDelate} onConfirm={handleConfirmDelete} />)}
            {isModalOpenEdit && ( <ModalEditSoalPG soalItem={editingSoal} onClose={handleCloseModalEdit} onConfirm={handleConfirmEdit} /> )}
            {isModalOpenSuccess && ( <ModalSaveSoal onClose={handleCloseSuccessModal} onConfirm={handleSaveSoal} /> )}
        </div>
    );
}
