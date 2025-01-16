import PraktikanNav from "../Components/ComponentsPraktikans/PraktikanNav";

export default function PraktikanAuthenticated({ children, customWidth }) {
    return (
        <>
            <div className="relative">
                <div id="template" className="flex">
                    <PraktikanNav />
                    <main
                        className={`my-auto mx-auto w-[30%] ${
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