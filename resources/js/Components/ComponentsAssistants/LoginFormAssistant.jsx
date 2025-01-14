import React, { useState } from 'react';
import eyeClose from '../../../assets/form/eyeClose.png';
import eyeOpen from '../../../assets/form/eyeOpen.png';
import ButtonOption from '../../Components/ComponentsPraktikans/ButtonOption';
import Modal from '../../Components/ComponentsPraktikans/Modal';
import ModalForgotPass from '../../Components/ComponentsAssistants/ModalForgotPass';

export default function LoginFormAssistant({ mode }) {
    const [passwordVisible, setPasswordVisible] = useState(false); 
    const [isModalOpen, setIsModalOpen] = useState(false); 

    const togglePasswordVisibility = () => {
        setPasswordVisible(prevState => !prevState);
    };

    const openModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    return (
        <div className="w-1/2 my-10 px-10">
            <h1 className="font-bold text-3xl text-darkGreen text-shadow-md text-center">WELCOME!</h1>
            <p className="font-bold text-lg text-center">Please login to start practicum.</p>
            <form className="flex flex-col gap-4">
                <input
                    className="bg-lightGray py-1 px-4 mt-10 rounded-sm border-dustyBlue border-2 placeholder-dustyBlue uppercase"
                    type="text"
                    name="assistantCode"
                    placeholder="B0T"
                    maxLength={3}
                />
                <div className="relative">
                    <input
                        className="bg-lightGray py-1 px-4 mt-1 w-full rounded-sm border-dustyBlue border-2 placeholder-dustyBlue"
                        type={passwordVisible ? 'text' : 'password'}
                        name="password"
                        placeholder="Password"
                        id="password"
                    />
                    <img
                        className="w-4 cursor-pointer absolute top-[55%] right-3 transform -translate-y-1/2"
                        src={passwordVisible ? eyeOpen : eyeClose}
                        alt="Toggle Password Visibility"
                        onClick={togglePasswordVisibility}
                    />
                </div>
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
            <ButtonOption order="login" mode={mode} />

            {isModalOpen && (
                <Modal isOpen={isModalOpen} onClose={closeModal} width="w-[370px]">
                    <ModalForgotPass />
                </Modal>
            )}
        </div>
    );
}