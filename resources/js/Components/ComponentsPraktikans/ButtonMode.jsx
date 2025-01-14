export default function ButtonMode({ type, isActive }) {
    const buttonClasses = `w-32 py-1 px-5 text-lg text-white font-bold rounded-lg shadow-sm shadow-black ${
        isActive ? 'bg-deepForestGreenDark border-2 duration-300' : 'bg-deepForestGreen border-2 border-deepForestGreen duration-300'
    }`;

    return (
        <button className={buttonClasses}>
            {type === 'praktikan' ? 'Praktikan' : 'Asisten'}
        </button>
    );
}