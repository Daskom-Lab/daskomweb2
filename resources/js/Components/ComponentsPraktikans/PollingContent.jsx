import { useState, useEffect } from "react";
import daskomIcon from "../../../assets/daskom.svg";
import CardPolling from "./CardPolling";

export default function PollingContent({ activeCategory, onSubmit, isSubmitted }) {
    const [selectedCards, setSelectedCards] = useState(() => {
        const storedCards = localStorage.getItem("selectedCards");
        return storedCards ? JSON.parse(storedCards) : {};
    });

    const [activeModalCards, setActiveModalCards] = useState(() => {
        const storedModalCards = localStorage.getItem("activeModalCards");
        return storedModalCards ? JSON.parse(storedModalCards) : {};
    });

    const categoryNames = {
        Tercantik: "FYN | Aisyah",
        Terganteng: "YNF | Putra",
        Tergalak: "NFY | Dhea",
        Terjaim: "NYF | Aisyah",
        Terimut: "YFN | Putri",
        Tercool: "FYN | Putra",
        Terpelit: "NYF | Dhea",
        Terasik: "YFN | Aisyah",
    };

    const name = categoryNames[activeCategory] || "Unknown";

    const dummyCards = Array.from({ length: 9 }).map((_, index) => ({
        id: index + 1,
        name: `${name} ${index + 1}`,
        image: daskomIcon,
        description: `I'm ${name}. Nice to meet you!`,
    }));

    const handleCardClick = (card) => {
        if (isSubmitted) return; // Blokir klik jika sudah submit

        setActiveModalCards((prev) => {
            const updatedModalCards =
                prev[activeCategory]?.id === card.id
                    ? { ...prev, [activeCategory]: null }
                    : { ...prev, [activeCategory]: card };

            localStorage.setItem("activeModalCards", JSON.stringify(updatedModalCards));
            return updatedModalCards;
        });

        setSelectedCards((prev) => {
            const updatedCards = { ...prev, [activeCategory]: card };
            localStorage.setItem("selectedCards", JSON.stringify(updatedCards));
            return updatedCards;
        });
    };

    useEffect(() => {
        if (onSubmit) {
            onSubmit(selectedCards);
        }
    }, [selectedCards, onSubmit]);

    return (
        <div className={`relative ${isSubmitted ? "pointer-events-none" : ""}`}>
            <div className="p-4 mt-4 h-[59vh] overflow-y-auto bg-softIvory rounded-lg shadow-lg relative">
                <div className="grid grid-cols-3 gap-4">
                    {dummyCards.map((card) => (
                        <CardPolling
                            key={card.id}
                            image={card.image}
                            name={card.name}
                            description={card.description}
                            onClick={() => handleCardClick(card)}
                            isDimmed={
                                !!activeModalCards[activeCategory] &&
                                activeModalCards[activeCategory]?.id !== card.id
                            }
                            isSelected={selectedCards[activeCategory]?.id === card.id}
                        />
                    ))}
                </div>
            </div>

            {activeModalCards[activeCategory] && (
                <div
                    key={activeModalCards[activeCategory]?.id || "default"}
                    className="absolute inset-0 flex items-center justify-center pointer-events-none z-50"
                >
                    <div className="pointer-events-auto h-[50vh] w-[23vw] border-4 rounded-lg bg-softIvory shadow-lg p-6">
                        <img
                            src={activeModalCards[activeCategory]?.image || ""}
                            alt={activeModalCards[activeCategory]?.name || ""}
                            className="w-[165px] mx-auto rounded-full mb-4"
                        />
                        <h2 className="text-center mb-5 font-bold text-xl text-black">
                            {activeModalCards[activeCategory]?.name || ""}
                        </h2>
                        <p className="font-semibold text-center text-sm text-black">
                            {activeModalCards[activeCategory]?.description || ""}
                        </p>
                    </div>
                </div>
            )}
        </div>
    );
}