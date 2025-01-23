import iconSuccess from '../../../assets/modal/successSymbol.png';

export default function ModalSuccessData({ isVisible }) {
    if (!isVisible) {
        return null; 
    }

    return (
        <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
            <div className="bg-white w-[30vw] h-[32vh] p-6 rounded-md shadow-md text-center">
                <img
                    className="mt-3 h-20 w-20 mx-auto mb-4"
                    src={iconSuccess}
                    alt="Success"
                />
                <h1 className="text-xl font-bold">Berhasil Disimpan!</h1>
            </div>
        </div>
    );
}