import { useState } from "react";
import iconSwipeLeft from "../../../assets/polling/iconSwipeLeft.svg";
import iconSwipeLeftHover from "../../../assets/polling/iconSwipeLeftHover.svg";
import iconSwipeRight from "../../../assets/polling/iconSwipeRight.svg";
import iconSwipeRightHover from "../../../assets/polling/iconSwipeRightHover.svg";

export default function PollingHeader({ onCategoryClick }) {
    const categories = [
        "Tercantik",
        "Terganteng",
        "Tergalak",
        "Terjaim",
        "Terimut",
        "Tercool",
        "Terpelit",
        "Terasik",
    ];

    const [startIndex, setStartIndex] = useState(0);
    const [isHoverLeft, setIsHoverLeft] = useState(false);
    const [isHoverRight, setIsHoverRight] = useState(false);

    const handleScrollLeft = () => {
        if (startIndex > 0) {
            setStartIndex((prev) => prev - 1);
        }
    };

    const handleScrollRight = () => {
        if (startIndex < categories.length - 5) {
            setStartIndex((prev) => prev + 1);
        }
    };

    return (
        <div className="bg-deepForestGreen rounded-lg py-3 px-4 flex items-center max-w-full overflow-hidden">
            <button
                aria-label="Scroll Left"
                onMouseEnter={() => setIsHoverLeft(true)}
                onMouseLeave={() => setIsHoverLeft(false)}
                onClick={handleScrollLeft}
                className={`w-8 h-8 flex items-center justify-center transition ${
                    startIndex <= 0 ? "opacity-50 cursor-not-allowed" : ""
                }`}
                disabled={startIndex <= 0}
            >
                <img
                    src={isHoverLeft ? iconSwipeLeftHover : iconSwipeLeft}
                    alt="Scroll Left"
                    className="w-full h-full"
                />
            </button>

            <div
                className="flex-1 overflow-hidden relative"
                style={{ display: "flex", justifyContent: "center" }}
            >
                <div
                    className="flex transition-transform duration-500 ease-in-out"
                    style={{
                        transform: `translateX(-${startIndex * 20}%)`,
                        width: `${categories.length * 20}%`,
                    }}
                >
                    {categories.map((category, index) => (
                        <div
                            key={index}
                            className="flex-none cursor-pointer text-center group"
                            style={{ width: "20%" }}
                            onClick={() => onCategoryClick(category)}
                        >
                            <h1 className="font-bold text-white text-lg relative">
                                {category}
                                <span className="absolute left-1/2 bottom-0 h-[2px] bg-white w-[70%] scale-x-0 group-hover:scale-x-100 origin-center transition-transform duration-300 -translate-x-1/2"></span>
                            </h1>
                        </div>
                    ))}
                </div>
            </div>

            <button
                aria-label="Scroll Right"
                onMouseEnter={() => setIsHoverRight(true)}
                onMouseLeave={() => setIsHoverRight(false)}
                onClick={handleScrollRight}
                className={`w-8 h-8 flex items-center justify-center transition ${
                    startIndex >= categories.length - 5
                        ? "opacity-50 cursor-not-allowed"
                        : ""
                }`}
                disabled={startIndex >= categories.length - 5}
            >
                <img
                    src={isHoverRight ? iconSwipeRightHover : iconSwipeRight}
                    alt="Scroll Right"
                    className="w-full h-full"
                />
            </button>
        </div>
    );
}