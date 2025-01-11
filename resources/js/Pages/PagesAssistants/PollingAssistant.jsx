import AssisstantNav from "@/Components/ComponentsAssistants/AssistantNav";
import ContentPolling from "@/Components/ComponentsAssistants/ContentPolling";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";

export default function PollingAssistant() {
    return (
        <>
            <section className="flex h-screen items-center justify-center p-6 relative">
                <div className="flex flex-col md:flex-row gap-6 w-full max-w-7xl">
                    {/* Navbar */}
                    <div className="flex-grow md:w-1/4 h-full">
                        <AssisstantNav />
                    </div>
                    {/* table rangking */}
                    <div className="flex-grow md:w-3/4 mt-10">
                        <ContentPolling />
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