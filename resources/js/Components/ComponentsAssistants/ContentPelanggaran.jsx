import TablePelanggaran from "./TablePelanggaran";

export default function ContentPelanggaran() {
    return (
        <section>
            {/* button pelanggaran */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-24">Pelanggaran Assistant</h6>
                </div>
            </div>

            {/* Table data pelanggaran */}
            <div className="">
                <TablePelanggaran />
            </div>
        </section>
    );
}
