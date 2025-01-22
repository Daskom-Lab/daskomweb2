import { Head } from "@inertiajs/react";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";
import ScoreTable from "@/Components/ComponentsPraktikans/ScoreTable";

export default function ScorePraktikan({ auth }) {
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
        
                <div className="relative mt-[12vh] h-screen">
                    <div className="mt-0">
                        <ScoreTable />
                    </div>
                </div>
            </PraktikanAuthenticated>
            <Clock />
            <ModalSoftware />
        </>
    );
}