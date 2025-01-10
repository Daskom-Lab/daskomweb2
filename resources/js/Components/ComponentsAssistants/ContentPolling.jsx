import React, { useState } from "react";
import DropdownPolling from "./DropdownPolling";
import ButtonResetPolling from "./ModalResetPolling";
import TablePolling from "./TablePolling";

export default function ContentPolling() {
    const [showModalResetPolling, setShowModalResetPolling] = useState(false);

    const handleOpenModalResetPolling = () => setShowModalResetPolling(true);
    const handleCloseModalResetPolling = () => setShowModalResetPolling(false);

    return (
        <section>
            {/* button praktikan - kelas */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-32">Assistant</h6>
                </div>

                {/* Panggil komponen dropdown */}
                <DropdownPolling />

                {/* Button Reset Polling */}
                <button
                    onClick={handleOpenModalResetPolling}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Polling
                </button>
            </div>

            {/* Table data polling */}
            <div className="">
                <TablePolling />
            </div>

            {/* Modal Reset polling */}
            {showModalResetPolling && <ButtonResetPolling onClose={handleCloseModalResetPolling} />}
        </section>
    );
}
