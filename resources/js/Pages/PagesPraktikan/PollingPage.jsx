import { Head } from "@inertiajs/react";
import { useState } from "react";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";
import PollingHeader from "@/Components/ComponentsPraktikans/PollingHeader";
import PollingContent from "@/Components/ComponentsPraktikans/PollingContent";

export default function PollingPage({ auth }) {
    const [activeCategory, setActiveCategory] = useState("Tercantik");

    return (
        <>
            <PraktikanAuthenticated
                user={auth.user}
                customWidth="w-[65%]"
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                }
            >
                <Head title="Leaderboard Praktikan" />
        
                <div className="relative mt-[11vh] h-screen">
                    <PollingHeader onCategoryClick={(category) => setActiveCategory(category)} />
                    <PollingContent activeCategory={activeCategory} />
                </div>
            </PraktikanAuthenticated>
            <Clock />
            <ModalSoftware />
        </>
    );
}