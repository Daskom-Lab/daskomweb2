import { useState } from 'react';
import { useForm } from '@inertiajs/react';
import eyeClose from '../../../assets/form/eyeClose.png';
import eyeOpen from '../../../assets/form/eyeOpen.png';
import AuthButton from '../ComponentsPraktikans/AuthButton';

export default function RegistFormAssistant() {
    const [passwordVisible, setPasswordVisible] = useState(false);

    const togglePasswordVisibility = () => {
        setPasswordVisible(prev => !prev);
    };

    const { data, setData, post, processing } = useForm({
        fullName: '',
        desc: '',
        phone: '',
        lineId: '',
        instagram: '',
        role: '',
        assistantCode: '',
        password: '',
    });

    const handleChange = (e) => {
        const { name, value } = e.target;
        setData(name, value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('assistant.register'));
    };

    return (
        <div className="w-1/2 my-1 px-10">
            <p className="font-bold text-lg text-center">Let’s Get Started..</p>
            <form onSubmit={handleSubmit} className="flex flex-col gap-4">
                <input
                    className="bg-lightGray py-1 px-4 mt-3 rounded-sm border-dustyBlue border-2 placeholder-dustyBlue peer"
                    type="text"
                    name="fullName"
                    placeholder="Nama Lengkap"
                    value={data.fullName}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="desc"
                    placeholder="Deskripsi"
                    value={data.desc}
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
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="lineId"
                    placeholder="ID Line"
                    value={data.lineId}
                    onChange={handleChange}
                />
                <input
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                    type="text"
                    name="instagram"
                    placeholder="Instagram"
                    value={data.instagram}
                    onChange={handleChange}
                />
                <select
                    className="bg-lightGray py-1 px-4 mt-[-10px] rounded-sm border-dustyBlue border-2 placeholder-dustyBlue ${data.role ? 'text-black' : 'text-dustyBlue'}"
                    name="role"
                    value={data.role}
                    onChange={handleChange}
                >
                    <option value="" disabled className='hidden focus:text-black'>Pilih Role</option>
                    {[
                        "KOORDAS", "SOFTWARE", "HARDWARE", "KOORPRAK", "ADMIN 1", "ADMIN 2", 
                        "PJ SC ATC", "PJ SC CMD", "PJ SC HRD", "PJ SC MLC", "PJ SC RDC", 
                        "SC ATC", "SC CMD", "SC HRD", "SC MLC", "SC RDC", 
                        "ATC", "CMD", "DDC", "HRD", "MLC", "RDC"
                    ].map(role => (
                        <option key={role} value={role} className='text-black'>{role}</option>
                    ))}
                </select>
                <input
                    className="bg-[#CDCDCD] py-1 px-4 mt-[-10px] rounded-sm border-[#868A95] border-2 placeholder-[#868A95] uppercase"
                    type="text"
                    name="assistantCode"
                    placeholder="Kode Asisten"
                    value={data.assistantCode}
                    onChange={handleChange}
                    maxLength={3}
                />
                <div className="relative">
                    <input
                        className="bg-[#CDCDCD] py-1 px-4 mt-[-10px] mb-5 w-full rounded-sm border-[#868A95] border-2 placeholder-[#868A95]"
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