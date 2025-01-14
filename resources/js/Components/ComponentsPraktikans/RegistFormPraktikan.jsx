import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import eyeClose from '../../../assets/form/eyeClose.png';
import eyeOpen from '../../../assets/form/eyeOpen.png';
import AuthButton from '../ComponentsPraktikans/AuthButton';

export default function RegistFormPraktikan() {
    const [passwordVisible, setPasswordVisible] = useState(false);

    const togglePasswordVisibility = () => {
        setPasswordVisible(prev => !prev);
    };

    const { data, setData, post, processing } = useForm({
        email: '',
        fullName: '',
        nim: '',
        class: '',
        address: '',
        phone: '',
        password: '',
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setData(name, value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('praktikan.register'));
    };

    return (
        <div className="w-1/2 my-1 px-10">
            <p className="font-bold text-lg text-center">Let’s Get Started..</p>
            <form onSubmit={handleSubmit} className="flex flex-col gap-4">
                <input
                    className="bg-lightGray py-1 px-4 mt-3 rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="email"
                    name="email"
                    placeholder="Email"
                    value={data.email}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="fullName"
                    placeholder="Nama Lengkap"
                    value={data.fullName}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="nim"
                    placeholder="NIM"
                    value={data.nim}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="class"
                    placeholder="Kelas"
                    value={data.class}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="address"
                    placeholder="Alamat"
                    value={data.address}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="tel"
                    name="phone"
                    placeholder="No. Telepon"
                    value={data.phone}
                    onChange={handleChange}
                />
                <div className="relative">
                    <input
                        className="bg-lightGray py-1 px-4 mt-[-10px] mb-5 w-full rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                        type={passwordVisible ? 'text' : 'password'}
                        name="password"
                        placeholder="Password"
                        value={data.password}
                        onChange={handleChange}
                    />
                    <img
                        className="w-4 cursor-pointer absolute top-[25%] right-3 transform -translate-y-1/2"
                        src={passwordVisible ? eyeOpen : eyeClose}
                        alt="Toggle Password Visibility"
                        onClick={togglePasswordVisibility}
                    />
                </div>
                <AuthButton type="submit" disabled={processing} processing={processing} label="Daftar" />
            </form>
        </div>
    );
}