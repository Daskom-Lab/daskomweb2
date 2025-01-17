import { useState } from "react";
import ButtonResetPelanggaran from "./ModalReserPelanggaran";
import TablePelanggaran from "./TablePelanggaran";

export default function ContentPelanggaran() {
    const [showModalReset, setShowModalReset] = useState(false); 

    const handleOpenModalReset = () => setShowModalReset(true);
    const handleCloseModalReset = () => setShowModalReset(false);

    return (
        <section>
            {/* button pelanggaran */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md ">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-24">Pelanggaran Assistant</h6>
                </div>

                 {/* Button Reset Plottingan */}
                 <button
                    onClick={handleOpenModalReset}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Pelanggaran
                </button>
            </div>

            {/* Table data pelanggaran */}
            <div className="">
                <TablePelanggaran />
            </div>

            {/* Modal Reset Plottingan */}
                        {showModalReset && <ButtonResetPelanggaran onClose={handleCloseModalReset} />} 
        </section>
    );
}
