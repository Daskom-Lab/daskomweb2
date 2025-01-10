import React, { useState } from "react";
import ButtonAddPlotting from "./ModalAddPlotting";
import ButtonResetPlotting from "./ModalResetPlottingan";
import TablePlottingan from "./TablePlottingan";

export default function ContentPlottingan() {
    const [showModal, setShowModal] = useState(false);
    const [showModalReset, setShowModalReset] = useState(false); 

    const handleOpenModal = () => setShowModal(true);
    const handleCloseModal = () => setShowModal(false);

    const handleOpenModalReset = () => setShowModalReset(true);
    const handleCloseModalReset = () => setShowModalReset(false);

    return (
        <section>
            {/* Button Praktikan - Kelas */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-16">
                        Plotting Jadwal Assistant
                    </h6>
                </div>

                {/* Button Add Jadwal */}
                <button
                    onClick={handleOpenModal}
                    className="text-darkBrown text-md font-semibold px-4 py-1 border-2 border-darkBrown rounded-md shadow-md hover:bg-softBrown transition"
                >
                    + Jadwal
                </button>

                {/* Button Reset Plottingan */}
                <button
                    onClick={handleOpenModalReset}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Plottingan
                </button>
            </div>

            {/* Table Data Plottingan */}
            <div className="">
                <TablePlottingan />
            </div>

            {/* Modal Add Jadwal */}
            {showModal && <ButtonAddPlotting onClose={handleCloseModal} />}

            {/* Modal Reset Plottingan */}
            {showModalReset && <ButtonResetPlotting onClose={handleCloseModalReset} />} 
        </section>
    );
}
