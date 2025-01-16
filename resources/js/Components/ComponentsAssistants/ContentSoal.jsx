import { useState } from "react";
import SoalInputForm from "./FormInputSoal";
import ButtonResetInputSoal from "./ModalResetInputSoal";

export default function ContentSoal() {
    const [showModalReset, setShowModalReset] = useState(false);

    const handleOpenModalReset = () => setShowModalReset(true);
    const handleCloseModalReset = () => setShowModalReset(false);

    return (
        <section>
            {/* header input soal */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md">
                    <h6 className="text-lg text-darkBrown text-left py-1 font-bold px-14">
                        Manage Soal
                    </h6>
                </div>

                {/* Button Reset Plottingan */}
                <button
                    onClick={handleOpenModalReset}
                    className="text-white text-md font-semibold px-4 py-1 rounded-md shadow-md bg-redredDark hover:bg-rustyRed transition mt-[2px]"
                >
                    Reset Soal
                </button>
            </div>

            {/* all dropdown input soal */}
            <div className="flex gap-5 mt-4 items-start border-2 border-darkBrown rounded-md shadow-md">
                {/* Panggil komponen dropdown jenis soal */}
                <div className="overflow-y-auto h-96 w-full">
                    <SoalInputForm />
                </div>
            </div>

            {/* Modal Reset input soal */}
                        {showModalReset && <ButtonResetInputSoal onClose={handleCloseModalReset} />} 
        </section>
    );
}
