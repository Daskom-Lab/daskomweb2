import DropdownTPModul from "./DropdownTPModul";
import { FaSearch } from "react-icons/fa";
import { useState } from "react";

export default function BarSearchingTP() {
    // State untuk program (Reguler atau Internasional)
    const [program, setProgram] = useState("Reguler");

    // Event handler untuk mengubah program
    const handleProgramChange = (e) => {
        setProgram(e.target.value);
    };

    return (
        <div className="flex flex-col items-center space-y-6 p-6 bg-softIvory shadow-lg shadow-deepForestGreen rounded-lg">
            {/* Header */}
            <h2 className="text-2xl font-bold text-deepForestGreen">
                Cari Informasi Praktikum
            </h2>
            <p className="text-gray-500 text-center">
                Pilih program, masukkan NIM, dan pilih modul yang sesuai
            </p>

            {/* Pilih Program */}
            <div className="w-full flex flex-col space-y-4 items-center">
                <div className="flex flex-col items-start w-80">
                    <label htmlFor="program" className="text-gray-600 font-medium mb-1">
                        Pilih Program
                    </label>
                    <select
                        id="program"
                        value={program}
                        onChange={handleProgramChange}
                        className="w-full px-4 py-2 text-gray-600 bg-gray-200 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-deepForestGreen"
                    >
                        <option value="Reguler">Reguler</option>
                        <option value="Internasional">Internasional</option>
                    </select>
                </div>

                {/* Input Field */}
                <input
                    type="number"
                    placeholder="NIM"
                    className="w-80 px-4 py-2 text-center text-gray-600 bg-gray-200 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-deepForestGreen"
                />

                {/* Dropdown Modul */}
                <DropdownTPModul program={program} />
            </div>

            {/* Search Button */}
            <button className="flex items-center justify-center w-40 px-4 py-2 font-semibold text-white bg-deepForestGreen rounded-md shadow-md hover:bg-darkGreen active:scale-95 transition-all">
                <span className="text-center">Search</span>
            </button>

        </div>
    );
}
