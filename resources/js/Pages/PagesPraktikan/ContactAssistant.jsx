import { Head } from "@inertiajs/react";
import React, { useState } from "react";
import PraktikanAuthenticated from "@/Layouts/PraktikanAuthenticatedLayout";
import ContactAssistantTable from "@/Components/ComponentsPraktikans/ContactAssistantTable";
import Clock from "@/Components/ComponentsAssistants/Clock";
import ModalSoftware from "@/Components/ComponentsAssistants/ModalSoftware";

export default function ContactAssistant({ auth }) {
    const [isSidebarOpen, setIsSidebarOpen] = useState(false);

    const toggleSidebar = () => {
        setIsSidebarOpen(!isSidebarOpen);
    };

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
                <Head title="Contact Assistant" />

                <div className="mt-12 flex min-h-[calc(100vh-60px)]">
                    <div 
                        className={`transition-all duration-300 flex-1 ${isSidebarOpen ? 'ml-[240px]' : 'ml-14'}`}
                    >
                        <ContactAssistantTable />
                    </div>
                </div>
            </PraktikanAuthenticated>
            <Clock />
            <ModalSoftware />
        </>
    );
}