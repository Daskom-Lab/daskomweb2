import { Head } from "@inertiajs/react";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import PraktikanCard from "@/Components/ComponentsPraktikans/PraktikanCard";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";

export default function ProfilePraktikan({ auth }) {
    return (
        <>
            <PraktikanAuthenticated
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                }
            >
                <Head title="Dashboard" />

                <PraktikanCard />
            </PraktikanAuthenticated>
            <Clock />
            <ModalSoftware />
        </>
    );
}