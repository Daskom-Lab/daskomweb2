import { useState } from "react";
import ButtonEditModule from "./ModalEditModule";
import ButtonDeleteModule from "./ButtonDelateModule";
import editIcon from "../../../assets/nav/Icon-Edit.svg";
import trashIcon from "../../../assets/nav/Icon-Delete.svg";
import rankingIcon from "../../../assets/nav/Icon-Ranking.svg";
import pollingIcon from "../../../assets/nav/Icon-Polling.svg";
import plottingIcon from "../../../assets/nav/Icon-Plotting.svg";

export default function TabelModulePraktikum() {
    const [isModalOpenEdit, setIsModalOpenEdit] = useState(false);
    const [isModalOpenDelete, setIsModalOpenDelete] = useState(false);
    const [message, setMessage] = useState("");
    const [openIndex, setOpenIndex] = useState(null);

    const handleOpenModalEdit = () => {
        setIsModalOpenEdit(true);
    };

    const handleCloseModalEdit = () => {
        setIsModalOpenEdit(false);
    };

    const handleOpenModalDelete = () => {
        setIsModalOpenDelete(true);
    };

    const handleCloseModalDelete = () => {
        setIsModalOpenDelete(false);
    };

    const handleConfirmDelete = () => {
        setMessage("Modul berhasil dihapus");
    };

    const toggleAccordion = (index) => {
        // logika accordian by flowbite
        setOpenIndex(openIndex === index ? null : index);
    };

    const modules = [
        {
            title: "Pengenalan Algoritma dan Pemrograman",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Sintaks Dasar dan Struktur Program C",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Kontrol Alur Program",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Looping dan Iterasi",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Looping dan Iterasi",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Looping dan Iterasi",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Looping dan Iterasi",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Looping dan Iterasi",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
        {
            title: "Looping dan Iterasi",
            content: [
                "Menjelaskan konsep dasar algoritma.",
                "Membahas cara penulisan algoritma yang efektif.",
                "Mengenal jenis-jenis struktur data yang digunakan dalam algoritma.",
            ],
        },
    ];

    return (
        <div className="mt-5 px-4">
            {/* Header dengan div */}
            <div className="bg-deepForestGreen rounded-lg py-2 px-4 mb-4 shadow-md flex justify-center items-center">
                <h1 className="font-bold text-white text-center text-2xl hover:bg-darkOliveGreen hover:rounded-lg transition-colors duration-300 px-4 py-1">
                    Modul Praktikum
                </h1>
            </div>

            {/* Kontainer modul untuk scroll tabel */}
            <div className="overflow-x-auto max-h-96 bg-white rounded-lg p-1">
                {/* Accordion */}
                {modules.map((module, index) => (
                    <div
                        key={index}
                        className="border border-black rounded-lg mb-2"
                    >
                        {/* Header Accordion */}
                        <button
                            onClick={() => toggleAccordion(index)}
                            className="flex justify-between items-center w-full px-5 py-3 text-left font-semibold bg-white transition-all rounded-lg"
                        >
                            <span className="font-bold text-xl text-black">{index + 1}. {module.title}</span>
                            <span className="text-xl">{openIndex === index ? "▲" : "▼"}</span>
                        </button>

                        <div className="pl-10">
                            {/* Konten Accordion */}
                            {openIndex === index && (
                                <div>
                                    <h4 className="text-lg font-semibold text-black mt-2">Pencapaian Pembelajaran: </h4>
                                    <div className="px-5 py-3 text-md text-black">
                                        {module.content.map((item, i) => (
                                            <div key={i} className="flex items-start space-x-2">
                                                <span className="font-semibold">{i + 1}.</span>
                                                <span>{item}</span>
                                            </div>
                                        ))}
                                    </div>

                                    <h6 className="text-md text-black mt-4">Untuk tutorial lebih lanjut, Anda dapat menonton video berikut:</h6>
                                    {/* per link sosmed belajar */}
                                    <div className="mt-2 mb-8">
                                        {/* link ppt */}
                                        <span className="flex items-center mt-2">
                                            <img src={rankingIcon} alt="Icon PPT" className="w-6 h-6 p-[2px] bg-green-700 rounded-full" />
                                            <a
                                                href=""
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="text-green-700 underline ml-2"
                                            >
                                                PPT
                                            </a>
                                        </span>

                                        {/* link youtube */}
                                        <span className="flex items-center mt-2">
                                            <img src={pollingIcon} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                                            <a
                                                href=""
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="text-red-700 underline ml-2"
                                            >
                                                Video YouTube
                                            </a>
                                        </span>

                                        {/* link pdf module */}
                                        <span className="flex items-center mt-2">
                                            <img src={plottingIcon} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                                            <a
                                                href=""
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="text-blue-700 underline ml-2"
                                            >
                                                Modul
                                            </a>
                                        </span>
                                    </div>

                                    <span className="flex justify-end pr-3">
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
                                    </span>
                                </div>
                            )}
                        </div>

                    </div>
                ))}
            </div>

            {/* modal */}
            {isModalOpenDelete && ( <ButtonDeleteModule onClose={handleCloseModalDelete} onConfirm={handleConfirmDelete} message={message}/>
            )}

            {isModalOpenEdit && (
                <ButtonEditModule onClose={handleCloseModalEdit} />
            )}
        </div>
    );
}
