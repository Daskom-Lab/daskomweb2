import { useEffect, useState } from "react";

export default function TAReview() {
    const [questions, setQuestions] = useState([]);
    const [answers, setAnswers] = useState([]);
    const [correctAnswers, setCorrectAnswers] = useState([]);

    useEffect(() => {
        const storedQuestions = JSON.parse(localStorage.getItem("taQuestions")) || [];
        const storedAnswers = JSON.parse(localStorage.getItem("taAnswers")) || [];
        const storedCorrectAnswers = JSON.parse(localStorage.getItem("taCorrectAnswers")) || [];

        setQuestions(storedQuestions);
        setAnswers(storedAnswers);
        setCorrectAnswers(storedCorrectAnswers);
    }, []);

    if (!Array.isArray(questions) || questions.length === 0) {
        return (
            <div className="mt-5 text-center text-red-600">
                <h2 className="text-xl font-bold">Tidak ada soal untuk ditampilkan.</h2>
            </div>
        );
    }

    const determineMode = (question) => {
        const simpleKeywords = [";", "{", "}", "#", "//"];
        return simpleKeywords.some((keyword) => question.includes(keyword))
            ? "bg-gray-200"
            : "bg-softIvory";
    };

    return (
        <div className="mt-[1vh] p-5 transition-all duration-300 w-[70vw] max-h-full mx-auto rounded-lg relative right-[-4vw]">
            <div className="flex bg-deepForestGreen rounded-lg py-2 px-2 mb-4 justify-center">
                <h1 className="text-white text-center font-bold text-2xl bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[50%]">
                    Review Tes Awal
                </h1>
            </div>
            <div
                className="space-y-8 overflow-y-auto h-[90vh]"
                style={{
                    maxHeight: "calc(80vh - 6rem)",
                }}
            >
                {questions.map((questionObj, index) => {
                    const options = questionObj.options || [];
                    const userAnswerIndex = answers[index]; 
                    const correctAnswerIndex = correctAnswers[index];
                    const isCorrect = userAnswerIndex === correctAnswerIndex; 
                    const correctAnswer = options[correctAnswerIndex] || "Tidak ada kunci jawaban";

                    return (
                        <>
                            <div
                                key={index}
                                className="mt-[1vh] relative p-4 bg-softIvory rounded-lg border-4 border-softPearl shadow-lg"
                                style={{ top: "3vh" }}
                            >
                                <span
                                    className={`absolute -top-[25px] right-0 text-sm underline ${
                                        isCorrect ? "text-darkGray" : "text-darkGray"
                                    }`}
                                >
                                    Mark {isCorrect ? "1.00" : "0.00"} out of 1.00
                                </span>

                                <pre
                                    className={`p-4 rounded-lg text-sm overflow-y-auto overflow-x-hidden shadow-lg ${determineMode(
                                        questionObj.question
                                    )}`}
                                    style={{ whiteSpace: "pre-wrap" }}
                                >
                                    {index + 1}. {questionObj.question || "Soal tidak tersedia"}
                                </pre>

                                <div className="mt-3 p-1">
                                    {options.map((option, optionIndex) => (
                                        <div
                                            key={optionIndex}
                                            className="flex items-center space-x-3 mb-2"
                                        >
                                            <div
                                                className={`w-4 h-4 flex items-center justify-center rounded-full border-2 ${
                                                    userAnswerIndex === optionIndex
                                                        ? "bg-black border-darkGray"
                                                        : "bg-softIvory border-gray-400"
                                                }`}
                                            />
                                            <span
                                                className={`${
                                                    userAnswerIndex === optionIndex
                                                        ? "text-black font-bold"
                                                        : "text-gray-800"
                                                }`}
                                            >
                                                {option}
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <div className="p-2 bg-softPearl rounded-lg border-2 shadow-lg border-darkGray">
                                <span className="text-gray-600 text-sm font-semibold">
                                    Answer : {correctAnswer}
                                </span>
                            </div>
                        </>
                    );
                })}
            </div>
        </div>
    );
}