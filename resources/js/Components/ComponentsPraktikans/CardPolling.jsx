export default function CardPolling({
    image,
    name,
    description,
    onClick,
    isDimmed,
    isSelected,
}) {
    return (
        <div
            className={`shadow-lg bg-softIvory rounded-lg p-4 text-center transition-all cursor-pointer hover:scale-105 duration-300 ${
                isDimmed || isSelected ? "opacity-50 blur-[1px]" : "opacity-100"
            }`} 
            onClick={onClick}
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