import { useState, useEffect } from "react";
import { Link } from "@inertiajs/react";
import iconPPT from "../../../assets/practicum/iconPPT.svg";
import iconVideo from "../../../assets/practicum/iconVideo.svg";
import iconModule from "../../../assets/practicum/iconModule.svg";
import iconCeklistboxFalse from "../../../assets/practicum/iconCeklistboxFalse.svg";
import iconCeklistboxTrue from "../../../assets/practicum/iconCeklistboxTrue.svg";
import Modal from "../ComponentsPraktikans/Modal";
import ModalAttempt from "../ComponentsPraktikans/ModalAttempt";
import ModalReview from "../ComponentsPraktikans/ModalReview";

export default function ModuleSection({ 
    onNavigate, 
    completedCategories,
    setCompletedCategories,
    onReviewTask
 }) {
    const [expandedRows, setExpandedRows] = useState([]);
    const [openModalAttempt, setOpenModalAttempt] = useState(null); 
    const [openModalReview, setOpenModalReview] = useState(null);   

    const categoryLabels = {
        TugasPendahuluan: "Tugas Pendahuluan",
        TesAwal: "Tes Awal",
        Jurnal: "Jurnal",
        Mandiri: "Mandiri",
        TesKeterampilan: "Tes Keterampilan",
    };

    const [categories, setCategories] = useState({
        TugasPendahuluan: { isSubmitted: false },
        TesAwal: { isSubmitted: false },
        Jurnal: { isSubmitted: false },
        Mandiri: { isSubmitted: false },
        TesKeterampilan: { isSubmitted: false },
    });

    const handleSubmission = (categoryName) => {
        setCategories((prev) => ({
            ...prev,
            [categoryName]: { ...prev[categoryName], isSubmitted: true },
        }));
    };

    const handleOpenModalAttempt = (key) => {
        setOpenModalAttempt(key);
        setOpenModalReview(null);
    };

    const handleOpenModalReview = (key) => {
        setOpenModalReview(key); 
        setOpenModalAttempt(null);
    };

    const closeModal = () => {
        setOpenModalAttempt(null); 
        setOpenModalReview(null); 
    };    
      
    const handleAttemptComplete = (key) => {
        if (key === "TugasPendahuluan") {
            onNavigate("TugasPendahuluan");
        } else if (key === "TesAwal") {
            onNavigate("TesAwal");
        } else if (key === "Jurnal") {
            onNavigate("Jurnal");
        } else if (key === "Mandiri") {
            onNavigate("Mandiri");
        } else if (key === "TesKeterampilan") {
            onNavigate("TesKeterampilan");
        }
        closeModal();
    };      

    const handleReviewNavigate = (key) => {
        if (onReviewTask) {
            onReviewTask(key);
        }
    };    

    const handleCategoryClick = (key) => {
        if (!completedCategories[key]) {
            handleOpenModalAttempt(key); 
        } else {
            handleOpenModalReview(key); 
        }
    };            

    const rows = [
        {
            id: 1,
            moduleName: (
                <span className="font-bold text-xl">Pengenalan Algoritma dan Pemrograman</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-lg pl-[26px]">
                        Pencapaian Pembelajaran
                    </h3>
                    <ol className="list-decimal list-inside pl-[26px]">
                        <li>Mampu mendefinisikan apa itu algoritma dan mengapa penting dalam pemrograman.</li>
                        <li>Mampu menjelaskan struktur dasar dari program C.</li>
                        <li>Mampu mengidentifikasi komponen utama dari sebuah program C.</li>
                        <li>Mampu mengatur lingkungan pengembangan untuk pemrograman C.</li>
                    </ol>
                    <br />
                    <p className="pl-[26px]">
                        Untuk tutorial lebih lanjut, Anda dapat menonton video berikut:
                    </p>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconPPT} alt="Icon PPT" className="w-6 h-6 p-[2px] bg-green-700 rounded-full" />
                        <Link
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </Link>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <Link
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </Link>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <Link
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </Link>
                    </div>
                    <br />
                    {Object.keys(completedCategories).map((key) => (
                        <div
                            key={key}
                            className="flex items-center justify-between mt-2 pl-[26px]"
                            onClick={() => handleCategoryClick(key)}
                        >
                            <div className="flex items-center">
                                <img
                                    src={completedCategories[key] ? iconCeklistboxTrue : iconCeklistboxFalse}
                                    alt="Checkbox"
                                    className="w-5 h-5 cursor-pointer"
                                />
                                <p className="pl-2 text-black cursor-pointer">
                                    {categoryLabels[key] || key}
                                </p>
                            </div>

                            {completedCategories[key] && (
                                <div className="mr-[42vw]">
                                    <span
                                        className="text-darkGray underline hover:text-dustyBlue cursor-pointer"
                                        onClick={(e) => {
                                            e.stopPropagation();
                                            handleOpenModalReview(key);
                                        }}
                                    >
                                        Review
                                    </span>
                                </div>
                            )}

                            {openModalReview === key && (
                                <Modal isOpen={!!openModalReview} onClose={closeModal} width="w-[370px]">
                                    <ModalReview
                                        taskKey={openModalReview}
                                        onReviewNavigate={() => handleReviewNavigate(key)}
                                    />
                                </Modal>
                            )}

                            {openModalAttempt === key && (
                                <Modal isOpen={!!openModalAttempt} onClose={closeModal} width="w-[370px]">
                                    <ModalAttempt
                                        taskKey={openModalAttempt}
                                        onAttemptComplete={(taskKey) => handleAttemptComplete(taskKey)}
                                    />
                                </Modal>
                            )}
                        </div>
                    ))}
                </>
            ),
        },
    ];

    const toggleRow = (id) => {
        if (expandedRows.includes(id)) {
            setExpandedRows(expandedRows.filter((rowId) => rowId !== id));
        } else {
            setExpandedRows([...expandedRows, id]);
        }
    };

    useEffect(() => {
        document.body.style.overflow = "hidden";
        return () => {
            document.body.style.overflow = "";
        };
    }, []);

    return (
        <div className="ml-[3vw] bg-white rounded-lg py-4 px-4 w-[896px] mx-auto">
            <div className="flex bg-deepForestGreen rounded-lg py-2 px-2 mb-4 justify-center">
                <h1 className="text-white text-center font-bold text-2xl bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[50%]">MODUL PRAKTIKUM</h1>
            </div>
            <div
                className="space-y-2 overflow-y-auto"
                style={{ maxHeight: "69vh" }}
            >
                {rows.map((row) => (
                    <div
                        key={row.id}
                        className="border border-black rounded-md overflow-hidden"
                    >
                        <div className="flex justify-between items-center px-4 py-2 bg-white">
                            <div className="flex items-center space-x-4">
                                <span className="text-center font-bold text-xl">
                                    {row.id}.
                                </span>
                                <span>{row.moduleName}</span>
                            </div>
                            <button
                                onClick={() => toggleRow(row.id)}
                                className="focus:outline-none"
                            >
                                {expandedRows.includes(row.id) ? "▲" : "▼"}
                            </button>
                        </div>
                        {expandedRows.includes(row.id) && (
                            <div className="px-4 py-2 bg-gray-50 space-y-2">
                                {row.details}
                            </div>
                        )}
                    </div>
                ))}
            </div>
        </div>
    );
}