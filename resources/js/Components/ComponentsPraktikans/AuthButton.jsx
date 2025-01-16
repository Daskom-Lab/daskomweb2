import { Link } from '@inertiajs/react';
import { useState } from 'react';
import Modal from '../ComponentsPraktikans/Modal';
import ModalRegist from '../ComponentsPraktikans/ModalRegist';

const Separator = () => (
    <div className="grid grid-cols-3 items-center">
        <hr className="border-black" />
        <p className="text-center text-sm">OR</p>
        <hr className="border-black" />
    </div>
);

export default function AuthButton({ order, openModal, mode }) {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const handleOpenModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    return order === 'login' ? (
        <>
            <Link href={mode === 'praktikan' ? '/praktikan' : '/assistant'}>
                <button className="w-full mt-2 mb-1 p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm hover:bg-deepForestGreenDark duration-300">
                    Masuk
                </button>
            </Link>
            <Separator />
            <Link href={`/register?mode=${mode}`}>
                <button className="w-full mt-1 p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm mb-3 hover:bg-deepForestGreenDark duration-300">
                    Daftar
                </button>
            </Link>
        </>
    ) : (
        <>
            <button
                className="w-full mt-[-20px] mb-[-10px] p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm hover:bg-deepForestGreenDark duration-300"
                onClick={handleOpenModal}
            >
                Daftar
            </button>
            <Separator />
            <Link href="/login">
                <button className="w-full mt-[-10px] p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm mb-3 hover:bg-deepForestGreenDark duration-300">
                    Masuk
                </button>
            </Link>
            {isModalOpen && (
                <Modal isOpen={isModalOpen} onClose={closeModal} width="w-[370px]">
                    <ModalRegist />
                </Modal>
            )}
        </>
    );
}