export default function TablePelanggaran() {
  // Data dummy untuk tabel pelanggaran
  const dataPelanggaran = [
    { no: 1, nama: "John Doe", kode: "ALL", status: "Belum Input", jumlahBelumInput: 3 },
    { no: 2, nama: "Jane Smith", kode: "DEY", status: "Aman", jumlahBelumInput: 0 },
    { no: 3, nama: "Mark Johnson", kode: "FYN", status: "Belum Input", jumlahBelumInput: 1 },
    { no: 4, nama: "Emily Davis", kode: "GTY", status: "Aman", jumlahBelumInput: 0 },
    { no: 5, nama: "Chris Brown", kode: "CVX", status: "Belum Input", jumlahBelumInput: 2 },
    { no: 6, nama: "Alice Green", kode: "RPR", status: "Aman", jumlahBelumInput: 0 },
    { no: 7, nama: "Michael White", kode: "QTY", status: "Belum Input", jumlahBelumInput: 4 },
    { no: 8, nama: "Sarah Miller", kode: "SHR", status: "Aman", jumlahBelumInput: 0 },
    { no: 9, nama: "David Clark", kode: "STL", status: "Belum Input", jumlahBelumInput: 5 },
    { no: 10, nama: "Olivia Moore", kode: "OPL", status: "Aman", jumlahBelumInput: 0 },
  ];

  return (
    <div className="mt-5">
      {/* Header dengan div */}
      <div className="bg-deepForestGreen rounded-lg py-2 px-2 mb-2">
        <div className="grid grid-cols-4 gap-1">
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">No</h1>
          </div>
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Nama</h1>
          </div>
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Kode</h1>
          </div>
          <div className="bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1">
            <h1 className="font-bold text-white text-center">Status</h1>
          </div>
        </div>
      </div>

      {/* Kontainer untuk tabel scrollable */}
      <div className="overflow-x-auto max-h-96">
        {[...Array(10)].map((_, index) => (
          <div
            key={index}
            className="grid grid-cols-4 gap-1 bg-white border border-forestGreen py-1 px-2 mb-2 rounded-lg"
          >
            <div className="flex items-center justify-center h-full py-1 px-2 ">{index + 1}</div>
            <div className="flex items-center justify-center h-full py-1 px-2">Aliza Nurfitrian M</div>
            <div className="flex items-center justify-center h-full py-1 px-2">1101223083{index + 1}</div>
            <div
              className={`flex items-center justify-center h-full py-1 px-2 ${
                index % 2 === 0 ? "text-fireRed font-bold" : ""
              }`}
            >
              {index % 2 === 0 ? `Belum Input ${index + 1} Nilai` : "Aman"}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
