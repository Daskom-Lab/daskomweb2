export default function ContentLihatTP() {
    return (
        <div className="flex justify-center items-center">
            {/* Container */}
            <div className="w-full max-w-3xl p-4 space-y-6 bg-softIvory rounded-md shadow-lg shadow-deepForestGreen">
                {/* Card Wrapper */}
                <div className="space-y-4 max-h-[400px] overflow-y-auto">
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
    );
}
