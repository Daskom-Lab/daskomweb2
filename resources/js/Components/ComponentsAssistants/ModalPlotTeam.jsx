export default function ModalPlotTeam({ onClose }) {
    // Exm data
    const exampleData = [
        { kelas: "TT-46-09", shift: 1, kelompok: 1, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 2, kodeAsisten: "DHY" },
        { kelas: "TT-46-09", shift: 1, kelompok: 3, kodeAsisten: "KOH" },
        { kelas: "TT-46-09", shift: 1, kelompok: 4, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 5, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 6, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 7, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 8, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 9, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 10, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 11, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 12, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 13, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 14, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 15, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 16, kodeAsisten: "ALL" },
        { kelas: "TT-46-09", shift: 1, kelompok: 17, kodeAsisten: "ALL" },
    ];

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            {/* Main Modal */}
            <div className="bg-white rounded-lg p-6 w-[800px] h-[500px] overflow-y-auto shadow-xl relative transform transition-all duration-300 ease-in-out scale-95 hover:scale-100">
                {/* Header */}
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-2xl font-bold text-darkGreen">
                        {exampleData[0]?.kelas} - Shift {exampleData[0]?.shift}
                    </h2>
                    {/* Close Button */}
                    <button
                        onClick={onClose}
                        className="absolute top-2 right-2 text-2xl font-bold text-white bg-rustyRed hover:bg-softRed rounded-md w-9 h-9 flex justify-center items-center"
                    >
                        ×
                    </button>
                </div>

                {/* Schedule Table */}
                <div className="overflow-y-auto">
                    <div className="flex space-x-6">
                        {/* Left Column (Table 1) */}
                        <div className="w-1/2 bg-white rounded-lg shadow-lg overflow-hidden">
                            <table className="min-w-full table-auto">
                                <thead className="bg-darkGreen text-white">
                                    <tr>
                                        <th className="px-6 py-3 text-left border-b-2">Kelompok</th>
                                        <th className="px-6 py-3 text-left border-b-2">Kode Asisten</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {exampleData.slice(0, 9).map((item, index) => (
                                        <tr key={index} className={`border-b hover:bg-gray-200 transition duration-300 ${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'}`}>
                                            <td className="px-6 py-4">{item.kelompok}</td>
                                            <td className="px-6 py-4">{item.kodeAsisten}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {/* Right Column (Table 2) */}
                        <div className="w-1/2 bg-white rounded-lg shadow-lg overflow-hidden">
                            <table className="min-w-full table-auto">
                                <thead className="bg-darkGreen text-white">
                                    <tr>
                                        <th className="px-6 py-3 text-left border-b-2">Kelompok</th>
                                        <th className="px-6 py-3 text-left border-b-2">Kode Asisten</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {exampleData.slice(9).map((item, index) => (
                                        <tr key={index} className={`border-b hover:bg-gray-200 transition duration-300 ${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'}`}>
                                            <td className="px-6 py-4">{item.kelompok}</td>
                                            <td className="px-6 py-4">{item.kodeAsisten}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
