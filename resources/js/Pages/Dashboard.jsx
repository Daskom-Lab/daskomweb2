import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import PraktikanCard from "@/Components/ComponentsPraktikans/PraktikanCard";
import { Head } from "@inertiajs/react";

export default function Dashboard({ auth }) {
    return (
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
    );
}
