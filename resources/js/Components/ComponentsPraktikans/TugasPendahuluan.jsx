import { useState, useEffect } from "react";

export default function TugasPendahuluan({ 
    setAnswers, 
    currentQuestion, 
    setCurrentQuestion, 
    setQuestionsCount,
    setQuestions,
    onNavigate, 
}) {
    const questions = [
        "Jelaskan apa perbedaan 'int' dan 'float' dalam bahasa C!",
        "Apa yang dimaksud dengan pointer dalam bahasa C, dan bagaimana cara menggunakannya?",
        "Jelaskan konsep array multidimensi dalam bahasa C dan berikan contohnya!",
        "Apa yang dimaksud dengan nested loop? Berikan contoh penggunaannya dalam bahasa C!",
        "Jelaskan apa itu struktur data 'struct' dalam bahasa C dan bagaimana cara mendeklarasikannya!",
        "Jelaskan apa itu fungsi rekursif dalam bahasa C dan berikan contoh penggunaannya!",
        "Apa perbedaan antara deklarasi variabel global dan lokal dalam bahasa C? Berikan contohnya!",
    ];

    const [userAnswers, setUserAnswers] = useState(() => {
        const savedAnswers = localStorage.getItem("tpAnswers");
        return savedAnswers ? JSON.parse(savedAnswers) : Array(questions.length).fill("");
    });
    
    const handleSubmit = () => {
        localStorage.setItem("tpAnswers", JSON.stringify(userAnswers)); 
        if (setAnswers) setAnswers(userAnswers); 
        onNavigate("TPReview");
    };    

    useEffect(() => {
        setQuestionsCount(questions.length);
        setQuestions(questions);
        setAnswers(userAnswers);
    }, []); 

    const [answers, setLocalAnswers] = useState(() => {
        const savedAnswers = localStorage.getItem("tpAnswers");
        return savedAnswers ? JSON.parse(savedAnswers) : ["", ""];
    });

    const handleInputChange = (e) => {
        const newAnswers = [...userAnswers];
        newAnswers[currentQuestion - 1] = e.target.value;
        setUserAnswers(newAnswers);
        setAnswers(newAnswers); 
    };  

    const handleNext = () => {
        if (currentQuestion < questions.length) {
            setCurrentQuestion(currentQuestion + 1);
        }
    };

    const handlePrevious = () => {
        if (currentQuestion > 1) {
            setCurrentQuestion(currentQuestion - 1);
        }
    };

    return (
        <div className="mt-[1vh] p-5 transition-all duration-300 max-w-4xl mx-auto rounded-lg">
            <div className="flex bg-deepForestGreen rounded-lg py-2 px-2 mb-4 justify-center">
                <h1 className="text-white text-center font-bold text-2xl bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[50%]">
                    Tugas Pendahuluan
                </h1>
            </div>
            <div className="mt-5 p-4 bg-softIvory rounded-lg border-4 border-softPearl transition-colors duration-300">
                <p className="text-lg font-medium">
                    {currentQuestion}. {questions[currentQuestion - 1]}
                </p>
                <textarea
                    className="mt-3 w-full bg-gainsboro h-24 p-2 border border-gray-300 rounded-md"
                    placeholder="Jawaban"
                    value={userAnswers[currentQuestion - 1]}
                    onChange={handleInputChange}
                ></textarea>
            </div>
            <div className="mt-5 flex justify-between">
                <button
                    onClick={handlePrevious}
                    className="px-4 py-2 bg-softIvory border-midGray text-black font-bold rounded-md shadow hover:bg-softGray disabled:bg-gray-100 disabled:cursor-not-allowed"
                    disabled={currentQuestion === 1}
                >
                    Previous
                </button>
                {currentQuestion === questions.length ? (
                    <button
                        onClick={handleSubmit}
                        className="px-4 py-2 bg-deepForestGreen text-white font-bold rounded-md shadow hover:bg-deepForestGreenDark"
                    >
                        Submit
                    </button>
                ) : (
                    <button
                        onClick={handleNext}
                        className="px-4 py-2 bg-softIvory border-midGray text-black font-bold rounded-md shadow hover:bg-softGray disabled:bg-gray-100 disabled:cursor-not-allowed"
                    >
                        Next
                    </button>
                )}
            </div>
        </div>
    );
}