import React from 'react';
import { contactData } from '../../Components/ComponentsAssistants/ContactData';
import iconLine from '../../../assets/contact/iconLine.svg'; 

export default function ModalForgotPass() {
    const oaData = contactData.find(data => data.name === "Official Account (OA)");

    return (
        <div className='flex flex-col items-center justify-center'>
            <h1 className="mt-7 text-2xl font-bold">Please Contact:</h1>
            <p className="mt-4 font-bold">Official Account (OA)</p>
            <div className="flex items-center space-x-2 mt-2 mb-10">
                {oaData.details.filter(detail => detail.src === iconLine).map((detail, index) => (
                    <div key={index} className="flex items-center">
                        <img className="w-6 h-6 mr-2" src={detail.src} alt="Line Icon" />
                        <span className="text-sm">{detail.text}</span>
                    </div>
                ))}
            </div>
        </div>
    );
}