import DropdownPolling from "./DropdownPolling";
import TablePolling from "./TablePolling";

export default function ContentPolling() {
    return (
        <section>
            {/* button praktikan - kelas */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-32">Assistant</h6>
                </div>

                {/* Panggil komponen dropdown */}
                <DropdownPolling />
            </div>

            {/* Table data polling */}
            <div className="">
                <TablePolling />
            </div>
        </section>
    );
}
