export default function TablePelanggaran() {
    // Data dummy untuk tabel pelanggaran
    const dataPelanggaran = [
      { no: 1, nama: "John Doe", kode: "ALL", status: "Belum Input", jumlahBelumInput: 3 },
      { no: 2, nama: "Jane Smith", kode: "DEY", status: "Aman", jumlahBelumInput: 0 },
      { no: 3, nama: "Mark Johnson", kode: "FYN", status: "Belum Input", jumlahBelumInput: 1 },
    ];
  
    return (
      <div className="mt-5">
        {/* Kontainer scroll tabel */}
        <div className="overflow-x-auto">
          <div className="max-h-[400px] overflow-y-auto border border-forestGreen rounded-md">
            <table className="min-w-full table-auto border-collapse">
              <thead>
                <tr className="bg-deepForestGreen text-md text-center text-white">
                  <th className="py-2 px-7 border-b">No</th>
                  <th className="py-2 px-7 border-b">Nama</th>
                  <th className="py-2 px-7 border-b">Kode</th>
                  <th className="py-2 px-7 border-b">Status</th>
                </tr>
              </thead>
              <tbody className="bg-softIvory">
                {dataPelanggaran.map((item, index) => (
                  <tr key={index} className="text-darkBrown">
                    <td className="py-2 px-4 border-b text-center">{item.no}</td>
                    <td className="py-2 px-4 border-b">{item.nama}</td>
                    <td className="py-2 px-4 border-b text-center">{item.kode}</td>
                    <td
                      className={`py-2 px-4 border-b text-center ${
                        item.status === "Belum Input" ? "text-red-600 font-bold" : ""
                      }`}
                    >
                      {item.status === "Belum Input"
                        ? `Belum Input ${item.jumlahBelumInput} Nilai`
                        : "Aman"}
                    </td>
                  </tr>
                ))}
                {/* baris dummy untuk uji scroll */}
                {Array.from({ length: 10 }).map((_, index) => (
                  <tr key={index + dataPelanggaran.length} className="text-darkBrown">
                    <td className="py-2 px-4 border-b text-center">{index + 4}</td>
                    <td className="py-2 px-4 border-b">Nama {index + 4}</td>
                    <td className="py-2 px-4 border-b text-center">KODE{index + 1}</td>
                    <td
                      className={`py-2 px-4 border-b text-center ${
                        index % 2 === 0 ? "text-red-600 font-bold" : ""
                      }`}
                    >
                      {index % 2 === 0
                        ? `Belum Input ${index + 1} Nilai`
                        : "Aman"}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }
  