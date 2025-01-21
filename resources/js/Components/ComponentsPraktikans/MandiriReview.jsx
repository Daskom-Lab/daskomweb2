export default function JurnalReview({ answers, questions, activeTask }) {
    return (
        <div className="mt-[1vh] p-5 transition-all duration-300 w-[70vw] max-h-full mx-auto rounded-lg relative right-[-4vw]">
            <div className="flex bg-deepForestGreen rounded-lg py-2 px-2 mb-4 justify-center">
                <h1 className="text-white text-center font-bold text-2xl bg-deepForestGreen hover:bg-darkOliveGreen rounded-lg p-1 w-[50%]">
                    Review Mandiri
                </h1>
            </div>

            <div
                className="space-y-6 overflow-y-auto h-[90vh]"
                style={{
                    maxHeight: "calc(80vh - 6rem)",
                }}
            >
                {questions.map((question, index) => (
                    <div
                        key={index}
                        className="mt-5 p-4 bg-softIvory rounded-lg border-4 border-softPearl transition-colors duration-300 overflow-y-auto overflow-x-hidden"
                        style={{
                            maxHeight: "50vh",
                        }}
                    >
                        <p className="text-lg font-medium mb-4">
                            <b>{index + 1}. Soal:</b>
                        </p>

                        <pre
                            className="bg-softIvory p-4 rounded-lg text-sm overflow-y-auto overflow-x-hidden"
                            style={{
                                whiteSpace: "pre-wrap",
                            }}
                        >
                            <code>{question}</code>
                        </pre>

                        <textarea
                            className="mt-3 w-full bg-gainsboro h-24 p-2 border border-gray-300 rounded-md cursor-not-allowed"
                            value={answers[index] || "Belum ada jawaban"}
                            readOnly
                            style={{
                                color: answers[index]?.trim() ? "black" : "darkGray",
                            }}
                        ></textarea>
                    </div>
                ))}
            </div>
        </div>
    );
}