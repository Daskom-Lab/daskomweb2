import { useState } from "react";
import DropdownLaporanModul from "./DropdownLaporanModul"
import ButtonResetLaporan from "./ModalResetLaporan";
import TableLaporan from "./TableLaporan"

export default function ContentLaporan() {
    const [showModalResetLaporan, setShowModalResetLaporan] = useState(false);

    const handleOpenModalResetLaporan = () => setShowModalResetLaporan(true);
    const handleCloseModalResetLaporan = () => setShowModalResetLaporan(false);

    return (
        <section>
            {/*  laporan praktikum */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-14">Laporan Praktikum</h6>
                </div>

                {/* Panggil komponen dropdown */}
                <DropdownLaporanModul />

                {/* Button Reset laporan */}
                <button
                    onClick={handleOpenModalResetLaporan}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Laporan
                </button>
            </div>

            {/* Table data laporan */}
            <div className="">
                <TableLaporan />
            </div>

            {/* Modal Reset Laporan */}
            {showModalResetLaporan && <ButtonResetLaporan onClose={handleCloseModalResetLaporan} />}
        </section>
    )
}