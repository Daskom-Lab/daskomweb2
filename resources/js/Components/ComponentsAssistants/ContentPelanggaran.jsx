import React, { useState } from "react";
import ButtonResetPelanggaran from "./ModalResetPelanggaran";
import TablePelanggaran from "./TablePelanggaran";

export default function ContentPelanggaran() {
    const [showModalResetPelanggaran, setShowModalResetPelanggaran] = useState(false);

    const handleOpenModalResetPelanggaran = () => setShowModalResetPelanggaran(true);
    const handleCloseModalResetPelanggaran = () => setShowModalResetPelanggaran(false);
    return (
        <section>
            {/* button pelanggaran */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-24">Pelanggaran Assistant</h6>
                </div>

                {/* Button Reset Pelanggaran */}
                <button
                    onClick={handleOpenModalResetPelanggaran}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Pelanggaran
                </button>
            </div>

            {/* Table data pelanggaran */}
            <div className="">
                <TablePelanggaran />
            </div>
            {/* Modal Reset pelanggaran */}
            {showModalResetPelanggaran && <ButtonResetPelanggaran onClose={handleCloseModalResetPelanggaran} />}
        </section>
    );
}
