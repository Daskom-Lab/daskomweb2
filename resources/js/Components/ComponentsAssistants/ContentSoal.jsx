import SoalInputForm from "./FormInputSoal";

export default function ContentSoal() {
    return (
        <section>
            {/* header input soal */}
            <div className="flex gap-4 items-start">
                <div className="border-2 border-darkBrown rounded-md shadow-md">
                    <h6 className="text-lg text-darkBrown text-left py-1 font-bold px-14">
                        Manage Soal
                    </h6>
                </div>
            </div>

            {/* all dropdown input soal */}
            <div className="flex gap-5 mt-4 items-start border-2 border-darkBrown rounded-md shadow-md">
                {/* Panggil komponen dropdown jenis soal */}
                <div className="overflow-y-auto h-96 w-full"> 
                    <SoalInputForm />
                </div>
            </div>
        </section>
    );
}
