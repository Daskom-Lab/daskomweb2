import DropdownListKelas from "./DropdownListKelas";
import TabelStartPraktikum from "./TabelStartPraktikum";

export default function ContentModulePraktikum() {

    return (
        <section>
            {/* Button Praktikan - Kelas */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md">
                    <h6 className="text-md text-darkBrown text-center py-1 font-semibold px-16">
                        Start Praktikum
                    </h6>
                </div>

                {/* Dropdown kelas */}
                <DropdownListKelas />

            </div>

            {/* List per module */}
            <div className="">
                <TabelStartPraktikum />
            </div>
        </section>
    );
}
