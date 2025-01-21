import { useState, useEffect } from "react";

export default function Jurnal({ 
    setAnswers, 
    currentQuestion, 
    setCurrentQuestion, 
    setQuestionsCount,
    setQuestions,
    onNavigate, 
}) {
    const questions = [
        "//Lengkapi Codingan di bawah ini!\n#include <___> //(A) Tentukan library\n\nint main(){\n    ___ angka1, angka2; //(B) Tentukan tipe data\n    float hasil;\n\n    // Input\n    printf(\"Masukkan angka pertama (bulat): \");\n    scanf(\"%d\", &angka1);\n    printf(\"Masukkan angka kedua (bulat): \");\n    scanf(\"%d\", &angka2);\n\n    // Operasi Hitung\n    hasil = (float)angka1 / angka2; //(C) Tentukan operasi hitung\n\n    // Output\n    printf(\"Hasil pembagian %d / %d = %.2f\", angka1, angka2, ___); //(D) Tentukan variabel\n    return 0;\n}",
    
        "//Lengkapi Codingan di bawah ini!\n#include <___> //(A) Tentukan library\n#define ___ 3.14159 //(B) Tentukan konstanta nilai PI\n\nint main(){\n    float radius, luas;\n\n    // Input\n    printf(\"Masukkan jari-jari lingkaran: \");\n    scanf(\"%f\", &radius);\n\n    // Operasi Hitung\n    luas = ___ * radius * radius; //(C) Gunakan konstanta untuk menghitung luas lingkaran\n\n    // Output\n    printf(\"Luas lingkaran dengan jari-jari %.2f adalah %.2f\", radius, ___); //(D) Tentukan variabel\n    return 0;\n}",
    
        "//Lengkapi Codingan di bawah ini!\n#include <___> //(A) Tentukan library\n\nint main(){\n    int i, n, sum = 0;\n\n    // Input\n    printf(\"Masukkan jumlah bilangan: \");\n    scanf(\"%d\", &n);\n\n    // Operasi Perulangan\n    for (i = 1; i <= n; i++) {\n        sum += ___; //(B) Tambahkan angka ke dalam total\n    }\n\n    // Output\n    printf(\"Jumlah total dari 1 sampai %d adalah %d\", n, ___); //(C) Tentukan variabel\n    return 0;\n}",
    
        "Jelaskan konsep pointer dalam bahasa C. Apa tujuan penggunaannya, dan bagaimana cara mendeklarasikan serta menggunakannya dalam sebuah program sederhana?",
    
        "Dalam bahasa C, apa perbedaan antara array dan pointer? Jelaskan keunggulan masing-masing serta contoh penggunaannya dalam kasus nyata.",
    
        "Apa itu struct dalam bahasa C? Jelaskan bagaimana cara mendeklarasikan dan menggunakannya untuk merepresentasikan data sebuah mahasiswa dengan atribut seperti nama, NIM, dan nilai akhir.",
    ];
    
    const [userAnswers, setUserAnswers] = useState(() => {
        const savedAnswers = localStorage.getItem("jurnalAnswer");
        return savedAnswers ? JSON.parse(savedAnswers) : Array(questions.length).fill("");
    });
    
    const handleSubmit = () => {
        localStorage.setItem("jurnalAnswer", JSON.stringify(userAnswers)); 
        if (setAnswers) setAnswers(userAnswers);
        onNavigate("JurnalReview");
    };    

    useEffect(() => {
        setQuestionsCount(questions.length); 
        setQuestions(questions); 
        setAnswers(userAnswers); 
    }, []);

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
                    Jurnal
                </h1>
            </div>
    
            <div
                className="mt-5 p-4 bg-softIvory rounded-lg border-4 border-softPearl transition-colors duration-300"
                style={{ maxHeight: "50vh", overflowY: "auto", overflowX: "hidden" }}
            >
                <p className="text-lg font-medium mb-4">
                    <b>{currentQuestion}. Soal :</b>
                </p>
    
                <pre
                    className="bg-softIvory p-4 rounded-lg text-sm"
                    style={{ whiteSpace: "pre-wrap", overflowX: "hidden", overflowY: "auto" }}
                >
                    <code>{questions[currentQuestion - 1]}</code>
                </pre>
    
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