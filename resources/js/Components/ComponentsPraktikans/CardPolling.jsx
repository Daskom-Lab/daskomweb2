export default function CardPolling({
    image,
    name,
    description,
    onClick,
    isDimmed,
    isSelected,
    isDisabled,
}) {
    return (
        <div
            className={`shadow-lg bg-softIvory rounded-lg p-4 text-center transition-all duration-300 ${
                isDimmed ? "opacity-50" : "opacity-100"
            } ${
                isDisabled
                    ? "cursor-not-allowed"
                    : "cursor-pointer hover:scale-105"
            }`}
            onClick={!isDisabled ? onClick : undefined}
        >
            <img
                src={image}
                alt={name}
                className="rounded-full w-[165px] h-auto mx-auto"
            />
            <h1 className="mb-7 font-bold text-lg text-black">{name}</h1>
            <p className="font-semibold text-sm text-black">{description}</p>
        </div>
    );
}