import { useState } from "react";

export default function ModalSoftware() {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleModalToggle = () => {
    setIsModalOpen(!isModalOpen);
  };

  return (
    <div className="relative">
      {/* Tombol di pojok kanan bawah */}
      <button
        onClick={handleModalToggle}
        className="fixed bottom-4 right-4 bg-deepForestGreen text-white p-3 rounded-full shadow-md shadow-black hover:bg-darkGreen transition duration-300"
      >
        <span className="text-2xl">👨‍💻</span> {/* Icon bisa diganti */}
      </button>

      {/* Modal untuk informasi */}
      {isModalOpen && (
        <div className="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
          <div className="bg-white p-6 rounded-lg w-96 shadow-lg">
            <h2 className="text-xl font-bold text-deepForestGreen">Informasi Kontak</h2>
            <p className="mt-4 text-darkBrown">
              Jika Anda mengalami masalah atau memiliki pertanyaan tentang website, silakan hubungi:
            </p>
            <p className="mt-4 text-lg font-bold">Software - ALL: 0822-4048-2882 (WA)</p>
            <div className="flex justify-end mt-6">
              <button
                onClick={handleModalToggle}
                className="bg-deepForestGreen text-white px-3 py-2 rounded-md hover:bg-darkGreen transition duration-300"
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
