export default function ModalSubmit({ isOpen, onClose, onConfirm }) {
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
                    onClick={onConfirm}
                >
                    Ya
                </button>
            </div>
        </div>
    );
}