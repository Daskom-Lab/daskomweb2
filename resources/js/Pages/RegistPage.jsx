import { Head, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import RegistFormPraktikan from '@/Components/ComponentsPraktikans/RegistFormPraktikan';
import RegistFormAssistant from '@/Components/ComponentsAssistants/RegistFormAssistant';
import Vector from '@/Components/ComponentsPraktikans/Vector';

export default function RegistPage() {
    const { ziggy } = usePage().props;  

    const currentMode = new URL(ziggy.location).searchParams.get('mode') || 'praktikan'; 
    const [mode, setMode] = useState(currentMode);
    console.log("Ziggy location changed:", ziggy.location);  

    useEffect(() => {
        setMode(currentMode);
    }, [ziggy.location]); 

    return (
        <>
            <Head title={mode === 'praktikan' ? "Register - Praktikan" : "Register - Asisten"} />

            <div className="bg-lightGainsboro flex mt-8 mx-auto rounded-lg shadow-xl max-w-4xl p-5">
                {mode === 'praktikan' ? (
                    <RegistFormPraktikan />
                ) : (
                    <RegistFormAssistant />
                )}
                <Vector />
            </div>
        </>
    );
}