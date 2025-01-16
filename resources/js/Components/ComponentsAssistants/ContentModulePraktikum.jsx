import { useState } from "react";
import ButtonAddModule from "./ModalAddModule";
import ButtonResetModule from "./ModalResetModule";
import TabelModulePraktikum from "./TabelModulePraktikum";

export default function ContentModulePraktikum() {
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
                        Modul Praktikum
                    </h6>
                </div>

                {/* Button Add modull */}
                <button
                    onClick={handleOpenModal}
                    className="text-darkBrown text-md font-semibold px-4 py-1 border-2 border-darkBrown rounded-md shadow-md hover:bg-softBrown transition"
                >
                    + Modul
                </button>

                {/* Button Reset modul */}
                <button
                    onClick={handleOpenModalReset}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Modul
                </button>
            </div>

            {/* List per module */}
            <div className="">
                <TabelModulePraktikum />
            </div>

            {/* per modalan */}
            {showModal && <ButtonAddModule onClose={handleCloseModal} />}
            {showModalReset && <ButtonResetModule onClose={handleCloseModalReset} />}
        </section>
    );
}
