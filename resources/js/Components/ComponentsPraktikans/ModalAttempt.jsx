export default function ModalAttempt({ taskKey, onAttemptComplete }) {
    const handleAttemptClick = () => {
        if (onAttemptComplete && taskKey) {
            onAttemptComplete(taskKey);
        }
    };    

    return (
        <div className="flex flex-col items-center justify-center">
            <h1 className="mt-10 text-sm font-semibold">Open on Wednesday, 26 June 2024, 18.00 PM</h1>
            <h1 className="mt-2 mb-4 text-sm font-semibold">Open on Saturday, 29 June 2024, 18.00 PM</h1>
            <button
                className="w-[200px] mt-5 p-1 bg-deepForestGreen text-lg text-white font-bold rounded-sm mb-3 hover:bg-deepForestGreenDark duration-300"
                onClick={handleAttemptClick}
            >
                Attempt
            </button>
        </div>
    );
}