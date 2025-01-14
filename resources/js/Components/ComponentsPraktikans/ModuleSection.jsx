import React, { useState, useEffect } from "react";
import iconPPT from "../../../assets/practicum/iconPPT.svg";
import iconVideo from "../../../assets/practicum/iconVideo.svg";
import iconModule from "../../../assets/practicum/iconModule.svg";
import iconCeklistboxFalse from "../../../assets/practicum/iconCeklistboxFalse.svg";
import iconCeklistboxTrue from "../../../assets/practicum/iconCeklistboxTrue.svg";
import Modal from "../ComponentsPraktikans/Modal";
import ModalAttempt from "../ComponentsPraktikans/ModalAttempt";

export default function ModuleSection() {
    const [expandedRows, setExpandedRows] = useState([]);
    const [openModal, setOpenModal] = useState(null);
    const [completedTasks, setCompletedTasks] = useState({
        TugasPendahuluan: false,
        TesAwal: false,
        Jurnal: false,
        Mandiri: false,
        TesKeterampilan: false,
    });

    const handleOpenModal = (key) => {
        setOpenModal(key);
    };

    const closeModal = () => {
        setOpenModal(null);
    };

    const handleAttemptComplete = (key) => {
        setCompletedTasks((prev) => ({
            ...prev,
            [key]: true,
        }));
        closeModal();
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href=""
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 2,
            moduleName: (
                <span className="font-bold text-xl">Sintaks Dasar dan Struktur Program C</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 3,
            moduleName: (
                <span className="font-bold text-xl">Kontrol Alur Program</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 4,
            moduleName: (
                <span className="font-bold text-xl">Looping dan Iterasi</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 5,
            moduleName: (
                <span className="font-bold text-xl">Fungsi</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 6,
            moduleName: (
                <span className="font-bold text-xl">Array dan String</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 7,
            moduleName: (
                <span className="font-bold text-xl">Pointer</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 8,
            moduleName: (
                <span className="font-bold text-xl">File Input/Output</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 9,
            moduleName: (
                <span className="font-bold text-xl">Sorting</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
                        )}
                    </div>
                ))}
                </>
            ),
        },
        {
            id: 10,
            moduleName: (
                <span className="font-bold text-xl">Searching</span>
            ),
            details: (
                <>
                    <h3 className="font-semibold text-md pl-[26px]">
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
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-green-700 underline ml-2"
                        >
                            PPT
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconVideo} alt="Icon Video" className="w-6 h-6 p-[2px] bg-red-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-red-700 underline ml-2"
                        >
                            Video YouTube
                        </a>
                    </div>
                    <div className="flex items-center mt-2 pl-[26px]">
                        <img src={iconModule} alt="Icon Module" className="w-6 h-6 p-[2px] bg-blue-700 rounded-full" />
                        <a
                            href=""
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-blue-700 underline ml-2"
                        >
                            Module
                        </a>
                    </div>
                    <br />
                    {Object.keys(completedTasks).map((key) => (
                    <div
                        key={key}
                        className="flex items-center justify-between mt-2 pl-[26px]"
                        onClick={() => handleOpenModal(key)}
                    >
                        <div className="flex items-center">
                            <img
                                src={
                                    completedTasks[key]
                                        ? iconCeklistboxTrue
                                        : iconCeklistboxFalse
                                }
                                alt="Checkbox"
                                className="w-5 h-5 cursor-pointer"
                            />
                            <p className="pl-2 text-black cursor-pointer">{key.replace(/([A-Z])/g, ' $1')}</p>
                        </div>

                        {completedTasks[key] && (
                            <div className="mr-[42vw]">
                                <a
                                    href="/review"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-dustyBlue underline"
                                >
                                    Review
                                </a>
                            </div>
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
        <div className="bg-white rounded-lg py-4 px-4 max-w-4xl mx-auto">
            <div className="flex bg-deepForestGreen rounded-lg py-2 px-2 mb-4 justify-center">
                <h1 className="text-white text-center font-bold text-2xl bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[50%]">MODUL PRAKTIKUM</h1>
            </div>
            <div
                className="space-y-2 overflow-y-auto"
                style={{ maxHeight: "400px" }}
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

            {openModal && (
                <Modal isOpen={!!openModal} onClose={closeModal} width="w-[370px]">
                    <ModalAttempt
                        taskKey={openModal}
                        onAttemptComplete={handleAttemptComplete} 
                    />
                </Modal>            
            )}
        </div>
    );
}