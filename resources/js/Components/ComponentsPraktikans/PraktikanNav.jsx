import { useState } from 'react';
import { Link } from "@inertiajs/react";
import profileIcon from "../../../assets/nav/Icon-Profile.svg";
import praktikumIcon from "../../../assets/nav/Icon-Praktikum.svg";
import nilaiIcon from "../../../assets/nav/Icon-Nilai.svg";
import leaderboardIcon from "../../../assets/nav/Icon-Leaderboard.svg";
import asistenIcon from "../../../assets/nav/Icon-Asisten.svg";
import pollingIcon from "../../../assets/nav/Icon-Polling.svg";
import changePassIcon from "../../../assets/nav/Icon-GantiPassword.svg";
import logoutIcon from "../../../assets/nav/Icon-Logout.svg";
import Modal from '../ComponentsPraktikans/Modal';
import ModalChangePass from '../ComponentsPraktikans/ModalChangePass';
import ModalChangePassSuccess from '../ComponentsPraktikans/ModalChangePassSuccess';
import ModalChangePassFailed from '../ComponentsPraktikans/ModalChangePassFailed';
import ModalLogout from '../ComponentsPraktikans/ModalLogout';

export default function PraktikanNav() {
    const [isCollapsed, setIsCollapsed] = useState(true);
    const [isAnimating, setIsAnimating] = useState(false);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [isChangePassSuccess, setIsChangePassSuccess] = useState(false);
    const [isChangePassFailed, setIsChangePassFailed] = useState(false);
    const [isLogoutModalOpen, setIsLogoutModalOpen] = useState(false);

    const handleOpenLogoutModal = () => {
        setIsLogoutModalOpen(true);
    };

    const closeLogoutModal = () => {
        setIsLogoutModalOpen(false);
    };

    const handleOpenModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
        setIsChangePassSuccess(false); 
        setIsChangePassFailed(false); 
    };

    const toggleSidebar = () => {
        if (!isCollapsed) {
            setIsAnimating(true);
            setTimeout(() => {
                setIsCollapsed(!isCollapsed);
                setIsAnimating(false);
            }, 300);
        } else {
            setIsCollapsed(!isCollapsed);
        }
    };
    const [isOpen, setIsOpen] = useState(false);
    const genericHamburgerLine = `h-1 w-6 my-1 rounded-full bg-black transition ease transform duration-300`;

    return (
        <nav className="h-screen flex items-center">
            <div
                className={`flex flex-col h-[79vh] ${
                    isCollapsed ? "w-12" : "w-[230px]"
                } bg-forestGreen text-left text-white mx-[8px] font-poppins font-bold rounded-md transition-all duration-300`}
            >
                <div className="flex relative items-center">
                    <button
                        className="absolute top-3 right-3 flex flex-col justify-center items-center group"
                        onClick={() => {
                            setIsOpen(!isOpen);
                            toggleSidebar();
                        }}
                    >
                        <div
                            className={`${genericHamburgerLine} bg-white transform transition-all duration-300 ease-in-out ${
                                isOpen
                                    ? "rotate-45 translate-y-3"
                                    : "translate-y-1 group-hover:translate-y-0"
                            }`}
                        />
                        <div
                            className={`${genericHamburgerLine} bg-white transform transition-all duration-300 ease-in-out ${
                                isOpen ? "opacity-0" : "opacity-100"
                            }`}
                        />
                        <div
                            className={`${genericHamburgerLine} bg-white transform transition-all duration-300 ease-in-out ${
                                isOpen
                                    ? "-rotate-45 -translate-y-3"
                                    : "-translate-y-1 group-hover:translate-y-0"
                            }`}
                        />
                    </button>
                </div>
                <div className="flex-grow flex flex-col justify-center py-16">
                    <ul className="py-5">
                        <li>
                            <Link
                                href="/praktikan"
                                className="flex py-3 px-3 hover:bg-darkGreen items-center"
                            >
                                <img
                                    className="w-6"
                                    src={profileIcon}
                                    alt="profile"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Profile
                                </span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/praktikum"
                                className="flex py-3 px-3 hover:bg-darkGreen items-center"
                            >
                                <img
                                    className="w-6"
                                    src={praktikumIcon}
                                    alt="praktikum"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Praktikum
                                </span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/score-praktikan"
                                className="flex py-3 px-3 hover:bg-darkGreen items-center"
                            >
                                <img
                                    className="w-6"
                                    src={nilaiIcon}
                                    alt="nilai"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Nilai
                                </span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/leaderboard-praktikan"
                                className="flex py-3 px-3 hover:bg-darkGreen items-center"
                            >
                                <img
                                    className="w-6"
                                    src={leaderboardIcon}
                                    alt="leaderboard"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Leaderboard
                                </span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/contact-assistant"
                                className="flex py-3 px-3 hover:bg-darkGreen items-center"
                            >
                                <img
                                    className="w-6"
                                    src={asistenIcon}
                                    alt="asisten"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Asisten
                                </span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/polling-assistant"
                                className="flex py-3 px-3 hover:bg-darkGreen items-center"
                            >
                                <img
                                    className="w-6"
                                    src={pollingIcon}
                                    alt="polling"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Polling
                                </span>
                            </Link>
                        </li>
                        <li>
                            <Link
                                className="flex py-3 px-3 hover:bg-darkGreen items-center cursor-pointer"
                                onClick={handleOpenModal}
                            >
                                <img
                                    className="w-6"
                                    src={changePassIcon}
                                    alt="change password"
                                />
                                <span
                                    className={`self-center text-sm ml-3 text-nowrap transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Change Password
                                </span>
                            </Link>
                        </li>
                        {isModalOpen && !isChangePassSuccess && !isChangePassFailed && (
                            <Modal isOpen={isModalOpen} onClose={closeModal} width="w-[370px]">
                                <ModalChangePass
                                    onSuccess={() => {
                                        setIsChangePassSuccess(true);
                                        setIsModalOpen(false); 
                                    }}
                                    onFailed={() => {
                                        setIsChangePassFailed(true);
                                        setIsModalOpen(false); 
                                    }}
                                />
                            </Modal>
                        )}
                        {isChangePassSuccess && (
                            <Modal isOpen={true} onClose={closeModal} width="w-[370px]">
                                <ModalChangePassSuccess />
                            </Modal>
                        )}
                        {isChangePassFailed && (
                            <Modal isOpen={true} onClose={closeModal} width="w-[370px]">
                                <ModalChangePassFailed
                                    onRetry={() => {
                                        setIsChangePassFailed(false);
                                        setIsModalOpen(true); 
                                    }}
                                />
                            </Modal>
                        )}
                        <li>
                            <Link
                                className="flex py-3 px-3 hover:bg-darkGreen items-center cursor-pointer"
                                onClick={handleOpenLogoutModal}
                            >
                                <img
                                    className="w-6"
                                    src={logoutIcon}
                                    alt="logout"
                                />
                                <span
                                    className={`self-center text-sm ml-3 transition-opacity duration-300 ${
                                        isCollapsed
                                            ? "opacity-0 delay-0"
                                            : isAnimating
                                            ? "opacity-0"
                                            : "opacity-100 delay-300"
                                    }`}
                                >
                                    Logout
                                </span>
                            </Link>
                        </li>
                        {isLogoutModalOpen && (
                            <Modal isOpen={isLogoutModalOpen} onClose={closeLogoutModal} width="w-[370px]">
                                <ModalLogout onClose={closeLogoutModal} />
                            </Modal>
                        )}
                    </ul>
                </div>
            </div>
        </nav>
    );
}
