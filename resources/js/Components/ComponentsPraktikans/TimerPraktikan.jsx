// TimerPraktikan.jsx
import { useState, useEffect } from "react";
import iconSwipeLeft from "../../../assets/timer/iconSwipeLeft.svg";
import iconSwipeRight from "../../../assets/timer/iconSwipeRight.svg";
import iconSwipeLeftHover from "../../../assets/timer/iconSwipeLeftHover.svg";
import iconSwipeRightHover from "../../../assets/timer/iconSwipeRightHover.svg";
import Modal from "../ComponentsPraktikans/Modal";
import ModalSubmit from "../ComponentsPraktikans/ModalSubmit";
import ModalFeedback from "../ComponentsPraktikans/ModalFeedback";

export default function TimerPraktikan({
    isRunning,
    setIsRunning,
    onShiftContent,
    answers = [],
    setAnswers = () => {},
    questions = [],
    setCurrentQuestion,
    questionsCount,
    setQuestionsCount,
    onTaskSubmit,
    taskQuestions,
    activeTask,
}) {
    const [isHidden, setIsHidden] = useState(false);
    const [isHovered, setIsHovered] = useState(false);
    const [isSubmitModalOpen, setIsSubmitModalOpen] = useState(false);
    const [time, setTime] = useState(30 * 60);

    useEffect(() => {
        if (onShiftContent) {
            const shiftValue = isHidden ? "0" : "20rem";
            onShiftContent(shiftValue);
        }
    }, [isHidden, onShiftContent]);

    useEffect(() => {
        if (!isRunning) {
            setTime(30 * 60);
        }

        const timer = setInterval(() => {
            setTime((prevTime) => {
                if (prevTime <= 0) {
                    clearInterval(timer);
                    setIsRunning(false);
                    return 0;
                }
                return prevTime - 1;
            });
        }, 1000);

        return () => clearInterval(timer);
    }, [isRunning, setIsRunning]);

    useEffect(() => {
        if (!answers || answers.length === 0 || answers.length !== questions.length) {
            const initializedAnswers = Array(questions.length).fill(null);
            setAnswers(initializedAnswers);
        }
    }, [questions]);

    const formatTime = (timeInSeconds) => {
        const hours = Math.floor(timeInSeconds / 3600);
        const minutes = Math.floor((timeInSeconds % 3600) / 60);
        const seconds = timeInSeconds % 60;
        return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
    };

    const handleClick = (questionNumber) => {
        setCurrentQuestion(questionNumber);
    };

    const handleSubmit = () => {
        setIsSubmitModalOpen(true);
    };

    const closeSubmitModal = () => {
        setIsSubmitModalOpen(false);
    };

    const confirmTaskSubmission = () => {
        if (onTaskSubmit && Array.isArray(answers)) {
            onTaskSubmit(activeTask, answers);
        }
        setIsSubmitModalOpen(false);
    };

    const navigateToModuleSection = () => {
        setIsRunning(false);
        setIsHidden(true);
    };

    const handleFeedbackSubmit = () => {
        setIsFeedbackModalOpen(true);
        navigateToModuleSection();
    };    

    return (
        <div>
            <img
                src={
                    isHovered
                        ? isHidden
                            ? iconSwipeLeftHover
                            : iconSwipeRightHover
                        : isHidden
                        ? iconSwipeLeft
                        : iconSwipeRight
                }
                alt="Toggle Sidebar"
                className={`fixed top-1/2 transform -translate-y-1/2 cursor-pointer z-10 transition-all duration-300 ${
                    isHidden ? "right-2" : "right-[295px]"
                } w-10 h-10`}
                onClick={() => setIsHidden(!isHidden)}
                onMouseEnter={() => setIsHovered(true)}
                onMouseLeave={() => setIsHovered(false)}
            />

            <div
                className={`fixed flex flex-col top-0 h-full w-72 bg-white shadow-lg transition-all duration-300 z-10 ${
                    isHidden ? "-right-72" : "right-0"
                } p-5`}
            >
                <div className="flex flex-col items-center text-center pt-[10vh] mb-5">
                    <h3 className="text-xl font-bold mb-2">Timer Limit</h3>
                    <h1 className="text-3xl font-bold">{formatTime(time)}</h1>
                </div>

                <div className="grid grid-cols-5 gap-2 text-center pt-[5vh] mb-10">
                    {Array.from({ length: questionsCount }, (_, index) => {
                        const isAnswered =
                            (activeTask === "TesAwal" || activeTask === "TesKeterampilan")
                                ? answers[index] !== undefined && answers[index] !== null
                                : typeof answers[index] === "string" && answers[index].trim().length > 0;

                        return (
                            <div
                                key={index}
                                className={`p-2 border border-gray-300 rounded 
                                ${
                                    isAnswered
                                        ? "bg-deepForestGreen text-white hover:bg-darkOliveGreen"
                                        : "bg-softPearl hover:bg-softGray"
                                } 
                                font-semibold cursor-pointer shadow-md`}
                                onClick={() => handleClick(index + 1)}
                            >
                                {index + 1}
                            </div>
                        );
                    })}
                </div>

                <div className="flex justify-center items-center w-full">
                    <button
                        id="timer-submit-button"
                        onClick={handleSubmit}
                        className="w-[70%] py-2 rounded bg-deepForestGreen text-white font-bold shadow-md hover:bg-deepForestGreenDark transition-colors duration-300"
                    >
                        Submit
                    </button>
                </div>
            </div>

            {isSubmitModalOpen && (
                <Modal isOpen={isSubmitModalOpen} onClose={closeSubmitModal} width="w-[370px]">
                    <ModalSubmit
                        isOpen={isSubmitModalOpen}
                        onClose={closeSubmitModal}
                        onConfirm={confirmTaskSubmission}
                        activeTask={activeTask} 
                    />
                </Modal>
            )}
        </div>
    );
}