import { useState, useEffect } from "react";

export default function Clock() {
    const [currentTime, setCurrentTime] = useState("");

    // Update waktu setiap detik
    useEffect(() => {
        const interval = setInterval(() => {
            const now = new Date();
            setCurrentTime(now.toLocaleTimeString());
        }, 1000);
        return () => clearInterval(interval);
    }, []);

    return (
        <>
            {/* Clock in top-right corner */}
            <div className="absolute top-4 right-4 bg-forestGreen text-white py-2 px-4 rounded-lg shadow-lg font-medium">
                {currentTime}
            </div>

        </>
    );
}
