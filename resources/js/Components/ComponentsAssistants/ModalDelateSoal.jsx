export default function ModalDelateSoal({ onClose, message }) {
    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div className="bg-softGray p-6 rounded-lg shadow-xl w-96 text-center relative">
                {/* Pesan sukses */}
                <h3 className="text-2xl font-bold text-fireRed mt-2">
                    Soal berhasil dihapus
                </h3>

                {/* Tombol Tutup */}
                <div className="mt-6 flex justify-center">
                    <button
                        onClick={onClose}
                        className="text-md font-bold text-white bg-redredDark hover:bg-softRed rounded-md px-6 py-1"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    );
}
