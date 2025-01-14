import React, { useState } from 'react';
import eyeClose from '../../../assets/form/eyeClose.png';
import eyeOpen from '../../../assets/form/eyeOpen.png';

export default function ModalChangePass({ onSuccess, onFailed }) {
    const [passwordVisible, setPasswordVisible] = useState(false);
    const [formData, setFormData] = useState({
        new_password: '',
        confirm_password: '',
    });
    const [error, setError] = useState('');

    const togglePasswordVisibility = () => {
        setPasswordVisible(!passwordVisible);
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: value,
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        if (!formData.new_password && !formData.confirm_password) {
            onFailed();
            return;
        }

        if (!formData.new_password) {
            onFailed();
            return;
        }

        if (!formData.confirm_password) {
            onFailed();
            return;
        }

        if (formData.new_password !== formData.confirm_password) {
            onFailed();
            return;
        }

        setError('');
        onSuccess();
    };

    return (
        <div className="flex flex-col items-center justify-center">
            <h1 className="mt-8 text-2xl font-bold">Ganti Password</h1>
            <form onSubmit={handleSubmit}>
                <div className="relative mt-10">
                    <input
                        className="bg-lightGray py-1 px-4 mt-[-10px] mb-5 w-full rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                        type={passwordVisible ? 'text' : 'password'}
                        name="new_password"
                        placeholder="Password Baru"
                        value={formData.new_password}
                        onChange={handleChange}
                    />
                    <img
                        className="w-4 cursor-pointer absolute top-[25%] right-3 transform -translate-y-1/2"
                        src={passwordVisible ? eyeOpen : eyeClose}
                        alt="Toggle Password Visibility"
                        onClick={togglePasswordVisibility}
                    />
                </div>
                <div className="relative">
                    <input
                        className="bg-lightGray py-1 px-4 mt-[-10px] mb-5 w-full rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                        type={passwordVisible ? 'text' : 'password'}
                        name="confirm_password"
                        placeholder="Konfirmasi Password Baru"
                        value={formData.confirm_password}
                        onChange={handleChange}
                    />
                    <img
                        className="w-4 cursor-pointer absolute top-[25%] right-3 transform -translate-y-1/2"
                        src={passwordVisible ? eyeOpen : eyeClose}
                        alt="Toggle Password Visibility"
                        onClick={togglePasswordVisibility}
                    />
                </div>
                {error && <p className="text-red-500 text-sm mb-2">{error}</p>}
                <button className="w-[270px] mt-5 p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm mb-3 hover:bg-deepForestGreenDark duration-300" type="submit">
                    Simpan
                </button>
            </form>
        </div>
    );
}