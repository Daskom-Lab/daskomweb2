import PraktikanNav from "../Components/ComponentsPraktikans/PraktikanNav";

export default function PraktikanAuthenticated({ children, customWidth }) {
    return (
        <>
            <div className="relative h-screen overflow-hidden">
                <div id="template" className="flex">
                    <PraktikanNav />
                    <main
                        className={`mx-auto w-[30%] ${
                            customWidth || "" 
                        }`}
                    >
                        {children}
                    </main>
                </div>
            </div>
        </>
    );
}