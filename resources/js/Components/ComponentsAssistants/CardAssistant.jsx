import { useState } from "react";
import ModalEditProfile from "./ModalEditProfile";
import iconWA from "../../../assets/contact/iconWhatsapp.svg";
import iconLine from "../../../assets/contact/iconLine.svg";
import iconIG from "../../../assets/contact/iconInstagram.svg";
import editIcon from "../../../assets/nav/Icon-Edit.svg"

export default function CardAssistant() {
    const [isModalOpen, setModalOpen] = useState(false);

    const handleOpenModal = () => setModalOpen(true);
    const handleCloseModal = () => setModalOpen(false);

    return (
        <>
            <div className="flex justify-center items-center">
                <div className="bg-softIvory w-[450px] h-[500px] p-4 rounded-lg shadow-lg shadow-deepForestGreen text-center">
                    {/* Edit Button */}
                    <div className="flex justify-end items-center space-x-2">
                        <img
                            className="w-6"
                            src={editIcon}
                            alt="iconEdit"
                        />
                        <button
                            className="text-black underline"
                            onClick={handleOpenModal}
                        >
                            Edit
                        </button>
                    </div>

                    {/* Profile Picture */}
                    <img
                        src="https://via.placeholder.com/300"
                        alt="Dhea Aisyah Putri"
                        className="w-40 h-40 mx-auto rounded-full object-cover border-2"
                    />

                    {/* Name and Rating */}
                    <h2 className="text-xl font-bold mt-2">Dhea Aisyah Putri</h2>
                    <div className="flex justify-center items-center text-yellow-500 mt-1">
                        {Array(5).fill(0).map((_, index) => (
                            <span key={index} className="text-4xl">★</span>
                        ))}
                    </div>

                    {/* Description */}
                    <p className="text-md font-normal text-black mt-2">
                        I'm a senior practicum assistant at Daskom Laboratory.
                        Nice to meet you!!
                    </p>

                    {/* Contact Info */}
                    <div className="mt-4 space-y-1">
                        <div className="flex items-center justify-center space-x-2">
                            <img className="w-6" src={iconWA} alt="iconWA" />
                            <span className="text-black">081250770473</span>
                        </div>
                        <div className="flex items-center justify-center space-x-2">
                            <img className="w-6" src={iconLine} alt="iconLine" />
                            <span className="text-black">@dheaisyyy</span>
                        </div>
                        <div className="flex items-center justify-center space-x-2">
                            <img className="w-6" src={iconIG} alt="iconIG" />
                            <span className="text-black">@dheaaishyyy_</span>
                        </div>
                    </div>

                    {/* Footer */}
                    <div className="mt-4 bg-forestGreen text-white text-xl font-bold py-1 rounded-md">
                        Creative Media Development
                    </div>
                </div>
            </div>

            {/* Modal */}
            <ModalEditProfile isOpen={isModalOpen} onClose={handleCloseModal} />
        </>
    );
}
