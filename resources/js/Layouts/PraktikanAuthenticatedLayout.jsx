import { useState } from "react";
import { Link } from "@inertiajs/react";
import PraktikanNav from "../Components/ComponentsPraktikans/PraktikanNav";
import PraktikanAnnouncement from "../Components/ComponentsPraktikans/PraktikanAnno";

export default function PraktikanAuthenticated({ children }) {
    return (
        <>
            <div className="relative">
                <PraktikanAnnouncement />
                <div id="template" className="flex">
                    <PraktikanNav />
                    <main className="my-auto mx-auto">{children}</main>
                </div>
            </div>
        </>
    );
}
