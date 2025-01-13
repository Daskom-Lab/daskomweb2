import { useState } from "react";

export default function ModalConfigurePraktikum({ selectedShift, handleConfigure, setShowDetailsModal }) {
    const [showErrorModal, setShowErrorModal] = useState(false);

    const handleConfigureClick = () => {
        if (selectedShift) {
            handleConfigure();
        } else {
            setShowErrorModal(true);
        }
    };

    const handleCloseErrorModal = () => {
        setShowErrorModal(false);
    };

    return (
        <div>
            <div className="flex justify-center">
                <button
                    onClick={handleConfigureClick}
                    className="mt-6 w-96 py-2 bg-darkGreen text-white font-semibold rounded-lg shadow-md shadow-darkGreen hover:bg-darkGreen transition"
                >
                    Konfigure
                </button>
            </div>

            {/* Error Modal */}
            {showErrorModal && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-white p-6 rounded-lg w-96 text-center">
                        <h2 className="text-2xl font-bold mb-4 text-fireRed">WARNING!!</h2>
                        <p className="text-darkBrown text-lg font-semibold mb-4">Silakan lengkapi format praktikum !!</p>
                        <div className="flex justify-center mt-6">
                            <button
                                onClick={handleCloseErrorModal}
                                className="px-4 py-1 bg-rustyRed text-white font-semibold rounded-lg hover:bg-softRed"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
