import { useState } from "react";
import daskomIcon from "../../../assets/daskom.svg";
import CardPolling from "./CardPolling";
import ModalCard from "./ModalCard";

export default function PollingContent({ activeCategory }) {
    const [selectedCards, setSelectedCards] = useState({}); 

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
        setSelectedCards((prev) => ({
            ...prev,
            [activeCategory]: card,
        }));
    };

    return (
        <div className="relative">
            {/* Konten kategori */}
            <div
                className={`p-4 mt-4 h-[68vh] overflow-y-auto bg-softIvory rounded-lg shadow-lg relative ${
                    selectedCards[activeCategory] ? "backdrop-blur-md" : ""
                }`}
            >
                <div className="grid grid-cols-3 gap-4">
                    {dummyCards.map((card) => (
                        <CardPolling
                            key={card.id}
                            image={card.image}
                            name={card.name}
                            description={card.description}
                            onClick={() => handleCardClick(card)}
                            isDimmed={
                                selectedCards[activeCategory] &&
                                selectedCards[activeCategory].id !== card.id
                            }
                            isSelected={
                                selectedCards[activeCategory]?.id === card.id
                            } 
                        />
                    ))}
                </div>
            </div>

            {selectedCards[activeCategory] && (
                <div className="absolute top-0 left-0 w-full h-full flex items-center justify-center pointer-events-none z-50">
                    <div className="pointer-events-auto">
                        <ModalCard card={selectedCards[activeCategory]} />
                    </div>
                </div>
            )}
        </div>
    );
}