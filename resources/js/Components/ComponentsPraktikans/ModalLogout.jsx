export default function ModalLogout({ onClose }) {
    const handleLogout = () => {
        localStorage.clear();
        window.location.href = '/login'; 
    };

    return (
        <div className='flex flex-col items-center justify-center'>
            <h1 className="mt-8 font-bold text-2xl">Apakah Kamu Yakin?</h1>
            <div className="flex mt-4 mb-7 items-center justify-between">
                <button
                    className="mx-2 py-1 px-7 bg-deepForestGreen text-white text-lg font-bold rounded-sm shadow-sm shadow-black hover:bg-deepForestGreenDark hover:shadow-white"
                    onClick={onClose} 
                >
                    Tidak
                </button>
                <button
                    className="mx-2 py-1 px-10 bg-softRed text-white text-lg font-bold rounded-sm shadow-sm shadow-black hover:bg-darkRed hover:shadow-white"
                    onClick={handleLogout} 
                >
                    Ya
                </button>
            </div>
        </div>
    );
}