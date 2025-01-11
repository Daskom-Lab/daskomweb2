import AssisstantNav from "@/Components/ComponentsAssistants/AssistantNav";
import ContentHistory from "@/Components/ComponentsAssistants/ContentHistory";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";

export default function ResultLaporan() {
    return (
        <>
            <section className="flex h-screen items-center justify-center p-6 relative">
                <div className="flex flex-col md:flex-row gap-6 w-full max-w-7xl">
                    {/* Navbar */}
                    <div className="flex-grow md:w-1/4 h-full">
                        <AssisstantNav />
                    </div>
                    {/* isi history praktikum */}
                    <div className="flex-grow md:w-3/4 mt-10">
                        <ContentHistory />
                    </div>
                </div>
                {/* Clock in top-right corner */}
                <Clock />

                {/* Modal in bottom-right */}
                <ModalSoftware />
            </section>
        </>
    )
}