import { useState, useEffect } from 'react';
import { router, usePage } from '@inertiajs/react';
import eyeClose from '../../../assets/form/eyeClose.png';
import eyeOpen from '../../../assets/form/eyeOpen.png';
import ButtonOption from '../../Components/ComponentsPraktikans/ButtonOption';

export default function RegistFormAssistant({ mode }) {
    const [values, setValues] = useState({
        nama: '',
        deskripsi: '',
        nomor_telepon: '',
        id_line: '',
        instagram: '',
        role_id: '',
        kode: '',
        password: '',
    });

    const [passwordVisible, setPasswordVisible] = useState(false);
    const [roles, setRoles] = useState([]);
    const [localErrors, setLocalErrors] = useState({});
    const { errors: serverErrors } = usePage().props;

    const togglePasswordVisibility = () => {
        setPasswordVisible((prevState) => !prevState);
    };

    const handleChange = (e) => {
        const key = e.target.id;
        const value = e.target.value;
        setValues((prevValues) => ({
            ...prevValues,
            [key]: value,
        }));
    };

    const validateFields = () => {
        const newErrors = {};

        if (!values.nama.trim()) newErrors.nama = 'Nama is required.';
        if (!values.deskripsi.trim()) newErrors.deskripsi = 'Deskripsi is required.';
        if (!values.nomor_telepon.trim()) newErrors.nomor_telepon = 'Nomor Telepon is required.';
        if (!values.id_line.trim()) newErrors.id_line = 'ID Line is required.';
        if (!values.instagram.trim()) newErrors.instagram = 'Instagram is required.';
        if (!values.kode.trim()) newErrors.kode = 'Kode Asisten is required.';
        if (!values.password.trim()) newErrors.password = 'Password is required.';

        setLocalErrors(newErrors);

        // Return true if there are no errors
        return Object.keys(newErrors).length === 0;
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        if (validateFields()) {
            // Submit form using Inertia
            router.post('/api-v1/register/asisten', values, {
                preserveScroll: true,
                onFinish: () => {
                    console.log('Registration finished!');
                },
                onError: (errors) => {
                    console.error('Validation Errors:', errors);
                },
            });
        }
    };

    useEffect(() => {
        async function fetchRoles() {
            try {
                const response = await fetch('/api-v1/roles');
                if (response.ok) {
                    const data = await response.json();
                    setRoles(data.roles || []);
                } else {
                    console.error('Failed to fetch roles:', response.statusText);
                }
            } catch (error) {
                console.error('Error fetching roles:', error);
            }
        }

        fetchRoles();
    }, []);

    return (
        <div className="w-1/2 my-10 px-10">
            <h1 className="font-bold text-3xl text-darkGreen text-shadow-md text-center">
                REGISTER
            </h1>
            <p className="font-bold text-lg text-center">Let’s create your account!</p>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <div>
                    <input
                        className={`bg-lightGray py-1 px-4 mt-4 rounded-sm border-2 ${
                            localErrors.nama ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type="text"
                        id="nama"
                        value={values.nama}
                        onChange={handleChange}
                        placeholder="Nama Lengkap"
                    />
                    {localErrors.nama && <p className="text-red-500 text-sm mt-1">{localErrors.nama}</p>}
                </div>
                <div>
                    <input
                        className={`bg-lightGray py-1 px-4 mt-1 rounded-sm border-2 ${
                            localErrors.deskripsi ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type="text"
                        id="deskripsi"
                        value={values.deskripsi}
                        onChange={handleChange}
                        placeholder="Deskripsi"
                    />
                    {localErrors.deskripsi && <p className="text-red-500 text-sm mt-1">{localErrors.deskripsi}</p>}
                </div>
                <div>
                    <input
                        className={`bg-lightGray py-1 px-4 mt-1 rounded-sm border-2 ${
                            localErrors.nomor_telepon ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type="tel"
                        id="nomor_telepon"
                        value={values.nomor_telepon}
                        onChange={handleChange}
                        placeholder="No. Telepon"
                    />
                    {localErrors.nomor_telepon && <p className="text-red-500 text-sm mt-1">{localErrors.nomor_telepon}</p>}
                </div>
                <div>
                    <input
                        className={`bg-lightGray py-1 px-4 mt-1 rounded-sm border-2 ${
                            localErrors.id_line ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type="text"
                        id="id_line"
                        value={values.id_line}
                        onChange={handleChange}
                        placeholder="ID Line"
                    />
                    {localErrors.id_line && <p className="text-red-500 text-sm mt-1">{localErrors.id_line}</p>}
                </div>
                <div>
                    <input
                        className={`bg-lightGray py-1 px-4 mt-1 rounded-sm border-2 ${
                            localErrors.instagram ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type="text"
                        id="instagram"
                        value={values.instagram}
                        onChange={handleChange}
                        placeholder="Instagram"
                    />
                    {localErrors.instagram && <p className="text-red-500 text-sm mt-1">{localErrors.instagram}</p>}
                </div>
                <div>
                    <select
                        className="bg-lightGray py-1 px-4 mt-1 rounded-sm border-dustyBlue border-2 placeholder-dustyBlue w-full"
                        id="role_id"
                        value={values.role_id}
                        onChange={handleChange}
                    >
                        <option value="" disabled>
                            Pilih Role
                        </option>
                        {roles.map((role) => (
                            <option key={role.id} value={role.id}>
                                {role.name}
                            </option>
                        ))}
                    </select>
                </div>
                <div>
                    <input
                        className={`bg-lightGray py-1 px-4 mt-1 rounded-sm border-2 ${
                            localErrors.kode ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type="text"
                        id="kode"
                        value={values.kode}
                        onChange={handleChange}
                        placeholder="Kode Asisten"
                        maxLength={3}
                    />
                    {localErrors.kode && <p className="text-red-500 text-sm mt-1">{localErrors.kode}</p>}
                </div>
                <div className="relative">
                    <input
                        className={`bg-lightGray py-1 px-4 mt-1 rounded-sm border-2 ${
                            localErrors.password ? 'border-red-500' : 'border-dustyBlue'
                        } placeholder-dustyBlue w-full`}
                        type={passwordVisible ? 'text' : 'password'}
                        id="password"
                        value={values.password}
                        onChange={handleChange}
                        placeholder="Password"
                    />
                    <img
                        className="w-4 cursor-pointer absolute top-[55%] right-3 transform -translate-y-1/2"
                        src={passwordVisible ? eyeOpen : eyeClose}
                        alt="Toggle Password Visibility"
                        onClick={togglePasswordVisibility}
                    />
                    {localErrors.password && <p className="text-red-500 text-sm mt-1">{localErrors.password}</p>}
                </div>
                <ButtonOption order="register" mode={mode} />
            </form>
        </div>
    );
}
