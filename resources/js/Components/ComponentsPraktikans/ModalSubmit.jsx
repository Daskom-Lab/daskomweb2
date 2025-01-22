import { useState } from "react";
import Modal from "./Modal";
import ModalFeedback from "./ModalFeedback";

export default function ModalSubmit({ isOpen, onClose, onConfirm, activeTask }) {
    const [isFeedbackModalOpen, setIsFeedbackModalOpen] = useState(false);

    const handleConfirm = () => {
        if (activeTask === "TesKeterampilan") {
            console.log("Opening Feedback Modal for TesKeterampilan");
            setIsFeedbackModalOpen(true);
        } else {
            onConfirm(); 
        }
    };

    const closeFeedbackModal = () => {
        setIsFeedbackModalOpen(false);
        onConfirm();
    };

    if (!isOpen) return null;

    return (
        <div className="flex flex-col items-center justify-center z-50">
            <h1 className="mt-8 font-bold text-2xl">Finish Attempt?</h1>
            <div className="flex mt-4 mb-7 items-center justify-between">
                <button
                    className="mx-2 py-1 px-7 bg-deepForestGreen text-white text-lg font-bold rounded-sm shadow-sm shadow-black hover:bg-deepForestGreenDark hover:shadow-white"
                    onClick={onClose}
                >
                    Tidak
                </button>
                <button
                    className="mx-2 py-1 px-10 bg-softRed text-white text-lg font-bold rounded-sm shadow-sm shadow-black hover:bg-darkRed hover:shadow-white"
                    onClick={handleConfirm}
                >
                    Ya
                </button>
            </div>

            {isFeedbackModalOpen && (
                <Modal
                    isOpen={true}
                    onClose={closeFeedbackModal}
                    width="w-[57vw] h-[57vh]"
                >
                    <ModalFeedback onClose={closeFeedbackModal} />
                </Modal>
            )}
        </div>
    );
}