import { Link } from '@inertiajs/react';
import React from 'react';
import Modal from './Modal';
import AuthButton from './AuthButton';

export default function ButtonOption({ openModal, order, mode }) {
    const navigateToPage = (targetPage) => {
        window.location.href = targetPage;
    };

    return (
        <>
            <AuthButton order={order} openModal={openModal} mode={mode} navigateToPage={navigateToPage} />
            <Modal isOpen={openModal} onClose={() => openModal(false)} width="w-[350px]" />
        </>
    );
}