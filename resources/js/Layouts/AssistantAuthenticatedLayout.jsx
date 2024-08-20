import { useState } from "react";
import { Link } from "@inertiajs/react";
import AssistantNav from "../Components/ComponentsAssistants/AssistantNav";
import AssistantAnnouncement from "../Components/ComponentsAssistants/AssistantAnno";

export default function AssistantAuthenticated({ children }) {
    return (
        <>
            <div className="relative">
                <AssistantAnnouncement />
                <div className="flex">
                    <AssistantNav />
                    <main className="my-auto mx-auto">{children}</main>
                </div>
            </div>
        </>
    );
}
