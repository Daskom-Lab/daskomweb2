export default function ModalChangePassSuccess() {
    const handleLoginClick = () => {
        window.location.href = '/login';
    };

    return (
        <div className="flex flex-col items-center justify-center">
            <h1 className="mt-10 text-xl font-bold">Password Berhasil Disimpan!</h1>
            <button
                className="w-[270px] mt-5 p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm mb-3 hover:bg-deepForestGreenDark duration-300"
                onClick={handleLoginClick}
            >
                Masuk
            </button>
        </div>
    );
}