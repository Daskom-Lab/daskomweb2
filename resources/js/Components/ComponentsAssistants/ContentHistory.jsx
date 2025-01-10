import TableHistory from "./TableHistory"

export default function ContentHistory() {
    return (
        <section>
            {/*  hisoty praktikum */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-14">History Praktikum</h6>
                </div>

            </div>

            {/* Table data history praktikum */}
            <div className="">
                <TableHistory />
            </div>
        </section>
    )
}