import { useState } from 'react';
import { router, usePage } from '@inertiajs/react';
import eyeClose from '../../../assets/form/eyeClose.png';
import eyeOpen from '../../../assets/form/eyeOpen.png';
import ButtonOption from '../../Components/ComponentsPraktikans/ButtonOption';
import Modal from '../../Components/ComponentsPraktikans/Modal';
import ModalForgotPass from '../../Components/ComponentsAssistants/ModalForgotPass';
import axios_client from '@/axios_client';

export default function LoginFormAssistant({ mode }) {
    const [values, setValues] = useState({
        kode: '',
        password: '',
    });

    const [passwordVisible, setPasswordVisible] = useState(false);
    const [isModalOpen, setIsModalOpen] = useState(false);

    // Access shared props from Inertia
    const { errors } = usePage().props;

    const togglePasswordVisibility = () => {
        setPasswordVisible((prevState) => !prevState);
    };

    const openModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value;
        setValues((values) => ({
            ...values,
            [key]: value,
        }));
    }

    // function handleSubmit(e) {
    //     e.preventDefault();

    //     // Perform login using Inertia's router
    //     router.post('/login/asisten', values, {
    //         preserveScroll: true, // Keeps the scroll position
    //         onFinish: () => {
                
    //             console.log('Login finished!');
    //         },
    //         onError: (errors) => {
    //             console.error('Validation Errors:', errors);
    //         },
    //     });
    // }
    function handleSubmit(e) {
    e.preventDefault();

    // Perform login using Inertia's router
    router.post('/login/asisten', values, {
        preserveScroll: true,
        onSuccess: (page) => {
            const token = page.props.auth?.token; // Adjust according to your server response
            if (token) {
                // Save the token (e.g., in localStorage)
                localStorage.setItem('token', token);

                // Set the default Authorization header
                axios_client.defaults.headers.common['Authorization'] = `Bearer ${token}`;

                console.log('Token set to Axios default header!');
            }
        },
        onError: (errors) => {
            console.error('Validation Errors:', errors);
        },
    });
}

    return (
        <div className="w-1/2 my-10 px-10">
            <h1 className="font-bold text-3xl text-darkGreen text-shadow-md text-center">
                WELCOME!
            </h1>
            <p className="font-bold text-lg text-center">
                Please login to start practicum.
            </p>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <div>
                    <input
                        className="bg-lightGray py-1 px-4 mt-10 rounded-sm border-dustyBlue border-2 placeholder-dustyBlue uppercase w-full"
                        type="text"
                        id="kode"
                        value={values.kode}
                        onChange={handleChange}
                        name="kode"
                        placeholder="B0T"
                        maxLength={3}
                    />
                    {errors.kode && (
                        <p className="text-red-500 text-sm mt-1">{errors.kode}</p>
                    )}
                </div>
                <div className="relative">
                    <input
                        className="bg-lightGray py-1 px-4 mt-1 w-full rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                        type={passwordVisible ? 'text' : 'password'}
                        id="password"
                        value={values.password}
                        onChange={handleChange}
                        name="password"
                        placeholder="Password"
                    />
                    <img
                        className="w-4 cursor-pointer absolute top-[55%] right-3 transform -translate-y-1/2"
                        src={passwordVisible ? eyeOpen : eyeClose}
                        alt="Toggle Password Visibility"
                        onClick={togglePasswordVisibility}
                    />
                    {errors.password && (
                        <p className="text-red-500 text-sm mt-1">{errors.password}</p>
                    )}
                </div>
                <ButtonOption order="login" mode={mode} />
            </form>
            <div className="relative my-3 text-right">
                <p
                    className="inline-block relative text-sm text-deepForestGreen font-semibold cursor-pointer group"
                    onClick={openModal}
                >
                    Forgot Password?
                    <span className="absolute bottom-[-1px] left-0 right-0 h-0.5 bg-deepForestGreenDark transform scale-x-0 origin-left transition-transform duration-300 group-hover:scale-x-100" />
                </p>
            </div>

            {isModalOpen && (
                <Modal isOpen={isModalOpen} onClose={closeModal} width="w-[370px]">
                    <ModalForgotPass />
                </Modal>
            )}
        </div>
    );
}
