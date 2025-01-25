import { useState } from "react";

export default function ModalFeedback({ onClose }) {
    const [feedbackText, setFeedbackText] = useState("");
    const [selectedAsisten, setSelectedAsisten] = useState("");
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);

    const assistants = [
        "FYN | Muh Zaidan Fauzan",
        "NYF | Fauzan, Muh Zaidan",
        "YNF | Zaidan",
        "NFY | Fauzan",
        "NFY | Fauzan 5",
        "NFY | Fauzan 6",
        "NFY | Fauzan 7",
        "NFY | Fauzan 8",
        "NFY | Fauzan 9",
        "NFY | Fauzan 10",
    ];

    const handleDropdownToggle = () => {
        setIsDropdownOpen((prev) => !prev);
    };

    const handleOptionSelect = (assistant) => {
        setSelectedAsisten(assistant);
        setIsDropdownOpen(false);
    };

    const handleSubmit = () => {
        onClose();
    };

    return (
        <div className="mt-[4vh] bg-white rounded-lg shadow-xl p-6 w-full h-[46vh] z-[999] overflow-auto">
            <div className="mb-4">
                <div className="relative">
                    <div
                        className="block mx-auto w-[45vw] p-2 font-bold border border-gray-300 rounded text-center cursor-pointer bg-white"
                        onClick={handleDropdownToggle}
                    >
                        {selectedAsisten || "Asisten"}
                    </div>

                    {isDropdownOpen && (
                        <ul
                            className="absolute ml-7 z-10 bg-white border border-gray-300 rounded max-h-[30vh] overflow-y-auto w-[45vw] left-0 top-full mt-1"
                        >
                            {assistants.map((assistant, index) => (
                                <li
                                    key={index}
                                    className="p-2 hover:bg-gray-200 cursor-pointer font-semibold text-left"
                                    onClick={() => handleOptionSelect(assistant)}
                                >
                                    {assistant}
                                </li>
                            ))}
                        </ul>
                    )}
                </div>
            </div>

            <div className="mb-4">
                <label htmlFor="feedback" className="mt-[3vh] block font-bold mb-1 text-center">
                    Feedback
                </label>
                <textarea
                    id="feedback"
                    value={feedbackText}
                    onChange={(e) => setFeedbackText(e.target.value)}
                    className="block mx-auto w-[45vw] h-[15vh] border border-gray-300 rounded p-2 resize-none"
                    placeholder="Silahkan isi feedback nya ^_^"
                />
            </div>

            <div className="flex justify-center mt-4">
                <button
                    onClick={handleSubmit}
                    className="px-4 py-1 bg-deepForestGreen text-white rounded font-bold hover:bg-darkOliveGreen transition"
                >
                    Submit
                </button>
            </div>
        </div>
    );
}