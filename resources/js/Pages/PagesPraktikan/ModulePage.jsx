import { Head } from "@inertiajs/react";
import React from "react";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";
import ModuleSection from "@/Components/ComponentsPraktikans/ModuleSection";

export default function ModulePage({ auth }) {
    return (
        <>
            <PraktikanAuthenticated
                user={auth.user}
                customWidth="w-[80%]"
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Dashboard
                    </h2>
                }
            >
                <Head title="Practicum Modules" />

                <div className="mt-12 flex min-h-[calc(100vh-60px)]">
                    <div className="flex-1">
                        <ModuleSection />
                    </div>
                </div>
            </PraktikanAuthenticated>
            <Clock />
            <ModalSoftware />
        </>
    );
}