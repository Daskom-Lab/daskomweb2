import React from 'react';
import { router } from '@inertiajs/react';
import closeIcon from "../../../assets/modal/iconClose.svg";

export default function ModalLogout({ onClose, onConfirm }) {
    if (onConfirm) {
        router.post('/asisten/logout', {}, {
            onSuccess: () => {
                // Redirect the user to the login page after a successful logout
                window.location.href = '/login';
            },
            onError: (error) => {
                // Handle any errors during logout
                console.error('Logout failed:', error);
                alert('Something went wrong. Please try again.');
            },
        });
    }

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div className="bg-softGray p-6 rounded shadow-lg w-1/4 relative">
                {/* Close Button */}
                <button
                    onClick={onClose}
                    className="absolute top-2 right-2 flex justify-center items-center"
                >
                    <img className="w-9" src={closeIcon} alt="Close Icon" />
                </button>

                <h2 className="text-2xl font-bold text-center mt-8 mb-5">Apakah Kamu Yakin?</h2>

                {/* Yes and No Buttons */}
                <div className="flex justify-center gap-2 mt-6">
                    <button
                        onClick={onConfirm}
                        className="w-1/3 p-2 bg-deepForestGreen text-white font-semibold rounded hover:bg-darkGreen"
                    >
                        Ya
                    </button>
                    <button
                        onClick={onClose}
                        className="w-1/3 p-2 bg-softRed text-white font-semibold rounded hover:bg-rustyRed"
                    >
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    );
}
