import { Head } from '@inertiajs/react';
import AboutDescription from '@/Components/ComponentsPraktikans/AboutDescription';
import Vector from '@/Components/ComponentsPraktikans/Vector';

export default function AboutPage() {
    return (
        <>
            <Head title="About Us - Daskom Laboratory" />
            <div className="bg-lightGainsboro flex justify-center mt-[75px] mx-auto rounded-lg shadow-xl max-w-4xl min-h-[475px] p-5">
                <AboutDescription />
                <Vector />
            </div>
        </>
    );
}