import { Head } from "@inertiajs/react";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";
import LeaderboardTable from "@/Components/ComponentsPraktikans/LeaderboardTable";

export default function LeaderboardPraktikan({ auth }) {
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
                    <div className="ml-4 w-[100px] border-2 border-black px-4 py-1 bg-white text-center z-10">
                        Nilai
                    </div>
                    <div className="mt-0">
                        <LeaderboardTable />
                    </div>
                </div>
            </PraktikanAuthenticated>
            <Clock />
            <ModalSoftware />
        </>
    );
}