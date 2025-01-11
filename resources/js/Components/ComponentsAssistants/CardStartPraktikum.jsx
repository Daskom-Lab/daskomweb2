import { useState, useEffect } from "react";
import DropdownListKelas from "./DropdownListKelas";
import DropdownListModul from "./DropdownListModul";
import ModalConfigurePraktikum from "./ModalkonfigurePraktikum";
import ModalBlokPraktikum from './ModalBlokPraktikum';

export default function StartPraktikum() {
    const [selectedShift, setSelectedShift] = useState("");
    const [scheduleDetails, setScheduleDetails] = useState(null);
    const [showDetailsModal, setShowDetailsModal] = useState(false);
    const [showCountdownModal, setShowCountdownModal] = useState(false);
    const [countdown, setCountdown] = useState(null);
    const [editedTime, setEditedTime] = useState({ start: "06:40", end: "09:15" });
    const [showBlockModal, setShowBlockModal] = useState(false);

    const shifts = {
        "Shift 1": { start: "06:40", end: "09:15", ta: "06:40 - 06:50", jurnal: "1 jam", mandiri: "15 menit", tk: "10 menit", feedback: "sisa waktu" },
        "Shift 2": { start: "10:00", end: "12:00", ta: "10:00 - 10:10", jurnal: "1 jam", mandiri: "15 menit", tk: "10 menit", feedback: "sisa waktu" },
        "Shift 3": { start: "13:00", end: "15:00", ta: "13:00 - 13:10", jurnal: "1 jam", mandiri: "15 menit", tk: "10 menit", feedback: "sisa waktu" },
        "Shift 4": { start: "15:00", end: "17:00", ta: "15:00 - 15:10", jurnal: "1 jam", mandiri: "15 menit", tk: "10 menit", feedback: "sisa waktu" },
    };

    const handleShiftChange = (shift) => {
        setSelectedShift(shift);
        setScheduleDetails(shift ? shifts[shift] : null);
        if (shift) {
            setEditedTime({ start: shifts[shift].start, end: shifts[shift].end });
        }
    };

    const handleConfigure = () => {
        if (selectedShift) {
            setShowDetailsModal(true);
        }
    };

    const handleStart = () => {
        setShowDetailsModal(false);
        const now = new Date();
        const start = new Date(
            `${now.toISOString().split("T")[0]}T${editedTime.start}`
        );
        const timeDifference = Math.floor((start - now) / 1000);
        if (timeDifference > 0) {
            setShowCountdownModal(true);
            setCountdown(timeDifference);
        } else {
            setShowBlockModal(true); 
        }
    };

    const handleCancel = () => {
        setShowDetailsModal(false);
        setShowCountdownModal(false);
        setCountdown(null);
    };

    const handleTimeChange = (e) => {
        setEditedTime({ ...editedTime, [e.target.name]: e.target.value });
    };

    useEffect(() => {
        if (countdown !== null) {
            const interval = setInterval(() => {
                setCountdown((prev) => {
                    if (prev > 0) return prev - 1;
                    clearInterval(interval);
                    return null;
                });
            }, 1000);

            return () => clearInterval(interval);
        }
    }, [countdown]);

    const formatTime = (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${minutes}m ${secs}s`;
    };

    // Calculate 
    const calculateRemainingTime = () => {
        const startTime = new Date(`1970-01-01T${editedTime.start}`);
        const endTime = new Date(`1970-01-01T${editedTime.end}`);
        const totalDuration = (endTime - startTime) / 1000;
        const taDuration = 10 * 60; // 10 minutes
        const jurnalDuration = 60 * 60; // 1 hour
        const mandiriDuration = 15 * 60; // 15 minutes
        const tkDuration = 10 * 60; // 10 minutes
        const feedbackDuration = 7 * 60; // 7 minutes

        const totalScheduledTime = taDuration + jurnalDuration + mandiriDuration + tkDuration + feedbackDuration;
        const remainingTime = totalDuration - totalScheduledTime;
        return remainingTime > 0 ? remainingTime : 0;
    };

    return (
        <div className="max-w-4xl h-auto mx-auto p-8 bg-white shadow-md shadow-deepForestGreen rounded-lg border-2 border-darkBrown mt-8">
            <h1 className="text-4xl font-bold text-black text-center mb-10">START PRAKTIKUM</h1>

            {/* Selection */}
            <div className="space-y-4">
                <div className="flex justify-center items-center gap-3">
                    <DropdownListKelas />
                    <DropdownListModul />
                    <select
                        value={selectedShift}
                        onChange={(e) => handleShiftChange(e.target.value)}
                        className="w-[180px] p-1 rounded-lg border-2 border-darkBrown text-darkBrown font-semibold text-center"
                    >
                        <option value="">-- Pilih Shift --</option>
                        {Object.keys(shifts).map((shift) => (
                            <option key={shift} value={shift}>
                                {shift}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            {/* Time Inputs */}
            {selectedShift && (
                <div className="mt-6">
                    <div className="flex gap-4 justify-center">
                        <input
                            type="time"
                            name="start"
                            value={editedTime.start}
                            onChange={handleTimeChange}
                            className="w-32 p-1 rounded-lg border-2 border-darkBrown text-darkBrown text-center"
                        />
                        <span className="font-bold">-</span>
                        <input
                            type="time"
                            name="end"
                            value={editedTime.end}
                            onChange={handleTimeChange}
                            className="w-32 p-1 rounded-lg border-2 border-darkBrown text-darkBrown text-center"
                        />
                    </div>
                </div>
            )}

            {/* Additional Notes */}
            <div className="mt-8 text-sm text-gray-600">
                <p className="mb-2"><strong>Catatan:</strong></p>
                <ul className="list-disc list-inside space-y-1">
                    <li>Pastikan untuk memilih <strong>kelas</strong>, <strong>modul</strong>, dan <strong>shift</strong> yang sesuai sebelum memulai praktikum.</li>
                    <li>Informasi yang telah diatur tidak dapat diubah atau dibatalkan setelah praktikum dimulai.</li>
                    <li><strong>Waktu praktikum</strong> yang telah disetting tidak dapat direset atau diubah selama praktikum berlangsung.</li>
                    <li>Pastikan untuk mempersiapkan segala keperluan praktikum sebelum memilih shift.</li>
                </ul>
            </div>

            {/* Configure Button */}
            <ModalConfigurePraktikum
                selectedShift={selectedShift}
                handleConfigure={handleConfigure}
                setShowDetailsModal={setShowDetailsModal}
            />

            {/* Details Modal */}
            {showDetailsModal && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-white p-6 rounded-lg w-96">
                        <h2 className="text-2xl text-darkGreen font-bold mb-4">Detail Jadwal</h2>
                        <ul className="list-disc list-inside space-y-2">
                            <li><strong>TA:</strong> 10 menit</li>
                            <li><strong>Jurnal:</strong> 1 jam 25 menit</li>
                            <li><strong>Mandiri:</strong> 15 menit</li>
                            <li><strong>TK:</strong> 10 menit</li>
                            <li><strong>Feedback Asisten:</strong> 7 menit</li>
                            <li><strong>Laporan Prakikum:</strong> {formatTime(calculateRemainingTime())}</li>
                        </ul>
                        <div className="flex justify-end mt-6 space-x-2">
                            <button
                                onClick={handleCancel}
                                className="px-4 py-2 bg-rustyRed text-white font-semibold rounded-lg hover:bg-softRed"
                            >
                                Cancel
                            </button>
                            <button
                                onClick={handleStart}
                                className="px-4 py-2 bg-deepForestGreen text-white font-semibold rounded-lg hover:bg-darkGreen"
                            >
                                Start
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Countdown Modal */}
            {showCountdownModal && countdown !== null && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
                    <div className="bg-white p-6 rounded-lg w-96 text-center">
                        <h2 className="text-2xl font-bold mb-4 text-deepForestGreen">Countdown Praktikum</h2>
                        <p className="text-2xl font-bold text-fireRed">{formatTime(countdown)}</p>
                        <div className="flex justify-center mt-6">
                            <button
                                onClick={handleCancel}
                                className="px-4 py-1 bg-rustyRed text-white font-semibold rounded-lg hover:bg-softRed"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Block Modal */}
            {showBlockModal && <ModalBlokPraktikum onClose={() => setShowBlockModal(false)} />}
        </div>
    );
}
