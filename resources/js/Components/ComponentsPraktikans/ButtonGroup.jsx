import { Link, usePage } from '@inertiajs/react';
import React from 'react';
import ButtonMode from './ButtonMode';

const buttonTypes = ['praktikan', 'assistant'];

export default function ButtonGroup() {
    const { ziggy } = usePage().props; 
    const currentMode = new URL(ziggy.location).searchParams.get('mode') || 'praktikan';

    return (
        <div className="flex gap-4">
            {buttonTypes.map((type) => (
                <Link key={type} href={`/login?mode=${type}`}>
                    <ButtonMode type={type} isActive={currentMode === type} />
                </Link>
            ))}
        </div>
    );
}