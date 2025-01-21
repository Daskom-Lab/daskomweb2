export default function ModalCard({ card }) {
    return (
        <div className="shadow-lg bg-softIvory rounded-lg p-4 text-center">
            <img
                src={card.image}
                alt={card.name}
                className="rounded-full w-[165px] h-auto mx-auto"
            />
            <h1 className="mb-7 font-bold text-lg text-black">{card.name}</h1>
            <p className="font-semibold text-sm text-black">{card.description}</p>
        </div>
    );
}