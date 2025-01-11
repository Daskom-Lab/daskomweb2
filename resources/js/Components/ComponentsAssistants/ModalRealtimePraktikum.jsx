import { useState, useEffect } from 'react';

export default function ModalRealtimePraktikum({ onClose }) {
    const stages = [
        { name: "TA", duration: 10 * 60 }, // 10 minutes
        { name: "Jurnal", duration: 85 * 60 }, // 1 hour 25 minutes
        { name: "Mandiri", duration: 15 * 60 }, // 15 minutes
        { name: "TK", duration: 10 * 60 }, // 10 minutes
        { name: "Laporan", duration: 7 * 60 }, // 7 minutes
    ];

    const [currentStage, setCurrentStage] = useState(0);
    const [countdown, setCountdown] = useState(stages[0].duration);
    const [isFinished, setIsFinished] = useState(false);
    const [timeIsOver, setTimeIsOver] = useState(false);

    useEffect(() => {
        if (countdown === 0) {
            if (currentStage === stages.length - 1) {
                setIsFinished(true);
            } else {
                setCurrentStage((prev) => prev + 1);
                setCountdown(stages[currentStage + 1].duration);
            }
        }

        if (countdown > 0 && !isFinished && !timeIsOver) {
            const interval = setInterval(() => {
                setCountdown((prev) => prev - 1);
            }, 1000);

            return () => clearInterval(interval);
        }

    }, [countdown, currentStage, isFinished, timeIsOver]);

    const formatTime = (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes}m ${secs}s`;
    };

    const handleClose = () => {
        setTimeIsOver(true);
        onClose();
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div className="bg-white p-6 rounded-lg w-96 text-center">
                <h2 className="text-2xl font-bold mb-4 text-deepForestGreen">
                    {isFinished ? "Praktikum Selesai!" : `Waktu: ${stages[currentStage].name}`}
                </h2>
                {!isFinished ? (
                    <div>
                        <p className="text-xl font-semibold mb-4">
                            {formatTime(countdown)}
                        </p>
                        <p className="mb-4">
                            Waktu tersisa untuk <strong>{stages[currentStage].name}</strong>
                        </p>
                        {countdown === 0 && <span className="text-green-500">Selesai</span>}
                    </div>
                ) : (
                    <div>
                        <p className="mb-4">Praktikum selesai. Silakan isi laporan.</p>
                        <textarea
                            className="w-full p-2 border-2 border-darkBrown rounded-md"
                            placeholder="Isi laporan..."
                            rows="4"
                        />
                    </div>
                )}
                <div className="flex justify-center mt-6">
                    <button
                        onClick={handleClose}
                        className="px-4 py-1 bg-rustyRed text-white font-semibold rounded-lg hover:bg-softRed"
                    >
                        {isFinished ? "Tutup" : "Batal"}
                    </button>
                </div>
            </div>
        </div>
    );
}
