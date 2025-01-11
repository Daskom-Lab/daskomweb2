export default function ModalJawabanTP({ onClose }) {
    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-6 rounded shadow-lg w-3/4 relative">
                {/* Tombol X untuk tutup dengan background merah */}
                <button
                    onClick={onClose}
                    className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-red-700 rounded-md w-8 h-8 flex justify-center items-center"
                >
                    ✕
                </button>

                {/* kelas - tanggal */}
                <h4 className="text-lg text-darkBrown font-semibold mb-4">101022430007 [Deo Ferdiyansyah] | [10/12/2024, 11.43.17]</h4>

                {/* Garis pemisah */}
                <hr className="border-t-2 border-darkBrown mb-4" />

                {/* isi laporan + judul */}
                <div className="max-h-96 overflow-y-auto">
                    <h2 className="text-xl font-bold text-black underline text-center mb-4">Pengantar Algoritma dan Pemrograman</h2>
                    {/* Card Wrapper */}
                    <div className="space-y-4 max-h-[400px]">
                        {/* Card 1 */}
                        <div className="p-4 bg-gray-200 rounded-lg shadow-md">
                            <h3 className="font-semibold">
                                1. Jelaskan apa yang dimaksud dengan tipe data bentukan dan buatkan contohnya!
                            </h3>
                            <div className="mt-2 p-3 bg-gray-100 rounded-md shadow-inner">
                                <p className="text-sm">
                                    Tipe bentukan adalah tipe data yang dibuat sendiri oleh pengguna. Tipe ini dibuat karena ada relasi antar
                                    variabel yang bila digabungkan mempunyai suatu maksud yang sama.
                                </p>
                                <pre className="mt-2 bg-gray-300 p-2 rounded-md text-sm">
                                    {`struct {
                char nama, nim;
                int nilai;
                } data;`}
                                </pre>
                            </div>
                        </div>

                        {/* Card 2 */}
                        <div className="p-4 bg-gray-200 rounded-lg shadow-md">
                            <h3 className="font-semibold">
                                2. Jelaskan apa perbedaan ‘int’ dan ‘float’ dalam bahasa C!
                            </h3>
                            <div className="mt-2 p-3 bg-gray-100 rounded-md shadow-inner">
                                <p className="text-sm">
                                    Perbedaan antara int dan float ada pada tipe data yang disimpan, int menyimpan tipe data angka yang bernilai
                                    bulat seperti 1, 2, 3. Sedangkan float menyimpan tipe data angka yang bernilai desimal seperti 1.0, 1.2, 1.3
                                </p>
                            </div>
                        </div>

                        {/* Tambahkan lebih banyak kartu jika diperlukan */}
                        <div className="p-4 bg-gray-200 rounded-lg shadow-md">
                            <h3 className="font-semibold">3. Contoh soal apa ya. sebutkan apa itu vs code</h3>
                            <div className="mt-2 p-3 bg-gray-100 rounded-md shadow-inner">
                                <p className="text-sm">ini jawaban nya apa ya wkkwkw</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    );
}
