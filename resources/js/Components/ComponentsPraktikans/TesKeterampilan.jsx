import { useState, useEffect } from "react";

export default function TesKeterampilan({ 
    setAnswers, 
    currentQuestion, 
    setCurrentQuestion, 
    setQuestionsCount,
    setQuestions,
    onNavigate,
    correctAnswers, 
}) {
    const questions = [
        {
            question: "Naon perbedaan 'int' dan 'float' dalam bahasa C?",
            options: [
                "int digunakan untuk bilangan bulat, float untuk bilangan desimal",
                "int digunakan untuk string, float untuk bilangan desimal",
                "int untuk variabel statis, float untuk variabel dinamis",
                "Tidak ada perbedaan",
            ],
        },
        {
            question: "KUNAON //Lengkapi Codingan di bawah ini!\n#include <___> //(A) Tentukan library\n\nint main(){\n    int i, n, sum = 0;\n\n    // Input\n    printf(\"Masukkan jumlah bilangan: \");\n    scanf(\"%d\", &n);\n\n    // Operasi Perulangan\n    for (i = 1; i <= n; i++) {\n        sum += ___; //(B) Tambahkan angka ke dalam total\n    }\n\n    // Output\n    printf(\"Jumlah total dari 1 sampai %d adalah %d\", n, ___); //(C) Tentukan variabel\n    return 0;\n}",
            options: [
                "Variabel untuk menyimpan alamat memori",
                "Variabel untuk menyimpan nilai statis",
                "Fungsi khusus untuk array",
                "Tidak ada konsep pointer di bahasa C",
            ],
        },
        {
            question: "Jelaskeun konsep array multidimensi dalam bahasa C.",
            options: [
                "Array dengan satu dimensi saja",
                "Array yang dapat menyimpan tipe data berbeda",
                "Array yang memiliki lebih dari satu indeks",
                "Array yang hanya menyimpan string",
            ],
        },
    ];

    const [userAnswers, setUserAnswers] = useState(() => {
        const savedAnswers = localStorage.getItem("tkAnswers");
        return savedAnswers ? JSON.parse(savedAnswers) : Array(questions.length).fill(null); 
    });

    useEffect(() => {
        setQuestionsCount(questions.length);
        setQuestions(questions.map(q => q.question)); 
        setAnswers(userAnswers);
    
        localStorage.setItem("tkQuestions", JSON.stringify(questions));
    }, []);

    useEffect(() => {
        const correctAnswers = [0, 0, 2]; 
        localStorage.setItem("tkCorrectAnswers", JSON.stringify(correctAnswers));
    }, []);   

    const handleOptionChange = (optionIndex) => {
        const newAnswers = [...userAnswers];
        newAnswers[currentQuestion - 1] = optionIndex;
        setUserAnswers(newAnswers);
        setAnswers(newAnswers);
    };

    const handleSubmit = () => {
        localStorage.setItem("tkAnswers", JSON.stringify(userAnswers)); 
        if (setAnswers) setAnswers(userAnswers);
        onNavigate("TKReview");
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

    const determineMode = (question) => {
        const simpleKeywords = [";", "{", "}", "#", "//"];
        return simpleKeywords.some((keyword) => question.includes(keyword)) 
            ? "bg-gray-200" 
            : "bg-softIvory";
    };

    return (
        <div className="mt-[1vh] p-5 transition-all duration-300 max-w-4xl mx-auto rounded-lg">
            <div className="flex bg-deepForestGreen rounded-lg py-2 px-2 mb-4 justify-center">
                <h1 className="text-white text-center font-bold text-2xl bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[50%]">
                    Tes Keterampilan
                </h1>
            </div>

            <div className="mt-5 max-h-[56vh] p-4 rounded-lg border-4 bg-softIvory border-softPearl transition-colors duration-300">
                <p className="text-lg font-medium mb-4">
                    <b>Soal: {currentQuestion}</b>
                </p>

                <pre
                    className={`max-h-[20vh] p-4 rounded-lg text-sm overflow-y-auto overflow-x-hidden shadow-lg ${determineMode(
                        questions[currentQuestion - 1].question
                    )}`}
                    style={{ whiteSpace: "pre-wrap" }}
                >
                    {questions[currentQuestion - 1].question}
                </pre>

                <div className="mt-3 p-1">
                    {questions[currentQuestion - 1].options.map((option, index) => (
                        <div 
                            key={index} 
                            className="flex items-center space-x-3 mb-2 cursor-pointer"
                            onClick={() => handleOptionChange(index)}
                        >
                            <div
                                className={`w-4 h-4 flex items-center justify-center rounded-full border-2 cursor-pointer transition-colors ${
                                    userAnswers[currentQuestion - 1] === index
                                        ? "bg-black border-black"
                                        : "bg-softIvory border-gray-400"
                                }`}
                            />
                            <span className="text-gray-800">{option}</span>
                        </div>
                    ))}
                </div>
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