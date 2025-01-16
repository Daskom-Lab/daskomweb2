import DropdownLaporanModul from "./DropdownLaporanModul"
import TableLaporan from "./TableLaporan"

export default function ContentLaporan() {
    return (
        <section>
            {/*  laporan praktikum */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-14">Laporan Praktikum</h6>
                </div>

                {/* Panggil komponen dropdown */}
                <DropdownLaporanModul />
            </div>

            {/* Table data laporan */}
            <div className="">
                <TableLaporan />
            </div>
        </section>
    )
}