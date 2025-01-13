import TableNilai from "./TableNilai";

export default function ContentNilaiPraktikan() {
    return (
        <section>
            {/* button nilai */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-16">Input Nilai Praktikan</h6>
                </div>

            </div>

            {/* Table data nilai */}
            <div className="">
                <TableNilai />
            </div>

        </section>
    );
}
