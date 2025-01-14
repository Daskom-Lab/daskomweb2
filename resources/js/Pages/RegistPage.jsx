import React from 'react';
import { usePage } from '@inertiajs/react';
import RegistFormPraktikan from '@/Components/ComponentsPraktikans/RegistFormPraktikan';
import RegistFormAssistant from '@/Components/ComponentsAssistants/RegistFormAssistant';
import Vector from '@/Components/ComponentsPraktikans/Vector';

export default function RegistPage() {
    const { url } = usePage();
    const mode = new URLSearchParams(url.split('?')[1]).get('mode') || 'praktikan';

    return (
        <div className="bg-lightGainsboro flex mt-8 mx-auto rounded-lg shadow-xl max-w-4xl p-5">
                {mode === 'praktikan' ? (
                <RegistFormPraktikan />
            ) : (
                <RegistFormAssistant />
            )}
            <Vector />
        </div>
    );
}