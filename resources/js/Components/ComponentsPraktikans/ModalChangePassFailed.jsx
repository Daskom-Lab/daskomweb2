import React from 'react';
import iconClose from '../../../assets/modal/failedSymbol.png';

export default function ModalChangePassFailed({ onRetry }) {
    return (
        <div className="flex flex-col items-center justify-center">
            <img
                className="mt-6 h-full w-[110px] rounded-full"
                src={iconClose}
                alt="Close"
            />
            <h1 className="mt-3 text-xl font-bold">Password Gagal!</h1>
            <p className="mt-3 mb-5 w-[260px] text-[12px] font-semibold text-gray-400 text-center">
                Password baru dan konfirmasi password tidak sesuai.
            </p>
            <button
                className="w-[270px] mt-5 p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm mb-3 hover:bg-deepForestGreenDark duration-300"
                onClick={onRetry}
            >
                Coba Kembali
            </button>
        </div>
    );
}