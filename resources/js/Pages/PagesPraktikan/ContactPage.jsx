import { Head } from '@inertiajs/react';
import ContactDescription from '@/Components/ComponentsPraktikans/ContactDescription';
import Vector from '@/Components/ComponentsPraktikans/Vector';

export default function ContactPage() {
    return (
        <>
            <Head title="Contact Us - Daskom Laboratory" />
            <div className="bg-lightGainsboro flex justify-center mt-[75px] mx-auto rounded-lg shadow-xl max-w-4xl p-5">
                <ContactDescription />
                <Vector />
            </div>
        </>
    );
}