import { useState } from "react";
import ModalDelateSoal from "./ModalDelateSoal";
import ModalEditSoalEssay from "./ModalEditSoalEssay";
import ModalSaveSoal from "./ModalSaveSoal";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg";

export default function SoalInputEssay({ tipeSoal, modul, onModalSuccess, onModalValidation, addSoal }) {
    const [soal, setSoal] = useState("");
    const [soalList, setSoalList] = useState([]);
    const [isModalOpenDelate, setIsModalOpenDelate] = useState(false);
    const [selectedNomor, setSelectedNomor] = useState(null);
    const [isModalOpenSuccess, setIsModalOpenSuccess] = useState(false);
    const [isModalOpenEdit, setIsModalOpenEdit] = useState(false);
    const [editingSoal, setEditingSoal] = useState(null);

    const handleTambahSoal = () => {
        if (!soal) {
            onModalValidation();
            return;
        }

        const soalBaru = {
            nomor: soalList.length + 1,
            tipeSoal,
            modul,
            soal,
        };

        setSoalList([...soalList, soalBaru]);
        setSoal("");
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

    const handleCloseModalEdit = () => {
        setEditingSoal(null);
        setIsModalOpenEdit(false);
    };

    const handleConfirmEdit = (updatedSoal) => {
        setSoalList(
            soalList.map((item) =>
                item.nomor === updatedSoal.nomor ? { ...item, soal: updatedSoal.soal } : item
            )
        );
        handleCloseModalEdit();
    };

    return (
        <div>
            <label className="block mb-2 font-medium">Soal</label>
            <textarea
                className="w-full p-2 border rounded"
                rows="8"
                placeholder="Masukkan soal..."
                value={soal}
                onChange={(e) => setSoal(e.target.value)}
            ></textarea>

            <div className="flex justify-end space-x-3 mt-3">
                <button
                    className="text-md py-1 px-8 font-bold border text-white bg-redredDark border-redredDark rounded-md shadow-sm shadow-redredDark"
                    onClick={handleTambahSoal}
                >
                    + Tambah Soal
                </button>

                {soalList.length > 0 && (
                    <button
                        className="text-md py-1 px-8 font-bold border text-white bg-deepForestGreen border-deepForestGreen rounded-md shadow-sm shadow-deepForestGreen"
                        onClick={handleSaveSoal}
                    >
                        Save Soal
                    </button>
                )}
            </div>

            <div className="mt-4">
                <h3 className="font-bold text-lg mb-3">Daftar Soal</h3>
                <ul className="space-y-3">
                    {soalList.map((soalItem) => (
                        <li
                            key={soalItem.nomor}
                            className="border border-gray-300 rounded-lg flex items-baseline bg-softIvory shadow-lg justify-between"
                        >
                            <div className="flex-1 p-4">
                                <strong>Soal: {soalItem.nomor}</strong>
                                <br />
                                <span className="ml-2 text-sm text-justify">{soalItem.soal}</span>
                            </div>
                            <div className="flex space-x-2 p-2">
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
            {isModalOpenEdit && ( <ModalEditSoalEssay initialSoal={editingSoal.soal} onClose={handleCloseModalEdit} onSave={handleConfirmEdit} />)}
            {isModalOpenSuccess && <ModalSaveSoal onClose={handleCloseSuccessModal} />}
        </div>
    );
}

