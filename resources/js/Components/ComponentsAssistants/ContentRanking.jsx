import DropdownKelasRanking from "./DropdownKelasRanking";
import TableRanking from "./TableRanking";

export default function ContentRanking() {
    return (
        <section>
            {/* button praktikan - kelas */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-32">Praktikan</h6>
                </div>

                {/* Panggil komponen dropdown */}
                <DropdownKelasRanking />
            </div>

            {/* Table data rangking */}
            <div className="">
                <TableRanking />
            </div>
        </section>
    );
}
