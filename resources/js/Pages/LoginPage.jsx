import { Head, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import LoginFormPraktikan from '@/Components/ComponentsPraktikans/LoginFormPraktikan';
import LoginFormAssistant from '@/Components/ComponentsAssistants/LoginFormAssistant';
import Vector from '@/Components/ComponentsPraktikans/Vector';
import ButtonGroup from '@/Components/ComponentsPraktikans/ButtonGroup';

export default function LoginPage() {
    const { ziggy } = usePage().props; 
    
    const [mode, setMode] = useState();

    useEffect(() => {
        const currentMode = ziggy?.location
            ? new URL(ziggy.location).searchParams.get('mode') || 'praktikan'
            : 'praktikan';
        setMode(currentMode);
    }, [ziggy?.location]);

    return (
        <>
            <Head title={mode === 'praktikan' ? "Login - Praktikan" : "Login - Asisten"} />

            <div className="bg-lightGainsboro flex items-center mt-14 mx-auto rounded-lg shadow-xl max-w-4xl p-5">
                {mode === 'praktikan' ? (
                    <LoginFormPraktikan mode={mode} />
                ) : (
                    <LoginFormAssistant mode={mode} />
                )}

                <div className="w-1/2 flex flex-col items-center justify-center">
                    <Vector size="w-[410px]" />
                    <div className="flex flex-col items-center mt-4 w-full">
                        <ButtonGroup currentMode={mode} />
                    </div>
                </div>
            </div>
        </>
    );
}